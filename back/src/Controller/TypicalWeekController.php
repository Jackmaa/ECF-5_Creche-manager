<?php
namespace App\Controller;

use App\Controller\BaseController;
use App\Entity\Child;
use App\Entity\TypicalWeek;
use App\Repository\TypicalWeekRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/semaine-type')]
class TypicalWeekController extends BaseController {
    #[Route('/{id}', name: 'typical_week_show', methods: ['GET'])]
    public function show(Child $child, TypicalWeekRepository $repo): JsonResponse {
        $user = $this->getUserOrThrow();

        if (! $this->isGranted('ROLE_ADMIN')) {
            $this->requireParentOfChild($child);
        }

        $week = $repo->findOneBy(['child' => $child]);

        if (! $week) {
            return $this->json(['message' => 'Aucune semaine type définie'], 404);
        }

        return $this->json($week->getPlanning());
    }

    #[Route('/{id}', name: 'typical_week_update', methods: ['PATCH'])]
    public function update(
        Child $child,
        Request $request,
        TypicalWeekRepository $repo,
        EntityManagerInterface $em
    ): JsonResponse {
        $user = $this->getUserOrThrow();

        if (! $this->isGranted('ROLE_ADMIN')) {
            $this->requireParentOfChild($child);
        }

        $data = json_decode($request->getContent(), true);

        $week = $repo->findOneBy(['child' => $child]) ?? new TypicalWeek();
        $week->setChild($child);
        $week->setPlanning($data);

        $em->persist($week);
        $em->flush();

        return $this->json(['message' => 'Semaine type mise à jour']);
    }

    #[Route('/{id}/planning', name: 'typical_week_preview', methods: ['GET'])]
    public function getWeekView(Child $child, TypicalWeekRepository $repo): JsonResponse {
        $user = $this->getUserOrThrow();

        if (! $this->isGranted('ROLE_ADMIN')) {
            $this->requireParentOfChild($child);
        }

        $week = $repo->findOneBy(['child' => $child]);

        if (! $week) {
            return $this->json(['error' => 'Aucune semaine type définie'], 404);
        }

        $planning = $week->getPlanning();
        $today    = new \DateTimeImmutable();
        $days     = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];

        $result = [];
        foreach ($days as $i => $key) {
            $date          = $today->modify(">{$i} day")->format('Y-m-d');
            $result[$date] = $planning[$key] ?? null;
        }

        return $this->json($result);
    }
}
