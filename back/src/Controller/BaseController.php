<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Child;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

abstract class BaseController extends AbstractController
{
    /**
     * @return User
     */
    protected function getUserOrThrow(): User
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw new UnauthorizedHttpException('Bearer', 'Utilisateur non authentifié');
        }

        return $user;
    }

    protected function requireRole(string $role): void
    {
        if (!$this->isGranted($role)) {
            throw new AccessDeniedHttpException("Accès réservé à {$role}");
        }
    }

    protected function requireAdmin(): void
    {
        $this->requireRole('ROLE_ADMIN');
    }

    protected function requireParent(): void
    {
        $this->requireRole('ROLE_PARENT');
    }

    // protected function requireParentOfChild(Child $child): void
    // {
    //     $user = $this->getUserOrThrow();
    //     $parents = $child->getParents(); // assuming ManyToMany or OneToMany

    //     if (!$parents->contains($user)) {
    //         throw new AccessDeniedHttpException("Vous n'êtes pas responsable de cet enfant.");
    //     }
    // }
}
