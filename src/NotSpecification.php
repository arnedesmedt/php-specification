<?php

declare(strict_types=1);

namespace App\Specification;

use Exception;
use Throwable;

final class NotSpecification extends Specification
{
    private Specification $specification;

    public function __construct(Specification $specification)
    {
        $this->specification = $specification;
    }

    /**
     * @inheritDoc
     */
    public function isSatisfiedBy($item): bool
    {
        return ! $this->specification->isSatisfiedBy($item);
    }

    /**
     * @inheritDoc
     */
    public function notSatisfiedException($item): Throwable
    {
        return $this->notSatisfiedException ?? new Exception('No exception found for NotSpecification');
    }
}
