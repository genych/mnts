<?php

namespace App\Repository;

use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Transaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transaction[]    findAll()
 * @method Transaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

// TODO: maybe use EntityRepository::count
    public function countByAccount(int $accountId): int
    {
        $query = 'select count(1) as c from App\\Entity\\Transaction t
            where t.from_account = :accountId OR t.to_account = :accountId';

        return (int)$this->_em->createQuery($query)
            ->setParameter('accountId', $accountId)
            ->getSingleScalarResult();
    }

    /**
     * @param int $accountId
     * @param int $limit
     * @param int $offset
     * @return Transaction[]
     */
    public function findByAccount(int $accountId, int $limit, int $offset): array
    {
        $query = 'select t from App\\Entity\\Transaction t
            where t.from_account = :accountId OR t.to_account = :accountId
            order by t.dt desc';

        return $this->_em->createQuery($query)
            ->setParameter('accountId', $accountId)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getResult();
    }
}
