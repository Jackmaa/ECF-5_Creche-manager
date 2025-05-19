<?php

namespace App\Controller;

use App\Entity\RefreshToken;
use App\Repository\RefreshTokenRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class RefreshTokenController extends AbstractController
{
    #[Route('/api/token/refresh', name: 'api_token_refresh', methods: ['POST'])]
    public function refreshToken(
        Request $request,
        RefreshTokenRepository $refreshTokenRepo,
        JWTTokenManagerInterface $jwtManager,
        EntityManagerInterface $em
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        //Use this to get the refresh token from the request body
        // $refreshTokenValue = $data['refresh_token'] ?? null;

        // Use this to get the refresh token from the cookie
        $refreshTokenValue = $request->cookies->get('REFRESH_TOKEN');

        if (!$refreshTokenValue) {
            return $this->json(['error' => 'Missing refresh_token'], 400);
        }

        $refreshToken = $refreshTokenRepo->findOneBy(['token' => $refreshTokenValue]);

        if (!$refreshToken || $refreshToken->getExpiresAt() < new \DateTimeImmutable()) {
            return $this->json(['error' => 'Refresh token invalide ou expiré'], 401);
        }

        $user = $refreshToken->getUser();

        // Nouveau JWT
        $newJwt = $jwtManager->create($user);

        // (Optionnel) Régénérer un refresh token unique
        $refreshToken->setToken(bin2hex(random_bytes(64)));
        $refreshToken->setExpiresAt((new \DateTime())->modify('+7 days'));

        $em->flush();

        return $this->json([
            'token' => $newJwt,
            'refresh_token' => $refreshToken->getToken(),
        ]);
    }
}
