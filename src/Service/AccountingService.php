<?php declare(strict_types=1);

namespace App\Service;

use App\DTO\AccountShort;
use App\DTO\Client;
use App\DTO\ClientInfo;
use App\Entity\Account;
use App\Repository\AccountRepository;
use App\Repository\ClientRepository;
use App\Repository\TransactionRepository;
use Doctrine\ORM\EntityManagerInterface;

class AccountingService
{
    private ClientRepository $clientRepository;
    private AccountRepository $accountRepository;
    private TransactionRepository $transactionRepository;
    private EntityManagerInterface $em;

    public function __construct(
        ClientRepository $clientRepository,
        AccountRepository $accountRepository,
        TransactionRepository $transactionRepository,
        EntityManagerInterface $em
    ) {
        $this->clientRepository = $clientRepository;
        $this->accountRepository = $accountRepository;
        $this->transactionRepository = $transactionRepository;
        $this->em = $em;
    }

    public function getClientDTO(int $id): ?Client
    {
        $client = $this->clientRepository->find($id);
        if ($client === null) {
            return null;
        }

        $info = new ClientInfo($client->getFirstName(), $client->getLastName() ?? '', $client->getCountry());
        $accounts = $client->getAccounts()->map(function(Account $a) {
            return new AccountShort($a->getId(), $a->getCurrency());
        })->toArray();

        return new Client($id, $accounts, $info);
    }
}
