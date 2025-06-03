<?php
namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RegistrationMailer {
    public function __construct(
        private MailerInterface $mailer,
        private UrlGeneratorInterface $urlGenerator,
        private EntityManagerInterface $em,
    ) {}

    public function sendInvitation(User $user): void {
        $token = bin2hex(random_bytes(32));
        $user->setRegistrationToken($token);
        $this->em->flush();

        $url = $this->urlGenerator->generate('user_validate', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

        $email = (new TemplatedEmail())
            ->from('admin@creche.local')
            ->to($user->getEmail())
            ->subject('Choisissez votre mot de passe')
            ->htmlTemplate('emails/registration_invite.html.twig')
            ->context(['url' => $url]);

        $this->mailer->send($email);
    }
}
?>
