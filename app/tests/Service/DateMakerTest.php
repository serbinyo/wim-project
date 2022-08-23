<?php

namespace App\Tests\Service;

use App\Service\DateMaker;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class DateMakerTest extends TestCase
{

    public function testIntervalEmpty()
    {
        $interval = DateMaker::intervalEmpty();
        self::assertEquals(0, $interval->s);
        self::assertEquals(0, $interval->h);
        self::assertEquals(0, $interval->m);
    }

    public function testIntervalFromSeconds()
    {
        $interval = DateMaker::intervalFromSeconds(3600);
        self::assertEquals(3600, $interval->s);
        self::assertEquals(0, $interval->m);
        self::assertEquals(0, $interval->h);
    }
}
