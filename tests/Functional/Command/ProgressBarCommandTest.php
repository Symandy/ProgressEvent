<?php

declare(strict_types=1);

namespace Symandy\Tests\Component\ProgressEvent\Functional\Command;

use PHPUnit\Framework\TestCase;
use Symandy\Tests\Component\ProgressEvent\Functional\app\Command\ProgressBarCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\EventDispatcher\EventDispatcher;

final class ProgressBarCommandTest extends TestCase
{

    /**
     * @test
     * @covers \Symandy\Component\ProgressEvent\EventSubscriber\ProgressBarSubscriber
     */
    public function testCommandIsExecutedWithoutError(): void
    {
        $command = new ProgressBarCommand(new EventDispatcher());

        $application = new Application();
        $application->add($command);

        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        self::assertStringContainsString('10/10', $commandTester->getDisplay());
        self::assertStringContainsString('100%', $commandTester->getDisplay());
    }

}
