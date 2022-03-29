<?php

declare(strict_types=1);

namespace ADS\Specification;

use Exception;
use Throwable;

final class NotSpecification extends Specification
{
    public function __construct(private Specification $specification)
    {
    }

    public function isSatisfiedBy(mixed $item): bool
    {
        return ! $this->specification->isSatisfiedBy($item);
    }

    public function notSatisfiedException(mixed $item): Throwable
    {
        return $this->notSatisfiedException ?? new Exception('No exception found for NotSpecification');
    }
}
