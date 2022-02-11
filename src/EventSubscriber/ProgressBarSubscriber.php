<?php

declare(strict_types=1);

namespace Symandy\Component\ProgressEvent\EventSubscriber;

use Symandy\Component\ProgressEvent\Event\AdvanceEvent;
use Symandy\Component\ProgressEvent\Event\ClearEvent;
use Symandy\Component\ProgressEvent\Event\FinishEvent;
use Symandy\Component\ProgressEvent\Event\StartEvent;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class ProgressBarSubscriber implements EventSubscriberInterface
{

    private ProgressBar $progressBar;

    public function __construct(ProgressBar $progressBar)
    {
        $this->progressBar = $progressBar;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            StartEvent::class => 'onStart',
            AdvanceEvent::class => 'onAdvance',
            FinishEvent::class => 'onFinish',
            ClearEvent::class => 'onClear'
        ];
    }

    public function onStart(StartEvent $event): void
    {
        $this->progressBar->start($event->getMaxSteps());
    }

    public function onAdvance(AdvanceEvent $event): void
    {
        $this->progressBar->advance($event->getStep());
    }

    public function onFinish(FinishEvent $event): void
    {
        $this->progressBar->finish();
    }

    public function onClear(ClearEvent $event): void
    {
        $this->progressBar->clear();
    }

}
