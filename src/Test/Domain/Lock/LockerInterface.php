<?php
declare(strict_types=1);

namespace Test\Domain\Lock;

/**
 * Interface LockerInterface
 * @package Test\Domain\Lock
 */
interface LockerInterface
{
    /**
     *
     */
    public const TTL = 20;

    /**
     * @param string $prefix
     * @param string $key
     */
    public function createAcquiredLock(string $prefix, string $key): void;

    /**
     * Unlock User Request
     */
    public function release(): void;
}
