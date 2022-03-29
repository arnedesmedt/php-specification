<?php

declare(strict_types=1);

namespace ADS\Specification;

use Throwable;

abstract class Specification
{
    protected ?Throwable $notSatisfiedException = null;

    abstract public function isSatisfiedBy(mixed $item): bool;

    public function checkSatisfied(mixed $item): void
    {
        if ($this->isSatisfiedBy($item)) {
            return;
        }

        $throwable = $this->getNotSatisfiedException($item);

        if ($throwable) {
            throw $throwable;
        }
    }

    public function setNotSatisfiedException(Throwable $notSatisfiedException): static
    {
        $this->notSatisfiedException = $notSatisfiedException;

        return $this;
    }

    abstract public function notSatisfiedException(mixed $item): Throwable;

    private function getNotSatisfiedException(mixed $item): ?Throwable
    {
        if (! $this->notSatisfiedException) {
            $this->setNotSatisfiedException($this->notSatisfiedException($item));
        }

        return $this->notSatisfiedException;
    }
}
