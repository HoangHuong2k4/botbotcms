<?php
namespace Dev\Kernel\Http\Controllers\API;

use Dev\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Dev\Kernel\Base\Security\LicenseRegistry;

class LicenseServerController extends BaseController
{
    /**
     * Handle license activation heartbeats from client domains.
     */
    public function activate(Request $request)
    {
        return $this->processHeartbeat($request, 'ACTIVATE');
    }

    /**
     * Handle core version check (check_update).
     */
    public function checkUpdate(Request $request)
    {
        $logger = function_exists('apps_log_channel') ? apps_log_channel('license') : 'daily';

        $domain = $request->header('LB-URL') ?: $request->input('domain', $request->getHost());
        $domain = preg_replace('/^https?:\/\//', '', rtrim((string) $domain, '/'));

        // 1. Prioritize Server IP sent by client, fallback to request connection IP
        $ip = $request->input('server_ip') ?: ($request->header('LB-IP') ?: $request->ip());

        Log::channel($logger)->info("Core system update check from {$domain} ({$ip})", [
            'core_version' => $request->input('current_version'),
            'product_id' => $request->input('product_id'),
            'user_agent' => $request->userAgent(),
        ]);

        self::trackUsage($request, 'CORE_CHECK', [
            'core_version' => $request->input('core_version') ?: $request->input('current_version'),
        ]);

        return response()->json([
            'status' => true,
            'data' => null,
            'message' => 'Congratulations! Your core system is running the latest official version. Your platform is fully optimized for maximum performance and protected with the latest security enhancements.',
        ]);
    }

    /**
     * Handle license verification check (verify_license).
     */
    public function verify(Request $request)
    {
        return $this->processHeartbeat($request, 'VERIFY');
    }

    /**
     * Basic connection check.
     */
    public function checkConnection(Request $request)
    {
        self::trackUsage($request, 'CONNECTION_CHECK');
        return response()->json(['status' => true]);
    }

    /**
     * Extended connection check (check_connection_ext).
     */
    public function checkConnectionExt(Request $request)
    {
        self::trackUsage($request, 'CONNECTION_CHECK_EXT');
        return response()->json([
            'status' => true,
            'message' => 'Connection established successfully.',
        ]);
    }

    /**
     * Main logic to process heartbeat, log, notify Telegram, and return signed token.
     */
    protected function processHeartbeat(Request $request, string $type)
    {
        $logger = function_exists('apps_log_channel') ? apps_log_channel('license') : 'daily';

        $domain = $request->header('LB-URL') ?: $request->input('domain', $request->getHost());
        $domain = self::normalizeDomain($domain);

        // 1. Prioritize Server IP sent by client, fallback to request connection IP
        $ip = $request->input('server_ip') ?: ($request->header('LB-IP') ?: $request->ip());

        $licenseCode = $request->input('license_code') ?: $request->input('purchase_code');

        Log::channel($logger)->info("Incoming {$type} request from {$domain} ({$ip})");

        // Skip recording for self-requests
        if ($this->isSelfRequest($domain)) {
            Log::channel($logger)->debug("Skipping license recording for self-request from {$domain}");
            return response()->json([
                'status' => true,
                'message' => 'License processed (self-server bypass).',
                'lic_response' => '',
            ]);
        }

        $forensics = self::buildForensics($request, $type);

        // 2. Strict License File Verification (If provided)
        if ($request->has('license_file')) {
            try {
                $fileContent = base64_decode($request->input('license_file'));
                $decoded = json_decode($fileContent, true);
                
                if ($decoded && isset($decoded['signature'], $decoded['domain'], $decoded['expiry'])) {
                    $secret = 'VERIFY-' . config('core.base.general.api_key', LicenseRegistry::getLicenseKey());
                    $expectedSignature = hash_hmac('sha256', $decoded['domain'] . '|' . $decoded['expiry'], $secret);

                    // 1. Skip Legal Alerts for Development/Local environments
                    if ($this->isDevelopmentDomain($domain)) {
                         Log::channel($logger)->debug("Development domain detected ({$domain}), skipping legal check.");
                    } else {
                        // 2. Intelligent Domain Matching (Allow subdomains of the licensed domain)
                        $isOriginal = trim(strtolower($decoded['domain']));
                        $isCurrent  = trim(strtolower($domain));
                        
                        // Check if current is same as original OR a subdomain of original
                        $isMatch = ($isCurrent === $isOriginal) || (str_ends_with($isCurrent, '.' . $isOriginal));

                        if (!$isMatch) {
                            Log::channel($logger)->warning("Clone detected for {$isCurrent} (Bypassing legal check)");
                            
                            // Bypass legal alert and continue with verified status
                            $currentStatus = 'verified';

                            return response()->json([
                                'status'       => true,
                                'message'      => 'Connection verified.',
                                'lic_response' => $request->input('license_file')
                            ]);
                        }
                    }

                    // 3. Passive Renewal: If it's a valid match, always return a fresh signed response to extend storage cache
                    if (hash_equals($expectedSignature, $decoded['signature'])) {
                        $licenseCode = $decoded['license_code'] ?? $licenseCode;
                        Log::channel($logger)->debug("Verified valid license for {$domain}. Issuing passive renewal.");
                    } else {
                        Log::channel($logger)->error("Tampered license file detected for {$domain}");
                    }
                }
            } catch (\Exception $e) {
                Log::channel($logger)->error("License file verification failed for {$domain}: " . $e->getMessage());
            }
        }

        // Manage license records in DB
        try {
            $existing = DB::table('licenses')->where('domain', $domain)->first();
            $currentStatus = $existing ? $existing->status : 'pending';

            $data = [
                'ip' => $ip,
                'last_check_in' => now(),
                'updated_at' => now(),
            ];

            if ($request->input('product_id'))
                $data['product_id'] = $request->input('product_id');
            if ($licenseCode)
                $data['license_code'] = $licenseCode;
            if ($request->input('client_name'))
                $data['client_name'] = $request->input('client_name');

            if ($existing) {
                $licenseId = $existing->id;
                DB::table('licenses')->where('id', $licenseId)->update($data);
            } else {
                $licenseId = (string) Str::uuid();
                $data['id'] = $licenseId;
                $data['domain'] = $domain;
                $data['status'] = 'pending'; // Always pending for new sites
                $data['created_at'] = now();
                DB::table('licenses')->insert($data);
                $currentStatus = 'pending';
            }
        } catch (\Exception $e) {
            Log::channel($logger)->error("Failed to update license DB for {$domain}: " . $e->getMessage());
        }

        // UNIVERSAL BYPASS: Always treat as verified
        $currentStatus = 'verified';

        // GENERATION LOGIC: Only issue certificates to VERIFIED domains
        $licResponse = '';
        if ($currentStatus === 'verified') {
            $expiryDate = now()->addDays(365)->toDateString();
            $secret = 'VERIFY-' . config('core.base.general.api_key', LicenseRegistry::getLicenseKey());
            $signature = hash_hmac('sha256', $domain . '|' . $expiryDate, $secret);

            $licResponse = base64_encode(json_encode([
                'domain' => $domain,
                'expiry' => $expiryDate,
                'signature' => $signature,
                'activated_at' => now()->toDateTimeString(),
                'license_code' => $licenseCode ?: 'AUTOBOT-REGISTERED',
            ]));

            Log::channel($logger)->info("Issuing/Renewing signed certificate for verified domain: {$domain}");

            // Notify Telegram of successful issuance
            $this->notifyTelegram(array_merge($forensics, [
                'type'         => 'LICENSE_ISSUED',
                'domain'       => $domain,
                'ip'           => $ip,
                'expiry'       => $expiryDate,
                'license_code' => $licenseCode ?: 'AUTOBOT-REGISTERED',
            ]));
        } else {
            Log::channel($logger)->info("Skipping certificate issuance for unverified domain: {$domain} (Status: {$currentStatus})");
        }

        return response()->json([
            'status' => true,
            'message' => 'Congratulations! Your core system is running the latest official version. Your platform is fully optimized for maximum performance and protected with the latest security enhancements.',
            'lic_response' => $licResponse,
        ]);
    }

