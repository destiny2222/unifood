<?php

namespace App\Notifications;

use App\Models\Kyc;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class B2BApplicationStatusNotification extends Notification
{
    use Queueable;

    protected $kyc;

    /**
     * Create a new notification instance.
     */
    public function __construct(Kyc $kyc)
    {
        $this->kyc = $kyc;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $status = $this->kyc->status;
        $companyName = $this->kyc->company_name;
        $notes = $this->kyc->status_notes;

        $mail = new MailMessage;

        if ($status === 'approved') {
            $mail->subject('Mightyolu Business Account Approved!')
                 ->greeting("Hello {$notifiable->name},")
                 ->line("Congratulations! Your trade account application for **{$companyName}** has been approved.")
                 ->line("You are assigned to the **{$this->kyc->pricing_tier}** tier.")
                 ->line('On your next login, you will see trade pricing and B2B features unlocked.')
                 ->action('Go to Store', url('/'))
                 ->line('Thank you for choosing Mightyolu!');
        } elseif ($status === 'rejected') {
            $mail->subject('Business Account Application Update')
                 ->greeting("Hello {$notifiable->name},")
                 ->line("Thank you for your interest in registering a trade account for **{$companyName}**.")
                 ->line('Unfortunately, your application was not approved at this time.')
                 ->line("**Reason/Notes:** " . ($notes ?? 'No details provided.'))
                 ->line('You can review and resubmit your details from your account dashboard.')
                 ->action('View Dashboard', url('/dashboard'))
                 ->line('Please contact support if you have any questions.');
        } else {
            // info_requested
            $mail->subject('Action Required: Business Account Application Info Request')
                 ->greeting("Hello {$notifiable->name},")
                 ->line("We are reviewing your trade account application for **{$companyName}**.")
                 ->line('We require some additional information to complete your registration:')
                 ->line("**Details needed:** " . ($notes ?? 'Please verify registration details.'))
                 ->line('Please click the button below to update and resubmit your application.')
                 ->action('Resubmit Details', url('/dashboard'))
                 ->line('Thank you for your cooperation!');
        }

        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Your B2B trade account application status was updated to: ' . $this->kyc->status,
            'kyc_id' => $this->kyc->id,
            'status' => $this->kyc->status,
            'status_notes' => $this->kyc->status_notes,
            'pricing_tier' => $this->kyc->pricing_tier,
            'created_at' => now()->toDateTimeString(),
        ];
    }
}
