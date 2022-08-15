<?php

declare(strict_types=1);

namespace App\Tests\Entity\Wim\Domain\Entity;

use App\Entity\Wim\Domain\ValueObject\LapSet;
use App\Service\Builder\Entity\Wim\Domain\Entity\LapBuilder;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class LapTest extends TestCase
{

    public function test__construct()
    {
        $number = 1;
        $lap = LapBuilder::buildTestObject();

        self::assertEquals(LapBuilder::UUID, $lap->getUuid()->getUlid());
        self::assertEquals($number, $lap->getNumber());
        self::assertEquals($lap->getSet(), new LapSet(
            $lap->getBreaths(),
            $lap->getExhaleHold(),
            $lap->getInhaleHold()
        ));
    }
}
