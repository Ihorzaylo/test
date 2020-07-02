<?php

namespace Test\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Test\Domain\Entity\Balance;
use Test\Domain\ValueObject\Amount;
use Test\Domain\Entity\Transaction;
use Test\Domain\Repository\TransactionRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * Class TransactionRepository
 * @package Test\Infrastructure\Repository
 */
class TransactionRepository extends EntityRepository implements TransactionRepositoryInterface
{
    /**
     * @param Transaction $transaction
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function insert(Transaction $transaction): void
    {
        $this->_em->persist($transaction);
        $this->_em->flush();
    }

    /**
     * @param UuidInterface $userId
     *
     * @return Amount
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countBalanceByUserId(UuidInterface $userId): Amount
    {
        $balance = $this->createQueryBuilder('t')
            ->andWhere('t.userId = :userId')
            ->setParameter('userId', $userId)
            ->select('SUM(t.amount.value) as balance')
            ->getQuery()
            ->getOneOrNullResult();

        $amount = ($balance && array_key_exists('balance', $balance)) ? $balance['balance'] : 0;

        return new Amount($amount);
    }

    /**
     * @param UuidInterface $transactionId
     *
     * @return Transaction|null
     */
    public function byTransactionId(UuidInterface $transactionId): ?Transaction
    {
        return $this->findOneBy(
            [
                'transactionId' => $transactionId->toString(),
            ]
        );
    }
}
