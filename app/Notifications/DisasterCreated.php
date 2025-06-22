<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DisasterCreated extends Notification
{
    use Queueable;
    public $disaster;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
         $this->disaster = $disaster;
         $this->receiverName = $receiverName;
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
        return (new MailMessage)
            ->subject('Thông báo: Thiên tai mới')
            ->greeting('Xin chào ' . $this->receiverName . '!')
            ->line('Hệ thống vừa ghi nhận một thiên tai mới:')
            ->line('Tên: ' . $this->calamity->name)
            ->line('Thời gian: ' . $this->disaster->time)
            ->line('Địa điểm: ' . $this->disaster->address)
            ->action('Xem chi tiết', url('localhost:8000/'))
            ->line('Cảm ơn bạn đã quan tâm đến công tác phòng chống thiên tai.');
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
