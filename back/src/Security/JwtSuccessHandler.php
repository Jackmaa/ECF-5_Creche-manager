<?php
namespace App\Security;

use App\Entity\RefreshToken;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Cookie;

class JwtSuccessHandler implements EventSubscriberInterface
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            Events::AUTHENTICATION_SUCCESS => 'onAuthenticationSuccess',
        ];
    }

    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event): void
    {
        $user = $event->getUser();

        // Ne s'applique qu'aux utilisateurs valides
        if (!$user) return;

        // Génération du refresh token
        $refreshToken = new RefreshToken();
        $refreshToken->setUser($user);
        $refreshToken->setToken(bin2hex(random_bytes(64)));
        $refreshToken->setExpiresAt((new \DateTime())->modify('+7 days'));

        $this->em->persist($refreshToken);
        $this->em->flush();
        $response = $event->getResponse();
        // Ajout du refresh_token dans le cookie

        $cookie = Cookie::create('REFRESH_TOKEN')
            ->withValue($refreshToken->getToken())
            ->withExpires((new \DateTimeImmutable())->modify('+7 days'))
            ->withHttpOnly(true)
            ->withSecure(false) // ⚠️ important en prod : exige HTTPS mettre à false en dev
            ->withPath('/api/token/refresh');

        $response->headers->setCookie($cookie);

        // Ajout du refresh_token dans la réponse
        // $data['refresh_token'] = $refreshToken->getToken();

        $data = $event->getData();
        $event->setData([
        'token' => $data['token']
        ]);
    }
}
