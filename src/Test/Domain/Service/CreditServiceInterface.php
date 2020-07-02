<?php
declare(strict_types=1);

namespace Test\Domain\Service;

use Test\Domain\ValueObject\Amount;
use Ramsey\Uuid\UuidInterface;

/**
 * Interface CreditServiceInterface
 * @package Test\Domain\Service
 */
interface CreditServiceInterface
{
    /**
     * @param UuidInterface $userId
     * @param UuidInterface $transactionId
     * @param Amount        $amount
     */
    public function create(UuidInterface $userId, UuidInterface $transactionId, Amount $amount): void;
}
