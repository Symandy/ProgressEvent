<?php

declare(strict_types=1);

namespace Symandy\Tests\Component\ProgressEvent\Unit\EventSubscriber;

use PHPUnit\Framework\TestCase;
use Symandy\Component\ProgressEvent\Event\AdvanceEvent;
use Symandy\Component\ProgressEvent\Event\FinishEvent;
use Symandy\Component\ProgressEvent\Event\StartEvent;
use Symandy\Component\ProgressEvent\EventSubscriber\SymfonyStyleSubscriber;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventDispatcher;

final class SymfonyStyleSubscriberTest extends TestCase
{

    /**
     * @test
     * @covers \Symandy\Component\ProgressEvent\EventSubscriber\SymfonyStyleSubscriber
     */
    public function testOnEventDispatch(): void
    {
        $ioMock = $this->createMock(SymfonyStyle::class);
        $ioMock->expects(self::once())->method('progressStart');

        $ioMock->expects(self::exactly(5))->method('progressAdvance');

        $ioMock->expects(self::once())->method('progressFinish');

        $eventDispatcher = new EventDispatcher();
        $eventDispatcher->addSubscriber(new SymfonyStyleSubscriber($ioMock));
        $eventDispatcher->dispatch(new StartEvent());

        for ($i = 0; $i < 5; $i++) {
            $eventDispatcher->dispatch(new AdvanceEvent());
        }

        $eventDispatcher->dispatch(new FinishEvent());
    }

}
