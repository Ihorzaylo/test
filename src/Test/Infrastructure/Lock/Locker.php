<?php
declare(strict_types=1);

namespace Test\Infrastructure\Lock;

use Test\Domain\Lock\LockerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Lock\Exception\LockAcquiringException;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Lock\Lock;

/**
 * Class Locker
 * @package Test\Infrastructure\Lock
 */
class Locker implements LockerInterface
{
    /**
     *
     */
    public const CREATE_TRANSACTION  = 'create-transaction';

    /**
     * @var LockFactory
     */
    private $factory;

    /**
     * @var Lock
     */
    private $lock;

    /**
     * @var string
     */
    private $serviceName;


    /**
     * Locker constructor.
     *
     * @param LockFactory $factory
     * @param string      $serviceName
     */
    public function __construct(LockFactory $factory, string $serviceName)
    {
        $this->factory = $factory;
        $this->serviceName = $serviceName;
    }

    /**
     * {@inheritDoc}
     */
    public function createAcquiredLock(string $prefix, string $key): void
    {
        $this->lock = $this->factory->createLock(sprintf('%s-%s-%s', $this->serviceName, $prefix, $key), self::TTL);

        if (!$this->lock->acquire()) {
            throw new LockAcquiringException('exception.thisActionIsCurrentlyLocked', Response::HTTP_LOCKED);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function release(): void
    {
        $this->lock->release();
    }
}
