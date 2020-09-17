<?php

namespace App\Controller;

use App\DTO\Transfer;
use App\Service\AccountingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/account/{id<\d+>}", methods={"GET"})
     * @param AccountingService $service
     * @param int               $id
     * @return JsonResponse
     */
    public function getAccount(AccountingService $service, int $id): JsonResponse
    {
        $account = $service->getAccountDTO($id);
        if (!$account) {
            return $this->json(['error' => 'account not found'], 400);
        }

        return $this->json($account);
    }

    /**
     * @Route("/account/{id<\d+>}/history", methods={"GET"})
     * @param AccountingService $service
     * @param Request           $request
     * @param int               $id
     * @return JsonResponse
     */
    public function getHistory(AccountingService $service, Request $request, int $id): JsonResponse
    {
        $offset = (int)$request->query->get('offset');
        $limit = (int)$request->query->get('limit', AccountingService::HISTORY_DEFAULT_LIMIT);

        $history = $service->getAccountHistory($id, $offset, $limit);
        if (!$history) {
            return $this->json(['error' => 'account not found'], 400);
        }

        return $this->json($history);
    }

    /**
     * @Route("/transfer", methods={"POST"})
     * @param Request             $request
     * @param AccountingService   $service
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function transfer(Request $request, AccountingService $service, SerializerInterface $serializer): JsonResponse
    {
        /** @var Transfer $transferRequest */
        $transferRequest = $serializer->deserialize($request->getContent(), Transfer::class, 'json');

        $transaction = $service->transfer($transferRequest);

        if (!$transaction) {
            return $this->json(['error' => 'oops'], 400);
        }

        return $this->json(['id' => $transaction->getId()]);
    }

}
