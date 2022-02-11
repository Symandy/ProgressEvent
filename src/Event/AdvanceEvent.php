<?php

declare(strict_types=1);

namespace Symandy\Component\ProgressEvent\Event;

use Symfony\Contracts\EventDispatcher\Event;

final class AdvanceEvent extends Event
{

    private int $step;

    public function __construct(int $step = 1)
    {
        $this->step = $step;
    }

    public function getStep(): int
    {
        return $this->step;
    }

}
