<?php
declare(strict_types=1);

namespace Test\Domain\Exception;

use Test\Infrastructure\Response\XMLResponse;
use Ramsey\Uuid\UuidInterface;

/**
 * Class TransactionAlreadyExistException
 * @package Test\Domain\Exception
 */
class TransactionAlreadyExistException extends \Exception
{
    /**
     * @var int
     */
    protected const CODE = 200;

    /**
     * @var string
     */
    protected const MESSAGE = 'Transaction %s Already Exist';


    /**
     * TransactionAlreadyExistException constructor.
     *
     * @param string $message
     */
    public function __construct($message = "")
    {
        parent::__construct($message, self::CODE);
        $this->response = XMLResponse::success();
    }


    /**
     * @param UuidInterface $transactionId
     *
     * @return static
     */
    public static function with(UuidInterface $transactionId): self
    {
        return new self(sprintf(self::MESSAGE, $transactionId->toString()));
    }

}
