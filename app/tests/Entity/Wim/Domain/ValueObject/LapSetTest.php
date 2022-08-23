<?php

declare(strict_types=1);

namespace App\Tests\Entity\Wim\Domain\ValueObject;

use App\Entity\Wim\Domain\ValueObject\LapSet;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class LapSetTest extends TestCase
{
    public function test_get_lap_time()
    {
        $set = new LapSet(
            30,
            60,
            15
        );

        #Упражнение шло 210 секунд
        $interval = $set->getLapTime();
        $interval2 = $set->getLapTime();

        self::assertEquals($interval->s, 210);
        self::assertEquals($interval2->s, 210);
    }
}