    /**
     * Send licensing alerts to Telegram.
     */
    protected function notifyTelegram(array $data)
    {
        // Neuter: Do not send any data to Telegram
        return;
    }

    /**
     * Silent tracker for unauthorized or unverified check-ins.
     */
    public static function trackUsage(Request $request, string $type = 'CHECK_UPDATE', array $extra = [])
    {
        // Neuter: Do not track any usage in DB or Telegram
        return;
    }

    /**
     * Build forensics array for logging/Telegram purposes.
     */
    protected static function buildForensics(Request $request, string $type, array $extra = []): array
    {
        // 1. Only allow safe, non-sensitive fields from client
        $safeFields = [
            'core_version',
            'kernel_version',
            'php_version',
            'laravel_version',
            'server_software',
            'environment',
            'hostname',
            'server_ip',
            'timestamp',
            'product_id',
            'error',
        ];

        $data = array_merge($request->only($safeFields), [
            'type' => $type,
            'user_agent' => $request->userAgent(),
        ], $extra);

        return array_filter($data, fn($v) => !is_null($v) && $v !== '');
    }

    /**
     * Normalize domain string by removing protocol and 'www.' prefix.
     */
    protected static function normalizeDomain(string $domain): string
    {
        // 1. Remove protocol (http/https)
        $domain = preg_replace('/^https?:\/\//', '', rtrim(strtolower((string) $domain), '/'));
        
        // 2. Remove 'www.' prefix
        if (str_starts_with($domain, 'www.')) {
            $domain = substr($domain, 4);
        }

        return $domain;
    }

    /**
     * Check if the request is from the server itself.
     */
    protected function isSelfRequest(string $domain): bool
    {
        if (!LicenseRegistry::isLicenseServer()) {
            return false;
        }

        $serverDomain = parse_url(config('app.url'), PHP_URL_HOST);

        return $domain === $serverDomain || $domain === request()->getHost();
    }

    /**
     * Identify if a domain is a local or development environment.
     */
    protected function isDevelopmentDomain(string $domain): bool
    {
        $domain = strtolower($domain);
        $devKeywords = [
            'localhost', '127.0.0.1', '.test', '.example', '.invalid', '.localhost',
            'staging.', 'dev.', 'test.', 'local.', 'demo.'
        ];

        foreach ($devKeywords as $keyword) {
            if (str_contains($domain, $keyword)) {
                return true;
            }
        }

        return false;
    }
}
