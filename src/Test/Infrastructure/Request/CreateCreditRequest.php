<?php
declare(strict_types=1);

namespace Test\Infrastructure\Request;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class CreateCreditRequest
 * @package Test\Infrastructure\Request
 */
class CreateCreditRequest extends AbstractCustomRequest
{
    /**
     * @var string
     */
    protected $uid;

    /**
     * @var string
     */
    protected $tid;

    /**
     * @var string
     */
    protected $amount;

    /**
     * @return array
     */
    public function getValidationRules(): array
    {
        return [
            new Assert\Collection(
                [
                    'uid' => [
                        new Assert\Uuid(),
                    ],

                    'tid'    => [
                        new Assert\Uuid(),
                    ],
                    'amount' => new Assert\Optional(
                        [
                            new Assert\NotNull(),
                            new Assert\Type(['type' => 'string']),
                            new Assert\GreaterThanOrEqual(1),
                        ]
                    ),
                ]
            ),
        ];
    }

    /**
     * @return UuidInterface
     */
    public function uid(): UuidInterface
    {
        return Uuid::fromString($this->uid);
    }

    /**
     * @return UuidInterface
     */
    public function tid(): UuidInterface
    {
        return Uuid::fromString($this->tid);
    }

    /**
     * @return string
     */
    public function amount(): string
    {
        return $this->amount;
    }
}
