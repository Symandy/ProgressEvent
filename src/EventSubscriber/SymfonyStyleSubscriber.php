<?php

declare(strict_types=1);

namespace Symandy\Component\ProgressEvent\EventSubscriber;

use Symandy\Component\ProgressEvent\Event\AdvanceEvent;
use Symandy\Component\ProgressEvent\Event\FinishEvent;
use Symandy\Component\ProgressEvent\Event\StartEvent;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class SymfonyStyleSubscriber implements EventSubscriberInterface
{

    private SymfonyStyle $io;

    public function __construct(SymfonyStyle $io)
    {
        $this->io = $io;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            StartEvent::class => 'onStart',
            AdvanceEvent::class => 'onAdvance',
            FinishEvent::class => 'onFinish',
        ];
    }

    public function onStart(StartEvent $event): void
    {
        $this->io->createProgressBar($event->getMaxSteps());
    }

    public function onAdvance(AdvanceEvent $event): void
    {
        $this->io->progressAdvance($event->getStep());
    }

    public function onFinish(FinishEvent $event): void
    {
        $this->io->progressFinish();
    }

}
