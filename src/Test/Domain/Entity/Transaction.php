<?php

namespace Test\Domain\Entity;

use Test\Domain\ValueObject\Amount;
use Test\Domain\ValueObject\Type;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Transaction
 * @package Test\Domain\Entity
 */
class Transaction
{
    /**
     * @var UuidInterface
     */
    private $transactionId;

    /**
     * @var UuidInterface
     */
    private $userId;

    /**
     * @var Amount
     */
    private $amount;

    /**
     * @var Type
     */
    private $type;

    /**
     * @param UuidInterface $transactionId
     * @param UuidInterface $userId
     * @param Amount        $amount
     * @param Type          $type
     */
    public function __construct(
        UuidInterface $transactionId,
        UuidInterface $userId,
        Amount $amount,
        Type $type
    ) {
        $this->transactionId = $transactionId;
        $this->userId = $userId;
        $this->amount = $amount;
        $this->type = $type;
    }

    /**
     * @return UuidInterface
     */
    public function transactionId(): UuidInterface
    {
        return $this->transactionId;
    }

    /**
     * @return UuidInterface
     */
    public function userId(): UuidInterface
    {
        return $this->userId;
    }

    /**
     * @return Amount
     */
    public function amount(): Amount
    {
        return $this->amount;
    }

    /**
     * @return Type
     */
    public function type(): Type
    {
        return $this->type;
    }
}
