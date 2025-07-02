<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Calamities;
class CalamityCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $calamity;
    public function __construct(Calamities $calamity)
    {
        $this->calamity = $calamity;
    }
     public function build()
    {
         $text = "🌪 Cảnh báo thiên tai mới\n"
              . "Tên: {$this->calamity->name}\n"
              . "Loại thiên tai: {$this->calamity->risk_level->type_of_calamity->name}\n"
              . "Địa điểm: {$this->calamity->address}\n"
              . "Cấp độ rủi ro: " . ($this->calamity->risk_level->name ?? 'Chưa xác định') . "\n"
              . "Thời gian: {$this->calamity->time}\n\n"
              . "Vui lòng truy cập hệ thống để xem chi tiết.";

        return $this->subject('Cảnh báo thiên tai mới')
                    ->html(nl2br(e($text))); // Dùng HTML nhưng vẫn hiển thị text
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Cảnh báo thiên tai mới',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
