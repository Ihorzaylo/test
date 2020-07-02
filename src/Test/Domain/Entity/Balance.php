<?php

namespace Test\Domain\Entity;

use Test\Domain\ValueObject\Amount;
use Ramsey\Uuid\UuidInterface;


/**
 * Class Balance
 * @package Test\Domain\Entity
 */
class Balance
{
    /**
     * @var UuidInterface
     */
    private $userId;

    /**
     * @var Amount
     */
    private $amount;

    /**
     * @param UuidInterface $userId
     * @param Amount        $amount
     */
    public function __construct(UuidInterface $userId, Amount $amount)
    {
        $this->userId = $userId;
        $this->amount = $amount;
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
     * @param Amount
     *
     * @return void
     */
    public function setAmount(Amount $amount): void
    {
        $this->amount = $amount;
    }
}
