<?php
namespace App\Controller;

use App\Controller\BaseController;
use App\Service\PresenceGeneratorService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/admin')]
class AdminPresenceController extends BaseController {
    #[Route('/generate-week', name: 'admin_generate_week', methods: ['POST'])]
    public function generateWeek(PresenceGeneratorService $service): JsonResponse {
        $this->requireAdmin();

        $presences = $service->generateWeekPresences();

        return $this->json([
            'message' => count($presences) . ' présences générées avec succès.',
        ]);
    }
}
