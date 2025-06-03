<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Child;
use App\Repository\ChildRepository;
use Doctrine\Common\Collections\Collection;
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

    protected function requireParentOfChild(Child $child): void
    {
        $user = $this->getUserOrThrow();

        if (!$user->getChildren()->contains($child)) {
            throw new AccessDeniedHttpException("Vous n'êtes pas responsable de cet enfant.");
        }
    }

    protected function getChildrenForUser(ChildRepository $repo): array
    {
        $user = $this->getUserOrThrow();

        // Admin peut voir tous les enfants
        if ($this->isGranted('ROLE_ADMIN')) {
            return $repo->findAll();
        }

        // Parent → uniquement ses enfants
        return $user->getChildren()->toArray();
    }


}
