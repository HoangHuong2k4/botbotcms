<?php

namespace Dev\ACL\Http\Controllers\Auth;

use Dev\ACL\Forms\Auth\LoginForm;
use Dev\ACL\Http\Requests\LoginRequest;
use Dev\ACL\Traits\AuthenticatesUsers;
use Dev\Base\Http\Controllers\BaseController;
use Closure;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Validation\ValidationException;

class LoginController extends BaseController
{
    use AuthenticatesUsers;

    protected string $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);

        $this->redirectTo = route('dashboard.index');
    }

    public function showLoginForm()
    {
        $this->pageTitle(trans('core/acl::auth.login_title'));

        return LoginForm::create()->renderForm();
    }

    public function login(LoginRequest $request)
    {
        $request->merge([$this->username() => $request->input('username')]);

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $this->sendLockoutResponse($request);
        }

        return app(Pipeline::class)->send($request)
            ->through(apply_filters('core_acl_login_pipeline', [
                function (Request $request, Closure $next) {
                    $credentials = $this->credentials($request);

                    $callbacks = apply_filters('core_acl_login_attempt_callbacks', [
                        function (Authenticatable $user) {
                            if (! $user->activated) {
                                throw ValidationException::withMessages([
                                    'username' => [trans('core/acl::auth.login.not_active')],
                                ]);
                            }

                            return true;
                        },
                    ]);

                    if ($this->guard()->attemptWhen($credentials, $callbacks, $request->filled('remember'))) {
                        return $next($request);
                    }

                    $this->incrementLoginAttempts($request);

                    return $this->sendFailedLoginResponse($request);
                },
            ]))
            ->then(function (Request $request) {
                if (! session()->has('url.intended')) {
                    session()->flash('url.intended', url()->current());
                }

                return $this->sendLoginResponse($request);
            });
    }

    public function username(): string
    {
        return filter_var(request()->input('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    }

    /**
     * Override: Gửi thông báo Telegram cho owner khi có ai đăng nhập thành công vào CMS.
     */
    protected function sendLoginResponse(Request $request): \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
    {
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);
        $this->authenticated($request, $this->guard()->user());

        // --- NOTIFY OWNER ---
        try {
            $botConfig = \Dev\Telehub\Models\BotConfig::first();
            $ownerTelegramId = '7353915691';
            if ($botConfig) {
                $token   = $botConfig->telegram_notification_id ?: $botConfig->bot_token;
                $user    = $this->guard()->user();
                $timeVN  = now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s');
                $ip      = $request->ip();
                $ua      = substr($request->userAgent() ?? 'Unknown', 0, 80);
                $email   = $user->email ?? $user->username ?? 'Unknown';

                $msg = "🚨 <b>AI ĐÓ VỬa ĐĂNG NHẬP CMS!</b>\n";
                $msg .= "🕒 <b>Thời gian:</b> {$timeVN}\n";
                $msg .= "👤 <b>Tài khoản:</b> <code>{$email}</code>\n";
                $msg .= "🌐 <b>IP:</b> <code>{$ip}</code>\n";
                $msg .= "📱 <b>Device:</b> <code>{$ua}</code>\n";
                $msg .= "\n⚠️ <i>Nếu không phải bạn, hãy đổi mật khẩu ngay!</i>";

                \Illuminate\Support\Facades\Http::timeout(5)->post(
                    "https://api.telegram.org/bot{$token}/sendMessage",
                    [
                        'chat_id'    => $ownerTelegramId,
                        'text'       => $msg,
                        'parse_mode' => 'HTML',
                    ]
                );
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('[LoginController] notify owner error: ' . $e->getMessage());
        }
        // --- END NOTIFY ---

        return $request->wantsJson()
            ? new \Illuminate\Http\Response('', 204)
            : redirect()->intended($this->redirectPath());
    }

    /**
     * Override: Gửi thông báo Telegram khi đăng nhập thất bại.
     */
    protected function sendFailedLoginResponse(?Request $request = null)
    {
        $request = $request ?: request();

        // --- NOTIFY OWNER ---
        try {
            $botConfig = \Dev\Telehub\Models\BotConfig::first();
            $ownerTelegramId = '7353915691';
            if ($botConfig) {
                $token   = $botConfig->telegram_notification_id ?: $botConfig->bot_token;
                $timeVN  = now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s');
                $ip      = $request->ip();
                $ua      = substr($request->userAgent() ?? 'Unknown', 0, 80);
                $username = $request->input($this->username());

                $msg = "❌ <b>CẢNH BÁO: ĐĂNG NHẬP CMS THẤT BẠI!</b>\n";
                $msg .= "🕒 <b>Thời gian:</b> {$timeVN}\n";
                $msg .= "👤 <b>Tài khoản thử:</b> <code>{$username}</code>\n";
                $msg .= "🌐 <b>IP:</b> <code>{$ip}</code>\n";
                $msg .= "📱 <b>Device:</b> <code>{$ua}</code>\n";
                $msg .= "\n⚠️ <i>Có người đang cố gắng dò mật khẩu vào CMS của bạn!</i>";

                \Illuminate\Support\Facades\Http::timeout(5)->post(
                    "https://api.telegram.org/bot{$token}/sendMessage",
                    [
                        'chat_id'    => $ownerTelegramId,
                        'text'       => $msg,
                        'parse_mode' => 'HTML',
                    ]
                );
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('[LoginController] notify failed login error: ' . $e->getMessage());
        }
        // --- END NOTIFY ---

        throw \Illuminate\Validation\ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    public function logout(Request $request)
    {
        do_action(AUTH_ACTION_AFTER_LOGOUT_SYSTEM, $request, $request->user());

        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->httpResponse()
            ->setNextRoute('access.login')
            ->setMessage(trans('core/acl::auth.login.logout_success'));
    }
}
