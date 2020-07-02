<?php
declare(strict_types=1);

namespace Test\Infrastructure\Service;

use Test\Domain\Exception\NotEnoughBalanceException;
use Test\Domain\Exception\TransactionAlreadyExistException;
use Test\Domain\ValueObject\Amount;
use Test\Domain\Entity\Transaction;
use Test\Domain\Repository\BalanceRepositoryInterface;
use Test\Domain\Repository\TransactionRepositoryInterface;
use Test\Domain\Service\DebitServiceInterface;
use Test\Domain\ValueObject\Type;
use Ramsey\Uuid\UuidInterface;

/**
 * Class DebitService
 * @package Test\Infrastructure\Service
 */
class DebitService implements DebitServiceInterface
{

    /**
     * @var TransactionRepositoryInterface
     */
    private $transactionRepository;
    /**
     * @var BalanceRepositoryInterface
     */
    private $balanceRepository;

    /**
     * CreditService constructor.
     */
    public function __construct(
        TransactionRepositoryInterface $transactionRepository,
        BalanceRepositoryInterface $balanceRepository
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->balanceRepository = $balanceRepository;
    }

    /**
     * @param UuidInterface $userId
     * @param UuidInterface $transactionId
     * @param Amount        $amount
     *
     * @throws NotEnoughBalanceException
     * @throws TransactionAlreadyExistException
     */
    public function create(UuidInterface $userId, UuidInterface $transactionId, Amount $amount): void
    {
        $transaction = $this->transactionRepository->byTransactionId($transactionId);

        if ($transaction) {
            throw TransactionAlreadyExistException::with($transactionId);
        }

        $balance = $this->balanceRepository->balanceByUserId($userId);
        $balanceAmount = $balance ? $balance->amount() : Amount::isZero();

        if (!$balanceAmount->isMoreOrEqual($amount)) {
            throw NotEnoughBalanceException::with($userId);
        }

        $transaction = new Transaction($transactionId, $userId, Amount::negativeFromAmount($amount), Type::debit());

        $this->transactionRepository->insert($transaction);
    }
}
