<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\IncidentReport;

class IncidentReportCreated extends Notification
{
    use Queueable;

    protected $incidentReport;

    /**
     * Create a new notification instance.
     */
    public function __construct(IncidentReport $incidentReport)
    {
        $this->incidentReport = $incidentReport;
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
        return (new MailMessage)
            ->line('Có báo cáo sự cố mới đã được gửi.')
            ->action('Xem báo cáo', url('/incident-reports'))
            ->line('Cảm ơn bạn đã sử dụng ứng dụng của chúng tôi!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Báo cáo sự cố mới',
            'message' => 'Có báo cáo sự cố mới từ ' . $this->incidentReport->reporter_name . ' tại ' . $this->incidentReport->coordinates,
            'incident_report_id' => $this->incidentReport->id,
            'reporter_name' => $this->incidentReport->reporter_name,
            'coordinates' => $this->incidentReport->coordinates,
            'created_at' => $this->incidentReport->created_at
        ];
    }
}
