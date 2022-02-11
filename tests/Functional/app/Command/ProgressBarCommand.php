<?php

declare(strict_types=1);

namespace Symandy\Tests\Component\ProgressEvent\Functional\app\Command;

use Symandy\Component\ProgressEvent\Event\AdvanceEvent;
use Symandy\Component\ProgressEvent\Event\FinishEvent;
use Symandy\Component\ProgressEvent\Event\StartEvent;
use Symandy\Component\ProgressEvent\EventSubscriber\ProgressBarSubscriber;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class ProgressBarCommand extends Command
{

    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        parent::__construct();

        $this->eventDispatcher = $eventDispatcher;
    }

    protected function configure(): void
    {
        $this->setName('test:progress-bar');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->eventDispatcher->addSubscriber(new ProgressBarSubscriber(new ProgressBar($output)));

        $this->eventDispatcher->dispatch(new StartEvent(10));

        for ($i = 0; $i < 10; $i++) {
            $this->eventDispatcher->dispatch(new AdvanceEvent());
        }

        $this->eventDispatcher->dispatch(new FinishEvent());

        return 0;
    }

}
