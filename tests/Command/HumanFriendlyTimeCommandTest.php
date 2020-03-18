<?php

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class HumanFriendlyTimeCommandTest extends KernelTestCase
{
    /**
     * @var CommandTester
     */
    private $commandTester;

    public function setup()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);
        $command = $application->find('app:human-friendly-time');

        $this->commandTester = new CommandTester($command);

        parent::setup();
    }

    public function testExecuteSuccess()
    {
        $this->commandTester->execute([]);

        $output = $this->commandTester->getDisplay();

        $this->assertContains('[OK]', $output);
    }

    public function testExecuteWithArgumentSuccess()
    {
        $this->commandTester->execute([
            'time' => '12:00',
        ]);

        $output = $this->commandTester->getDisplay();

        $this->assertContains('[OK]', $output);
    }

    public function testExecuteWithArgumentFailure()
    {
        $this->commandTester->execute([
            'time' => '12:005',
        ]);

        $output = $this->commandTester->getDisplay();
        
        $this->assertContains('[ERROR]', $output);
    }
}