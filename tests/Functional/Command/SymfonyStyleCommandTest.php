<?php

declare(strict_types=1);

namespace Symandy\Tests\Component\ProgressEvent\Functional\Command;

use PHPUnit\Framework\TestCase;
use Symandy\Tests\Component\ProgressEvent\Functional\app\Command\ProgressBarCommand;
use Symandy\Tests\Component\ProgressEvent\Functional\app\Command\SymfonyStyleCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\EventDispatcher\EventDispatcher;

final class SymfonyStyleCommandTest extends TestCase
{

    /**
     * @test
     * @covers \Symandy\Component\ProgressEvent\EventSubscriber\SymfonyStyleSubscriber
     */
    public function testCommandIsExecutedWithoutError(): void
    {
        $command = new SymfonyStyleCommand(new EventDispatcher());

        $application = new Application();
        $application->add($command);

        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        self::assertStringContainsString('10/10', $commandTester->getDisplay());
        self::assertStringContainsString('100%', $commandTester->getDisplay());
    }

}
