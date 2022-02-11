<?php

declare(strict_types=1);

namespace Symandy\Component\ProgressEvent\EventSubscriber;

use Symandy\Component\ProgressEvent\Event\AdvanceEvent;
use Symandy\Component\ProgressEvent\Event\ClearEvent;
use Symandy\Component\ProgressEvent\Event\FinishEvent;
use Symandy\Component\ProgressEvent\Event\StartEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

abstract class AbstractProgressBarSubscriber implements EventSubscriberInterface
{

    /**
     * @return array<class-string, string>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            StartEvent::class => 'onStart',
            AdvanceEvent::class => 'onAdvance',
            FinishEvent::class => 'onFinish',
            ClearEvent::class => 'onClear'
        ];
    }

    abstract public function onStart(StartEvent $event): void;

    abstract public function onAdvance(AdvanceEvent $event): void;

    abstract public function onFinish(FinishEvent $event): void;

    abstract public function onClear(ClearEvent $event): void;

}
