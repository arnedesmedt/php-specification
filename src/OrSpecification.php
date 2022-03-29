<?php

declare(strict_types=1);

namespace ADS\Specification;

use Exception;
use Throwable;

final class OrSpecification extends Specification
{
    /** @var array<Specification> */
    private array $specifications;

    public function __construct(Specification ...$specifications)
    {
        $this->specifications = $specifications;
    }

    public function isSatisfiedBy(mixed $item): bool
    {
        if (empty($this->specifications)) {
            return true;
        }

        foreach ($this->specifications as $specification) {
            if ($specification->isSatisfiedBy($item)) {
                return true;
            }
        }

        $this->setNotSatisfiedException($specification->notSatisfiedException($item));

        return false;
    }

    public function notSatisfiedException(mixed $item): Throwable
    {
        return $this->notSatisfiedException ?? new Exception('No exception found for OrSpecification');
    }
}
