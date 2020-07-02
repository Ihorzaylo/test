<?php
declare(strict_types=1);

namespace Test\Infrastructure\Entity\Listener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Test\Domain\Entity\Balance;
use Test\Domain\Entity\Transaction;

class BalanceListener
{
    /**
     * @param Transaction        $transaction
     * @param LifecycleEventArgs $args
     */
    public function postPersist(Transaction $transaction, LifecycleEventArgs $args): void
    {
        $repository = $args->getObjectManager()->getRepository(Balance::class);
        $transactionRepository = $args->getObjectManager()->getRepository(Transaction::class);

        $currentBalance = $transactionRepository->countBalanceByUserId($transaction->userId());
        $balance = $repository->findOneBy(['userId' => $transaction->userId()]);
        if (!$balance instanceof Balance) {
            $balance = new Balance(
                $transaction->userId(),
                $currentBalance
            );
        } else {
            $balance->setAmount($currentBalance);
        }

        $args->getObjectManager()->persist($balance);
        $args->getObjectManager()->flush();
    }
}
