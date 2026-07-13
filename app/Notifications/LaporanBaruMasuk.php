<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Pengaduan;

class LaporanBaruMasuk extends Notification
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
                    ->subject('Ada Laporan Baru Masuk')
                    ->line('Laporan pengaduan baru dari ' . $this->pengaduan->user->name . ' telah masuk.')
                    ->action('Tinjau Laporan', route('pengaduan.show', $this->pengaduan->id))
                    ->line('Harap segera ditindaklanjuti.');
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
            'pelapor' => $this->pengaduan->user->name,
            'message' => 'Laporan baru dari ' . $this->pengaduan->user->name . ': ' . $this->pengaduan->judul_laporan
        ];
    }
}
