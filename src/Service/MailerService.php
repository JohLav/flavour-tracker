<?php

    namespace App\Service;

    use Symfony\Component\Mailer\MailerInterface;
    use Symfony\Component\Mime\Email;

class MailerService
{
    public function __construct(
        private MailerInterface $mailer,
    ) {
    }

    public function sendEmail(
        string $recipient = "siteadmin@hotmail.fr",
        string $subject = "Voici le sujet de votre message.",
        string $content = '',
        string $text = ''
    ): void {
        $email = (new Email())
            ->from('noreply@mysite.com')
            ->to($recipient)
            ->subject($subject)
            ->text($text)
            ->html($content);
        $this->mailer->send($email);
    }
}
