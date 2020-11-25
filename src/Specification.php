<?php

declare(strict_types=1);

namespace ADS\Specification;

use Throwable;

abstract class Specification
{
    protected ?Throwable $notSatisfiedException = null;

    /**
     * @param mixed $item
     */
    abstract public function isSatisfiedBy($item): bool;

    /**
     * @param mixed $item
     */
    public function checkSatisfied($item): void
    {
        if ($this->isSatisfiedBy($item)) {
            return;
        }

        $throwable = $this->getNotSatisfiedException($item);

        if ($throwable) {
            throw $throwable;
        }
    }

    /**
     * @return static
     */
    public function setNotSatisfiedException(Throwable $notSatisfiedException)
    {
        $this->notSatisfiedException = $notSatisfiedException;

        return $this;
    }

    /**
     * @param mixed $item
     */
    abstract public function notSatisfiedException($item): Throwable;

    /**
     * @param mixed $item
     */
    private function getNotSatisfiedException($item): ?Throwable
    {
        if (! $this->notSatisfiedException) {
            $this->setNotSatisfiedException($this->notSatisfiedException($item));
        }

        return $this->notSatisfiedException;
    }
}
