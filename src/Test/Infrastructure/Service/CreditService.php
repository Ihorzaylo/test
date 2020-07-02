<?php
declare(strict_types=1);

namespace Test\Infrastructure\Service;

use Test\Domain\Entity\Transaction;
use Test\Domain\Exception\TransactionAlreadyExistException;
use Test\Domain\Repository\TransactionRepositoryInterface;
use Test\Domain\Service\CreditServiceInterface;
use Ramsey\Uuid\UuidInterface;
use Test\Domain\ValueObject\Amount;
use Test\Domain\ValueObject\Type;

/**
 * Class CreditService
 * @package Test\Infrastructure\Service
 */
class CreditService implements CreditServiceInterface
{
    /**
     * @var TransactionRepositoryInterface
     */
    private $transactionRepository;

    /**
     * CreditService constructor.
     */
    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * @param UuidInterface $userId
     * @param UuidInterface $transactionId
     * @param Amount        $amount
     *
     * @throws TransactionAlreadyExistException
     */
    public function create(UuidInterface $userId, UuidInterface $transactionId, Amount $amount): void
    {
        $transaction = $this->transactionRepository->byTransactionId($transactionId);

        if ($transaction) {
            throw TransactionAlreadyExistException::with($transactionId);
        }

        $transaction = new Transaction($transactionId, $userId, $amount, Type::credit());

        $this->transactionRepository->insert($transaction);
    }
}
