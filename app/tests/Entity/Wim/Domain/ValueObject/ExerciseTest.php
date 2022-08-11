<?php

namespace App\Tests\Entity\Wim\Domain\ValueObject;

use App\Entity\Wim\Domain\ValueObject\Exercise;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class ExerciseTest extends TestCase
{
    public function test_get_lap_time()
    {
        $exercise = new Exercise(
            30,
            60,
            15
        );

        #Упражнение шло 210 секунд
        $interval = $exercise->getLapTime();

        self::assertEquals($interval->s, 210);
    }
}
