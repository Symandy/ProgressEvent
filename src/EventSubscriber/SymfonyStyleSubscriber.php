<?php

declare(strict_types=1);

namespace Symandy\Component\ProgressEvent\EventSubscriber;

use LogicException;
use Symandy\Component\ProgressEvent\Event\AdvanceEvent;
use Symandy\Component\ProgressEvent\Event\ClearEvent;
use Symandy\Component\ProgressEvent\Event\FinishEvent;
use Symandy\Component\ProgressEvent\Event\StartEvent;
use Symfony\Component\Console\Style\SymfonyStyle;

final class SymfonyStyleSubscriber extends AbstractProgressBarSubscriber
{

    private SymfonyStyle $io;

    public function __construct(SymfonyStyle $io)
    {
        $this->io = $io;
    }

    public function onStart(StartEvent $event): void
    {
        $this->io->progressStart($event->getMaxSteps() ?? 0);
    }

    public function onAdvance(AdvanceEvent $event): void
    {
        $this->io->progressAdvance($event->getStep());
    }

    public function onFinish(FinishEvent $event): void
    {
        $this->io->progressFinish();
    }

    public function onClear(ClearEvent $event): void
    {
        throw new LogicException(sprintf('%s does not implement clear() method', SymfonyStyle::class));
    }

}
