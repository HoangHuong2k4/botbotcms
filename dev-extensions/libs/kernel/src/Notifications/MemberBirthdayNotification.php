<?php
namespace Dev\Kernel\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\URL;
use Illuminate\Queue\InteractsWithQueue;

use Dev\Base\Facades\EmailHandler;

class MemberBirthdayNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public function __construct(public $event)
    {
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        try {
            if (!blank($notifiable->email)) {
                $emailHandler = EmailHandler::setModule(KERNEL_MODULE_SCREEN_NAME);
                if ($emailHandler->templateEnabled('member-birthday-reminder-notification', 'kernel')) {
                    $emailHandler
                        ->setType("kernel")
                        ->setPlatformPath("dev-extensions")
                        ->setVariableValues([
                            'email',
                            $notifiable->email
                        ]);
                }

                return (new MailMessage())
                    ->view(['html' => new HtmlString($emailHandler?->getContent() ?: '')])
                    ->subject($emailHandler?->getSubject() ?: 'Member Birthday Notification');
            }

            return (new MailMessage())->subject('Member Birthday Notification');
        } catch (\Throwable $th) {
            return (new MailMessage())->subject('Error Notification')->line('An internal processing error occurred.');
        }
    }
}
