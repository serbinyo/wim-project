<?php

namespace App\Tests\Entity;

use App\Entity\Ulid;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

/**
 * Тест класса Ulid
 */
class UlidTest extends TestCase
{
    /**
     * Конструктор со значением должен оборачивать это значение в объект Ulid
     */
    public function test__construct()
    {
        $uuid = '9d48df4c-2c00-484f-b3b4-07b8e453292b';

        $uuidObject = new Ulid($uuid);

        self::assertEquals($uuidObject->getUlid(), $uuid);
    }

    /**
     *
     */
    public function test__toString()
    {
        $uuid = '9d48df4c-2c00-484f-b3b4-07b8e453292b';

        $uuidObject = new Ulid($uuid);

        self::assertEquals((string)$uuidObject, $uuid);
    }


    /**
     * Пустой конструктор должен генерировать объект с новым ulid
     */
    public function test_null_construct()
    {
        $uuid = new Ulid();
        self::assertTrue(Uuid::isValid((string)$uuid));
    }

    /**
     * все Ulid из одного и того же числа, должны быть одинаковые по значению
     */
    public function test_number_construct()
    {
        $uuid = 4.12;

        $fourUlid1 = new Ulid($uuid);
        $fourUlid2 = new Ulid($uuid);

        self::assertEquals($fourUlid1, $fourUlid2);
        self::assertEquals($fourUlid1->getUlid(), $fourUlid2->getUlid());
    }
}
