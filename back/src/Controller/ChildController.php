<?php
namespace App\Controller;

use App\Controller\BaseController;
use App\Entity\Child;
use App\Repository\ChildRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('api/children')]
class ChildController extends BaseController {
    #[Route('', name: 'children_index', methods: ['GET'])]
    public function index(ChildRepository $repo): JsonResponse {
        $children = $this->getChildrenForUser($repo);

        $data = array_map(fn(Child $child) => [
            'id'        => $child->getId(),
            'prenom'    => $child->getFirstName(),
            'nom'       => $child->getLastName(),
            'birthDate' => $child->getBirthDate()->format('Y-m-d'),
        ], $children);

        return $this->json($data);
    }

    #[Route('/{id}', name: 'children_show', methods: ['GET'])]
    public function show(Child $child): JsonResponse {
        if (! $this->isGranted('ROLE_ADMIN')) {
            $this->requireParentOfChild($child);
        }

        return $this->json([
            'id'        => $child->getId(),
            'prenom'    => $child->getFirstName(),
            'nom'       => $child->getLastName(),
            'birthDate' => $child->getBirthDate()->format('Y-m-d'),
        ]);
    }

    #[Route('', name: 'children_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse {
        $this->requireAdmin();

        $data = json_decode($request->getContent(), true);

        $child = new Child();
        $child->setFirstName($data['firstName'] ?? '');
        $child->setLastName($data['lastName'] ?? '');
        $child->setBirthDate(new \DateTime($data['birthDate'] ?? 'now'));

        $em->persist($child);
        $em->flush();

        return $this->json([
            'message' => 'Enfant créé avec succès',
            'id'      => $child->getId(),
        ], 201);
    }

    #[Route('/{id}', name: 'children_update', methods: ['PATCH'])]
    public function update(
        Child $child,
        Request $request,
        EntityManagerInterface $em
    ): JsonResponse {
        $user = $this->getUserOrThrow();

        if ($this->isGranted('ROLE_ADMIN') === false) {
            $this->requireParentOfChild($child);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['firstName'])) {
            $child->setFirstName($data['firstName']);
        }

        if (isset($data['lastName'])) {
            $child->setLastName($data['lastName']);
        }

        if (isset($data['birthDate'])) {
            try {
                $child->setBirthDate(new \DateTime($data['birthDate']));
            } catch (\Exception $e) {
                return $this->json(['error' => 'Format de date invalide'], 400);
            }
        }

        $em->flush();

        return $this->json([
            'message' => 'Enfant mis à jour avec succès',
            'id'      => $child->getId(),
        ]);
    }

}