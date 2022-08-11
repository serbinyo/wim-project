<?php

namespace App\Tests\Entity\Wim\Domain\Entity;

use App\Entity\Ulid;
use App\Entity\Wim\Domain\Entity\Lap;
use App\Entity\Wim\Domain\ValueObject\Exercise;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class LapTest extends TestCase
{

    public function test__construct()
    {
        $uuid = '3a43f85b-28e4-48a8-b9cc-4f6bfc7e4f62';
        $number = 1;
        $exercise = new Exercise(
            30,
            60,
            15
        );
        $lap = new Lap(
            new Ulid($uuid),
            $number,
            $exercise
        );

        self::assertEquals($uuid, $lap->getUuid()->getUlid());
        self::assertEquals($number, $lap->getNumber());
        self::assertEquals($exercise, new Exercise(
            $lap->getBreaths(),
            $lap->getExhaleHold(),
            $lap->getInhaleHold()
        ));
    }
}
