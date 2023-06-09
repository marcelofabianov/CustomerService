<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use InvalidArgumentException;
use JsonException;
use stdClass;

final readonly class Json implements \JsonSerializable
{
    private array|string $value;

    private function __construct(array|string $value)
    {
        $this->value = $value;
    }

    /**
     * @throws JsonException
     */
    public function __toString(): string
    {
        return json_encode($this->value, JSON_THROW_ON_ERROR);
    }

    public function getValue(): array|string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->getValue() === $other->getValue();
    }

    /**
     * @throws JsonException
     */
    public function encode(): string|bool
    {
        return json_encode($this->value, JSON_THROW_ON_ERROR);
    }

    public function jsonSerialize(): stdClass|array|bool
    {
        return $this->decode();
    }

    /**
     * @throws JsonException
     */
    public function decode(): stdClass|array|bool
    {
        if (is_string($this->value)) {
            $result = json_decode($this->value, false, 512, JSON_THROW_ON_ERROR);
            if (is_string($result)) {
                $result = json_decode($result, false, 512, JSON_THROW_ON_ERROR);
            }

            return $result;
        }

        return false;
    }

    public static function create(mixed $value): self
    {
        if (! is_string($value) and ! is_array($value)) {
            throw new InvalidArgumentException('Unsupported argument type');
        }

        return new self($value);
    }
}
