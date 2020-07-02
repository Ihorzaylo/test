<?php

namespace Test\Domain\Repository;

use Test\Domain\ValueObject\Amount;
use Test\Domain\Entity\Transaction;
use Ramsey\Uuid\UuidInterface;

/**
 * Interface TransactionRepositoryInterface
 * @package Test\Domain\Repository
 */
interface TransactionRepositoryInterface
{
    /**
     * @param Transaction $transaction
     */
    public function insert(Transaction $transaction): void;

    /**
     * @param UuidInterface $transactionId
     *
     * @return Transaction|null
     */
    public function byTransactionId(UuidInterface $transactionId): ?Transaction;

    /**
     * @param UuidInterface $userId
     *
     * @return Amount
     */
    public function countBalanceByUserId(UuidInterface $userId): Amount;
}
