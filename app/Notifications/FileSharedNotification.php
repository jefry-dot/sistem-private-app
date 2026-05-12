<?php

namespace App\Notifications;

use App\Models\File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FileSharedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $file;

    public function __construct(File $file)
    {
        $this->file = $file;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('New File Shared: ' . $this->file->original_name)
                    ->greeting('Hello ' . $notifiable->name . ',')
                    ->line('A new file has been securely shared with you.')
                    ->line('File Name: ' . $this->file->original_name)
                    ->action('View File', route('client.dashboard'))
                    ->line('Thank you for using our application!');
    }
}
