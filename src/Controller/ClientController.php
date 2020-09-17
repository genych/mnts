<?php

namespace App\Controller;

use App\Service\AccountingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @Route("/client/{id<\d+>}", methods={"GET"})
     * @param AccountingService $service
     * @param int               $id
     * @return JsonResponse
     */
    public function getClient(AccountingService $service, int $id): JsonResponse
    {
        $client = $service->getClientDTO($id);
        if (!$client) {
// TODO: exception listener, proper codes
            return $this->json(['error' => 'client not found'], 400);
        }

        return $this->json($client);
    }

}
