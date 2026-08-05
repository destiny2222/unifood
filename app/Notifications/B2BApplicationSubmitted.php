<?php

namespace App\Notifications;

use App\Models\Kyc;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class B2BApplicationSubmitted extends Notification
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
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'New B2B trade account registration submitted by ' . ($this->kyc->user->name ?? 'applicant') . ' for ' . $this->kyc->company_name,
            'kyc_id' => $this->kyc->id,
            'company_name' => $this->kyc->company_name,
            'company_registration_number' => $this->kyc->company_registration_number,
            'business_type' => $this->kyc->business_type,
            'created_at' => now()->toDateTimeString(),
        ];
    }
}
