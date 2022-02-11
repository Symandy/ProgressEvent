<?php

declare(strict_types=1);

namespace Symandy\Component\ProgressEvent\Event;

use Symfony\Contracts\EventDispatcher\Event;

final class StartEvent extends Event
{

    private ?int $maxSteps;

    public function __construct(int $maxSteps = null)
    {
        $this->maxSteps = $maxSteps;
    }

    public function getMaxSteps(): ?int
    {
        return $this->maxSteps;
    }

}
