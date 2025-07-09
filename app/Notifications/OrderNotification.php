<?php

namespace App\Notifications;

use App\Models\OrderItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $orderItemIds;
    protected $user;

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
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
     public function toMail($notifiable)
    {
        $orderItems = OrderItem::whereIn('id', $this->orderItemIds)->get();
        $user = $this->user;

        $orderDetails = $orderItems->map(function ($item) {
            return [
                'product_name' => $item->product->title,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ];
        })->toArray();

        return (new MailMessage)
            ->view('vendor.notifications.email', [
                'actionText' => 'New Order Notification',
                'actionUrl' => url('/admin/order/list'),
                'userName' => $user->name,
                'orderDetails' => $orderDetails,
            ])
            ->subject('New Order Notification');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $orderItems = OrderItem::whereIn('id', $this->orderItemIds)->get();
        $user = $this->user;

        return [
            'message' => 'New order placed by ' . $user->name,
            'order_item_ids' => $this->orderItemIds,
            'user_id' => $user->id,
            'details' => $orderItems->map(function ($item) {
                return [
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ];
            })->toArray(),
            'created_at' => now()->toDateTimeString(),
        ];
    }
}
