<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use InvalidArgumentException;
use RuntimeException;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class EmailVerifier
{
    public function __construct(
        private readonly VerifyEmailHelperInterface $verifyEmailHelper,
        private readonly MailerInterface $mailer,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @param string $verifyEmailRouteName
     * @param UserInterface $user
     * @param TemplatedEmail $email
     * @return void
     */
    public function sendEmailConfirmation(
        string $verifyEmailRouteName,
        UserInterface $user,
        TemplatedEmail $email
    ): void {
        try {
            $signatureComponents = $this->verifyEmailHelper->generateSignature(
                $verifyEmailRouteName,
                $user->getId(),
                $user->getEmail()
            );

            $context = $email->getContext();
            $context['signedUrl'] = $signatureComponents->getSignedUrl();
            $context['expiresAtMessageKey'] = $signatureComponents->getExpirationMessageKey();
            $context['expiresAtMessageData'] = $signatureComponents->getExpirationMessageData();

            $email->context($context);

            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            // Log the error and notify the user/admin
            throw new RuntimeException("Failed to send verification email.", 0, $e);
        }
    }

    /**
     * @param Request $request
     * @param UserInterface $user
     * @return void
     */
    public function handleEmailConfirmation(
        Request $request,
        UserInterface $user
    ): void {
        if (!$user instanceof User || empty($user->getId()) || empty($user->getEmail())) {
            throw new InvalidArgumentException('Invalid user provided.');
        }

        try {
            $this->verifyEmailHelper->validateEmailConfirmation(
                $request->getUri(),
                $user->getId(),
                $user->getEmail()
            );

            $user->setIsVerified(true);

            $this->entityManager->flush();
        } catch (VerifyEmailExceptionInterface $e) {
            if (str_contains($e->getReason(), 'expired')) {
                throw new RuntimeException('The link to verify your email has expired. Please request a new link.');
            }
            // Provide a message to the user and an option to resend the email
            throw new RuntimeException($e->getReason(), 0, $e);
        } catch (Exception $e) {
            // Handle generic database or other errors
            throw new RuntimeException('An unexpected error occurred.', 0, $e);
        }
    }
}
