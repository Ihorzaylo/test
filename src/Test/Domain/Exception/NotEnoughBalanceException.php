<?php
declare(strict_types=1);

namespace Test\Domain\Exception;

use Ramsey\Uuid\UuidInterface;


/**
 * Class NotEnoughBalanceException
 * @package Test\Domain\Exception
 */
class NotEnoughBalanceException extends \Exception
{
    /**
     * @var int
     */
    protected const CODE = 404;

    /**
     * @var string
     */
    protected const MESSAGE = 'Balance %s Not Enough';


    /**
     * @param UuidInterface $userId
     *
     * @return static
     */
    public static function with(UuidInterface $userId): self
    {
        return new self(
            sprintf(self::MESSAGE, $userId->toString()),
            self::CODE
        );
    }
}
