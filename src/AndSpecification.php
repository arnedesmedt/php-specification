<?php

declare(strict_types=1);

namespace ADS\Specification;

use Exception;
use Throwable;

final class AndSpecification extends Specification
{
    /** @var array<Specification> */
    private array $specifications;

    public function __construct(Specification ...$specifications)
    {
        $this->specifications = $specifications;
    }

    public function isSatisfiedBy(mixed $item): bool
    {
        foreach ($this->specifications as $specification) {
            if (! $specification->isSatisfiedBy($item)) {
                $this->setNotSatisfiedException($specification->notSatisfiedException($item));

                return false;
            }
        }

        return true;
    }

    public function notSatisfiedException(mixed $item): Throwable
    {
        return $this->notSatisfiedException ?? new Exception('No exception found for AndSpecification');
    }
}
