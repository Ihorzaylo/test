<?php

namespace Test\Domain\Repository;

use Test\Domain\Entity\Balance;
use Ramsey\Uuid\UuidInterface;

/**
 * Interface BalanceRepositoryInterface
 * @package Test\Domain\Repository
 */
interface BalanceRepositoryInterface
{
    /**
     * @param UuidInterface $userId
     *
     * @return Balance|null
     */
    public function balanceByUserId(UuidInterface $userId): ?Balance;
}
