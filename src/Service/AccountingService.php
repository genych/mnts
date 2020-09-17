<?php declare(strict_types=1);

namespace App\Service;

use App\DTO\AccountFull;
use App\DTO\AccountShort;
use App\DTO\Client;
use App\DTO\ClientInfo;
use App\DTO\Transaction;
use App\DTO\TransactionHistory;
use App\DTO\Transfer;
use App\Entity\Account;
use App\Repository\AccountRepository;
use App\Repository\ClientRepository;
use App\Repository\TransactionRepository;
use App\Util\Converter;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

class AccountingService
{
    public const HISTORY_DEFAULT_LIMIT = 100;

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

    public function getAccountDTO(int $id): ?AccountFull
    {
        $account = $this->accountRepository->find($id);
        if ($account === null) {
            return null;
        }

        return new AccountFull(
            $id,
            $account->getCurrency(),
            $account->getClient()->getId(),
            Converter::fromMinorUnits(
            $account->getBalance())
        );
    }

    public function getAccountHistory(int $id, int $offset, int $limit): ?TransactionHistory
    {
        $account = $this->accountRepository->find($id);
        if ($account === null) {
            return null;
        }

        $total = $this->transactionRepository->countByAccount($id);
        $transactions = $this->transactionRepository->findByAccount($id, $limit, $offset);

        $dtos = [];
        foreach ($transactions as $transaction) {
            $dtos[] = new Transaction(
                $transaction->getId(),
                Converter::fromMinorUnits($transaction->getAmount()),
                $transaction->getCurrency(),
                $transaction->getFromAccount()->getId(),
                $transaction->getToAccount()->getId(),
                $transaction->getDt()->format('Y-m-d H:i:s')
            );
        }

        return new TransactionHistory(
            $id,
            $limit,
            $offset,
            $total,
            $dtos
        );
    }

    public function transfer(Transfer $request): ?\App\Entity\Transaction
    {
        $from = $this->accountRepository->find($request->getSender());
        $to = $this->accountRepository->find($request->getReceiver());
        $amount = Converter::toMinorUnits($request->getAmount());
        $currency = $request->getCurrency();

// TODO: provide error messages instead of nulls
        if (!($from || $to || $amount)) {
            return null;
        }

        if (!($currency === $from->getCurrency() || $currency === $to->getCurrency())) {
            return null;
        }

// TODO: exchange rate, deal with rounding
        if ($amount > $from->getBalance()) {
            return null;
        }

// TODO: move out, lock, make recoverable
        $transaction = new \App\Entity\Transaction($from, $to, $amount, $currency);
        $this->em->persist($transaction);
        $this->em->flush();

        $from->updateBalance(-$amount);
        $to->updateBalance($amount);
        $this->em->persist($from);
        $this->em->persist($to);
        $this->em->beginTransaction();
        try {
            $this->em->flush();
        } catch (Throwable $e) {
            $this->em->rollback();
            return null;
        }

        return $transaction;
    }

}
