<?php
declare(strict_types=1);

namespace Test\Domain\ValueObject;

use InvalidArgumentException;

/**
 * Class Type
 * @package Test\Domain\ValueObject
 */
final class Type
{
    /**
     *
     */
    const TYPE_CREDIT = 'credit';
    /**
     *
     */
    const TYPE_DEBIT = 'debit';

    /**
     *
     */
    public const AVAILABLE_POINTS = [
        self::TYPE_CREDIT,
        self::TYPE_DEBIT,
    ];

    /**
     * @var string
     */
    private $value;

    /**
     * Type constructor.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        if (!self::isValid($value)) {
            throw new InvalidArgumentException(
                sprintf('Value "%s" is not a valid point.', $value)
            );
        }

        $this->value = $value;
    }

    /**
     * @param string $value
     *
     * @return static
     */
    public static function fromString(string $value): self
    {
        return new self($value);
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * @param string $status
     *
     * @return bool
     */
    public static function isValid(string $status): bool
    {
        return in_array($status, self::AVAILABLE_POINTS, true);
    }

    /**
     * @return static
     */
    public static function credit(): self
    {
        return new self(self::TYPE_CREDIT);
    }

    /**
     * @return static
     */
    public static function debit(): self
    {
        return new self(self::TYPE_DEBIT);
    }
}
