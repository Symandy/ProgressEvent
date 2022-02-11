<?php

declare(strict_types=1);

namespace Symandy\Tests\Component\ProgressEvent\Unit\EventSubscriber;

use PHPUnit\Framework\TestCase;
use Symandy\Component\ProgressEvent\Event\AdvanceEvent;
use Symandy\Component\ProgressEvent\Event\ClearEvent;
use Symandy\Component\ProgressEvent\Event\FinishEvent;
use Symandy\Component\ProgressEvent\Event\StartEvent;
use Symandy\Component\ProgressEvent\EventSubscriber\AbstractProgressBarSubscriber;
use Symfony\Component\EventDispatcher\EventDispatcher;

final class AbstractProgressBarSubscriberTest extends TestCase
{

    /**
     * @test
     * @covers \Symandy\Component\ProgressEvent\EventSubscriber\AbstractProgressBarSubscriber
     * @covers \Symandy\Component\ProgressEvent\EventSubscriber\ProgressBarSubscriber
     *
     * This test covers ProgressBarSubscriber too as \Symfony\Component\Console\Helper\ProgressBar is final
     * and cannot be mocked.
     */
    public function testOnEventDispatch(): void
    {
        $subscriberMock = $this
            ->getMockBuilder(AbstractProgressBarSubscriber::class)
            ->getMockForAbstractClass()
        ;

        $subscriberMock->expects(self::once())->method('onStart');
        $subscriberMock->expects(self::once())->method('onAdvance');
        $subscriberMock->expects(self::once())->method('onFinish');
        $subscriberMock->expects(self::once())->method('onClear');

        $eventDispatcher = new EventDispatcher();
        $eventDispatcher->addSubscriber($subscriberMock);

        $eventDispatcher->dispatch(new StartEvent());
        $eventDispatcher->dispatch(new AdvanceEvent());
        $eventDispatcher->dispatch(new FinishEvent());
        $eventDispatcher->dispatch(new ClearEvent());
    }

    /**
     * @test
     * @covers \Symandy\Component\ProgressEvent\EventSubscriber\AbstractProgressBarSubscriber
     * @covers \Symandy\Component\ProgressEvent\EventSubscriber\ProgressBarSubscriber
     */
    public function testOnEventDispatchWithArguments(): void
    {
        $subscriberMock = $this
            ->getMockBuilder(AbstractProgressBarSubscriber::class)
            ->getMockForAbstractClass()
        ;

        $subscriberMock->expects(self::exactly(2))
            ->method('onStart')
            ->withConsecutive(
                [new StartEvent(10)],
                [new StartEvent()],
            )
        ;

        $subscriberMock->expects(self::exactly(2))
            ->method('onAdvance')
            ->withConsecutive(
                [new AdvanceEvent(5)],
                [new AdvanceEvent()],
            )
        ;

        $eventDispatcher = new EventDispatcher();
        $eventDispatcher->addSubscriber($subscriberMock);

        $eventDispatcher->dispatch(new StartEvent(10));
        $eventDispatcher->dispatch(new StartEvent(null));

        $eventDispatcher->dispatch(new AdvanceEvent(5));
        $eventDispatcher->dispatch(new AdvanceEvent());
    }

}
