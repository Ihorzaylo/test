<?php

declare(strict_types=1);

namespace Test\Infrastructure\Controller;

use Test\Domain\Exception\NotEnoughBalanceException;
use Test\Domain\Exception\TransactionAlreadyExistException;
use Test\Domain\Lock\LockerInterface;
use Test\Domain\Service\CreditServiceInterface;
use Test\Domain\Service\DebitServiceInterface;
use Test\Domain\ValueObject\Amount;
use Test\Infrastructure\Lock\Locker;
use Test\Infrastructure\Request\CreateCreditRequest;
use Test\Infrastructure\Request\CreateDebitRequest;
use Test\Infrastructure\Response\XMLResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;

/**
 * Class TransactionController
 * @package Test\Infrastructure\Controller
 * @Route("/transaction")
 */
class TransactionController
{
    /**
     * @Route("/debit", name="debit.create", methods={"POST"})
     *
     * @SWG\Get(
     *     tags={"Transaction"},
     *     description="Debit create",
     *     @SWG\Response(response=200, description="OK"),
     *     @SWG\Response(response=500, description="Server Error"),
     * )
     *
     *
     * @return XMLResponse
     */
    public function debit(
        LockerInterface $locker,
        CreateDebitRequest $request,
        DebitServiceInterface $debitService
    ): XMLResponse {
        $locker->createAcquiredLock(Locker::CREATE_TRANSACTION, $request->uid()->toString());

        try {
            $debitService->create($request->uid(), $request->tid(), Amount::fromString($request->amount()));
        } catch (TransactionAlreadyExistException $exception) {
            return XMLResponse::success();
        } catch (NotEnoughBalanceException $exception) {
            return XMLResponse::error('insufficient funds', Response::HTTP_OK);
        } finally {
           $locker->release();
        }

        return XMLResponse::success();
    }

    /**
     * @Route("/credit", name="credit.create", methods={"POST"})
     *
     * @SWG\Get(
     *     tags={"Transaction"},
     *     description="Credit create",
     *     @SWG\Response(response=200, description="OK"),
     *     @SWG\Response(response=500, description="Server Error"),
     * )
     *
     *
     * @return XMLResponse
     */
    public function credit(
        LockerInterface $locker,
        CreateCreditRequest $request,
        CreditServiceInterface $creditService
    ): XMLResponse {
        $locker->createAcquiredLock(Locker::CREATE_TRANSACTION, $request->uid()->toString());

        try {
            $creditService->create($request->uid(), $request->tid(), Amount::fromString($request->amount()));
        } catch (TransactionAlreadyExistException $exception) {
            return XMLResponse::success();
        } finally {
            $locker->release();
        }

        return XMLResponse::success();
    }
}
