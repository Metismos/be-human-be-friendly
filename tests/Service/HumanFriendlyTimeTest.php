<?php

namespace App\Tests\Service;

use App\Service\HumanFriendlyTime;
use PHPUnit\Framework\TestCase;

class HumanFriendlyTimeTest extends TestCase
{
    /**
     * @var HumanFriendlyTime
     */
    private $humanFriendlyTimeService;

    public function setup()
    {
        $this->humanFriendlyTimeService = new HumanFriendlyTime();
    }

    /**
     * @dataProvider successTimeProvider
     */
    public function testTimeToHumanFriendly(?string $time)
    {
        $friendlyTime = $this->humanFriendlyTimeService->getTime($time);
        
        $this->assertNotNull($friendlyTime);
    }

     /**
     * @dataProvider failureTimeProvider
     */
    public function testGetTimeFailure(string $time)
    {
        $friendlyTime = $this->humanFriendlyTimeService->getTime($time);
        
        $this->assertNull($friendlyTime);
    }

    public function successTimeProvider(): array
    {
        return [
            [null],
            ['12:00'], // $minute === 0
            ['1:01'], // $minute === 1
            ['13:59'], // $minute === 59
            ['13:15'], // $minute === 15
            ['13:30'], // $minute === 30
            ['13:45'], // $minute === 45
            ['13:29'], // $minute <= 30
            ['13:35'], // $minute > 30
        ];
    }

    public function failureTimeProvider(): array
    {
        return [
            ['test'],
            ['25:00'],
            ['13:89'],
            ['13:890'],
            ['133:15'],
        ];
    }
}
