<?php

namespace Test\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Test\Domain\Entity\Balance;
use Test\Domain\Repository\BalanceRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * Class BalanceRepository
 * @package Test\Infrastructure\Repository
 */
class BalanceRepository extends EntityRepository implements BalanceRepositoryInterface
{
    /**
     * @param UuidInterface $userId
     *
     * @return Balance|null
     */
    public function balanceByUserId(UuidInterface $userId): ?Balance
    {
        return $this->findOneBy(
            [
                'userId' => $userId->toString(),
            ]
        );
    }
}
