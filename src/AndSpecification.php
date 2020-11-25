<?php

declare(strict_types=1);

namespace App\Specification;

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

    /**
     * @inheritDoc
     */
    public function isSatisfiedBy($item): bool
    {
        foreach ($this->specifications as $specification) {
            if (! $specification->isSatisfiedBy($item)) {
                $this->setNotSatisfiedException($specification->notSatisfiedException($item));

                return false;
            }
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function notSatisfiedException($item): Throwable
    {
        return $this->notSatisfiedException ?? new Exception('No exception found for AndSpecification');
    }
}
