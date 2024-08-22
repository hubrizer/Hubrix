<?php

namespace App\Backend\Jobs;

use Hubrix\Core\Interfaces\JobInterface;

class SendEmailJob implements JobInterface
{
    protected string $recipientEmail;
    protected string $subject;
    protected string $message;

    public function __construct(string $recipientEmail, string $subject, string $message)
    {
        $this->recipientEmail = $recipientEmail;
        $this->subject = $subject;
        $this->message = $message;
    }

    public function handle(): void
    {
        // Logic to send the email
        mail($this->recipientEmail, $this->subject, $this->message);
    }

    public function maxAttempts(): int
    {
        return 3;
    }

    public function retryDelay(): int
    {
        return 60; // Retry after 60 seconds
    }

    public function serialize(): array
    {
        return [
            'recipientEmail' => $this->recipientEmail,
            'subject' => $this->subject,
            'message' => $this->message,
        ];
    }

    public function unserialize(array $data): void
    {
        $this->recipientEmail = $data['recipientEmail'];
        $this->subject = $data['subject'];
        $this->message = $data['message'];
    }
}
