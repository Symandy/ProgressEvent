<?php

declare(strict_types=1);

namespace Symandy\Tests\Component\ProgressEvent\Unit\EventSubscriber;

use PHPUnit\Framework\TestCase;
use Symandy\Component\ProgressEvent\Event\AdvanceEvent;
use Symandy\Component\ProgressEvent\Event\FinishEvent;
use Symandy\Component\ProgressEvent\Event\StartEvent;
use Symandy\Component\ProgressEvent\EventSubscriber\ProgressBarSubscriber;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\EventDispatcher\EventDispatcher;

final class ProgressBarSubscriberTest extends TestCase
{

    /**
     * @test
     * @covers \Symandy\Component\ProgressEvent\EventSubscriber\ProgressBarSubscriber
     */
    public function testOnEventDispatch(): void
    {
        $progressBar = new ProgressBar(new NullOutput());

        $eventDispatcher = new EventDispatcher();
        $eventDispatcher->addSubscriber(new ProgressBarSubscriber($progressBar));

        $eventDispatcher->dispatch(new StartEvent(5));

        self::assertSame(5, $progressBar->getMaxSteps());
        self::assertSame(0, $progressBar->getProgress());

        for ($i = 0; $i < 5; $i++) {
            $eventDispatcher->dispatch(new AdvanceEvent());
        }

        $eventDispatcher->dispatch(new FinishEvent());

        self::assertSame(5, $progressBar->getProgress());
    }

}
