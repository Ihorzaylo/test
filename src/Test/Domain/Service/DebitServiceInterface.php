<?php
declare(strict_types=1);

namespace Test\Domain\Service;


use Test\Domain\ValueObject\Amount;
use Ramsey\Uuid\UuidInterface;

/**
 * Interface DebitServiceInterface
 * @package Test\Domain\Service
 */
interface DebitServiceInterface
{
    /**
     * @param UuidInterface $userId
     * @param UuidInterface $transactionId
     * @param Amount        $amount
     */
    public function create(UuidInterface $userId, UuidInterface $transactionId, Amount $amount): void;
}
