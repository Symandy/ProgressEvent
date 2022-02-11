# Symandy Progress Event Component

This package contains a set of events and subscribers to be used in Symfony services.

The aim is to externalize Symfony progress bar handle from services and use progress bar events instead.

## Installation

```shell
composer require symandy/progress-event
```

## Usage

1. In your Symfony command, register one of available subscribers before calling the service where the task is executed.


```php
<?php

use Symandy\Component\ProgressEvent\EventSubscriber\ProgressBarSubscriber;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class FooCommand extends Command
{
    private EventDispatcherInterface $eventDispatcher;

    private FooHandler $fooHandler;
 
    // Configure command 

    protected function execute(InputInterface $input, OutputInterface $output): int
    {    
        // Use the basic progress bar
        $this->eventDispatcher->addSubscriber(new ProgressBarSubscriber(new ProgressBar($output)));
     
        // Or use the Symfony style progress bar
        $io = new SymfonyStyle($input, $output);
        $this->eventDispatcher->addSubscriber(new SymfonyStyleSubscriber($io));

        $this->fooHandler->handleComplexTask();

        return Command::SUCCESS;
    }
}
```


2. Dispatch the wanted events while handling some complex task

```php
<?php

use Symandy\Component\ProgressEvent\Event\AdvanceEvent;
use Symandy\Component\ProgressEvent\Event\FinishEvent;
use Symandy\Component\ProgressEvent\Event\StartEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class FooHandler
{
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handleComplexTask(): void
    {
        $items = ['foo', 'bar', 'baz'];

        $this->eventDispatcher->dispatch(new StartEvent(count($items)));

        foreach ($items as $item) {
            // Handle some complex task

            $this->eventDispatcher->dispatch(new AdvanceEvent());
        }

        $this->eventDispatcher->dispatch(new FinishEvent());
    }
}
```
