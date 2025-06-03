<?php
namespace App\Controller;

use App\Controller\BaseController;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class AuthController extends BaseController {
    #[Route('/api/me', name: 'api_me', methods: ['GET'])]
    public function me(): JsonResponse {
        //Ajout de l'annotation PHPDoc pour éviter l'autocomplétion de râler
        /** @var \App\Entity\User $user */
        $user = $this->getUserOrThrow();
        // Passage en prod
        // assert($user instanceof \App\Entity\User);

        if (! $user) {
            return $this->json(['error' => 'Unauthorized'], 401);
        }
        return $this->json([
            'id'    => $user->getId(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
        ]);
    }
    #[Route('/api/users/validate/{token}', name: 'user_validate', methods: ['GET', 'POST'])]
    public function validateAccount(
        string $token,
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher
    ): JsonResponse {
        $user = $em->getRepository(User::class)->findOneBy(['registrationToken' => $token]);

        if (! $user) {
            return $this->json(['error' => 'Invalid or expired token.'], 400);
        }

        if ($request->isMethod('POST')) {
            $data     = json_decode($request->getContent(), true);
            $password = $data['password'] ?? null;

            if (! $password) {
                return $this->json(['error' => 'Password is required.'], 400);
            }

            $user->setPassword($hasher->hashPassword($user, $password));
            $user->setRegistrationToken(null);
            $em->flush();

            return $this->json(['success' => 'Account activated!']);
        }

        return $this->json(['message' => 'Token is valid. You can now set your password.']);
    }

}
