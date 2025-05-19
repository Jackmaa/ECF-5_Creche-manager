<?php

namespace App\Controller;

use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class AuthController extends BaseController
{
    #[Route('/api/me', name: 'api_me', methods: ['GET'])]
    public function me(): JsonResponse
    {
        //Ajout de l'annotation PHPDoc pour éviter l'autocomplétion de râler
        /** @var \App\Entity\User $user */
        $user = $this->getUserOrThrow();
        // Passage en prod
        // assert($user instanceof \App\Entity\User);


        if (!$user) {
            return $this->json(['error' => 'Unauthorized'], 401);
        }
        return $this->json([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
        ]);
    }
}
