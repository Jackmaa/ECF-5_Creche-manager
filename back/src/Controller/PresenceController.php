<?php
namespace App\Controller;

use App\Controller\BaseController;
use App\Entity\Child;
use App\Entity\Presence;
use App\Repository\PresenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/presences')]
class PresenceController extends BaseController {
    #[Route('/{id}/check-in', name: 'presence_check_in', methods: ['POST'])]
    public function checkIn(
        Child $child,
        EntityManagerInterface $em,
        PresenceRepository $presenceRepo
    ): JsonResponse {
        $user = $this->getUserOrThrow();

        if (! $this->isGranted('ROLE_ADMIN')) {
            $this->requireParentOfChild($child);
        }

        $today    = new \DateTime('today');
        $presence = $presenceRepo->findOneBy(['child' => $child, 'date' => $today]);

        if (! $presence) {
            $presence = new Presence();
            $presence->setChild($child);
            $presence->setDate($today);
        }

        $presence->setCheckInTime(new \DateTimeImmutable());
        $presence->setCheckInBy($user);

        $em->persist($presence);
        $em->flush();

        return $this->json(['message' => 'Check-in enregistré']);
    }

    #[Route('/{id}/check-out', name: 'presence_check_out', methods: ['POST'])]
    public function checkOut(
        Child $child,
        EntityManagerInterface $em,
        PresenceRepository $presenceRepo
    ): JsonResponse {
        $user = $this->getUserOrThrow();

        if (! $this->isGranted('ROLE_ADMIN')) {
            $this->requireParentOfChild($child);
        }

        $today    = new \DateTimeImmutable('today');
        $presence = $presenceRepo->findOneBy(['child' => $child, 'date' => $today]);

        if (! $presence) {
            return $this->json(['error' => 'Aucune entrée de présence pour aujourd’hui'], 404);
        }

        $presence->setCheckOutTime(new \DateTimeImmutable());
        $presence->setCheckOutBy($user);

        $em->flush();

        return $this->json(['message' => 'Check-out enregistré']);
    }
}
