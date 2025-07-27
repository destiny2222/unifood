<?php

namespace App\Notifications;

use App\Models\OrderItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentSuccessNotification extends Notification
{
    use Queueable;

    protected $orderItemIds;
    protected $user;

    /**
     * Create a new notification instance.
     */
    public function __construct($orderItemIds, $user)
    {
        $this->orderItemIds = $orderItemIds;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        
        $orderItems = OrderItem::whereIn('id', $this->orderItemIds)->get();
        $user = $this->user;

        // You may want to calculate total amount and paid_at date
        $amount = $orderItems->sum('price');
        $paidAt = now();

        return (new MailMessage)
            ->subject('Payment Success')
            ->view(
                'emails.payment_success',
                [
                    'user' => $user,
                    'orderItems' => $orderItems,
                    'amount' => $amount,
                    'paid_at' => $paidAt,
                ]
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
