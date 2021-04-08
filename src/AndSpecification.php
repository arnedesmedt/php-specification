<?php

declare(strict_types=1);

namespace ADS\Specification;

use Exception;
use Throwable;

final class AndSpecification extends Specification
{
    private const EXCEPTION_MESSAGE = 'No exception found for AndSpecification';

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
            if ($specification->isSatisfiedBy($item)) {
                continue;
            }

            $exception = $this->notSatisfiedException($item);

            if ($exception->getMessage() === self::EXCEPTION_MESSAGE) {
                $this->setNotSatisfiedException($specification->notSatisfiedException($item));
            }

            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function notSatisfiedException($item): Throwable
    {
        return $this->notSatisfiedException ?? new Exception(self::EXCEPTION_MESSAGE);
    }
}
