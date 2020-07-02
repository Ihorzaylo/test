<?php
declare(strict_types=1);

namespace Test\Domain\ValueObject;

use InvalidArgumentException;

/**
 * Class Amount
 * @package Test\Domain\ValueObject
 */
final class Amount
{
    /**
     * @var int
     */
    private $value;

    /**
     * Amount constructor.
     *
     * @param int $value
     */
    public function __construct(int $value)
    {
        self::isValid($value);

        $this->value = $value;
    }

    /**
     * @return int
     */
    public function value(): int
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return static
     */
    public static function fromString(string $value): self
    {
        return new self((int)$value);
    }

    /**
     * @return static
     */
    public static function isZero(): self
    {
        return new self(0);
    }

    /**
     * @param Amount $value
     *
     * @return static
     */
    public static function negativeFromAmount(Amount $value): self
    {
        return new self($value->value() * -1);
    }

    /**
     * @param int $value
     */
    private static function isValid(int $value): void
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException('Amount must be a valid numeric value');
        }
    }

    /**
     * @param Amount $other
     *
     * @return bool
     */
    public function isMoreOrEqual(Amount $other): bool
    {
        return $this->value >= $other->value();
    }
}
