<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Pengaduan;

class StatusPengaduanUpdated extends Notification
{
    use Queueable;

    public $pengaduan;

    /**
     * Create a new notification instance.
     */
    public function __construct(Pengaduan $pengaduan)
    {
        $this->pengaduan = $pengaduan;
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
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Status Pengaduan Anda Diperbarui')
                    ->line('Status pengaduan Anda dengan judul "' . $this->pengaduan->judul_laporan . '" telah diperbarui menjadi: ' . strtoupper($this->pengaduan->status))
                    ->action('Lihat Detail', route('pengaduan.show', $this->pengaduan->id))
                    ->line('Terima kasih telah menggunakan layanan kami!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'pengaduan_id' => $this->pengaduan->id,
            'judul_laporan' => $this->pengaduan->judul_laporan,
            'status' => $this->pengaduan->status,
            'message' => 'Status pengaduan Anda berubah menjadi: ' . strtoupper($this->pengaduan->status)
        ];
    }
}
