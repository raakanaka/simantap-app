<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ExamSubmission;

class ExamSubmissionNotification extends Notification
{
    use Queueable;

    protected $submission;
    protected $type;

    /**
     * Create a new notification instance.
     */
    public function __construct(ExamSubmission $submission, $type = 'submitted')
    {
        $this->submission = $submission;
        $this->type = $type;
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
        $subject = $this->getSubject();
        $message = $this->getMessage();

        return (new MailMessage)
            ->subject($subject)
            ->greeting('Halo ' . $notifiable->name . '!')
            ->line($message)
            ->line('No. Pengajuan: ' . $this->submission->submission_number)
            ->line('Jenis Ujian: ' . $this->submission->examType->name)
            ->line('Status: ' . $this->getStatusLabel())
            ->action('Lihat Detail', url('/submissions/' . $this->submission->id))
            ->line('Terima kasih telah menggunakan SIMANTAP!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'submission_id' => $this->submission->id,
            'submission_number' => $this->submission->submission_number,
            'exam_type' => $this->submission->examType->name,
            'status' => $this->submission->status,
            'type' => $this->type,
            'message' => $this->getMessage(),
        ];
    }

    /**
     * Get notification subject based on type
     */
    private function getSubject()
    {
        switch ($this->type) {
            case 'submitted':
                return 'Pengajuan Ujian Berhasil Disubmit - SIMANTAP';
            case 'verified':
                return 'Pengajuan Ujian Telah Diverifikasi - SIMANTAP';
            case 'rejected':
                return 'Pengajuan Ujian Ditolak - SIMANTAP';
            default:
                return 'Update Pengajuan Ujian - SIMANTAP';
        }
    }

    /**
     * Get notification message based on type
     */
    private function getMessage()
    {
        switch ($this->type) {
            case 'submitted':
                return 'Pengajuan ujian Anda telah berhasil disubmit dan sedang menunggu verifikasi.';
            case 'verified':
                if ($this->submission->status === 'berkas_diterima') {
                    return 'Pengajuan ujian Anda telah diverifikasi dan diterima.';
                } else {
                    return 'Pengajuan ujian Anda telah diverifikasi dan ditolak.';
                }
            case 'rejected':
                return 'Pengajuan ujian Anda ditolak. Silakan perbaiki berkas sesuai alasan yang diberikan.';
            default:
                return 'Ada update pada pengajuan ujian Anda.';
        }
    }

    /**
     * Get status label
     */
    private function getStatusLabel()
    {
        $labels = [
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'berkas_diterima' => 'Berkas Diterima',
            'berkas_ditolak' => 'Berkas Ditolak',
        ];

        return $labels[$this->submission->status] ?? $this->submission->status;
    }
}
