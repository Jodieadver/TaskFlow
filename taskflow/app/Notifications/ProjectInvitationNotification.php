<?php

namespace App\Notifications;

use App\Models\ProjectInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProjectInvitationNotification extends Notification
{
    use Queueable;
    public function __construct(public ProjectInvitation $invitation) {}

    public function via($notifiable): array { return ['mail']; }

    public function toMail($notifiable): MailMessage
    {
        $url = route('invites.accept', $this->invitation->token);
        return (new MailMessage)
            ->subject('You are invited to join a project')
            ->greeting('Hello!')
            ->line('You have been invited to join project: '.$this->invitation->project->title)
            ->action('Accept Invitation', $url)
            ->line('This link expires on: '.$this->invitation->expires_at?->toDayDateTimeString());
    }
}
