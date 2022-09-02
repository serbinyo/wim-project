<?php

declare(strict_types=1);

namespace App\Tests\Service\Serializer\Wim;

use App\Entity\Wim\Domain\Aggregate\BreathingExercise;
use App\Service\Builder\Entity\Wim\Domain\Aggregate\BreathingExerciseBuilder;
use App\Service\Serializer\Wim\BreathingExerciseDeserializer;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class BreathingExerciseDeserializerTest extends TestCase
{
    private BreathingExercise $exercise;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->exercise = BreathingExerciseBuilder::buildTestObject();
    }

    /**
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function testDeserializeArray()
    {
        $result = BreathingExerciseDeserializer::deserialize($this->exercise, 'array');

        $standard = [
            'uuid'          => '57d8a1e6-9366-4c7f-98a8-092f87878e6d',
            'duration'      => '3 минуты 30 секунд',
            'laps'          => [
                0 => [
                    'number' => 1,
                    'set'    =>
                        [
                            'exhaleHold' => 60,
                            'inhaleHold' => 15,
                            'breaths'    => 30,
                            'lapTime'    => '3 минуты 30 секунд',
                        ],
                ],
            ],
            'user'          => ['id' => 1],
            'sessionNumber' => 123,
            'dateCreate'    => '31.12.9999',
        ];

        self::assertEquals($standard, $result);
    }

    /**
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function testDeserializeJson()
    {
        $result = BreathingExerciseDeserializer::deserialize($this->exercise, 'json');

        $json = '{"uuid":"57d8a1e6-9366-4c7f-98a8-092f87878e6d","duration":"3 \u043c\u0438\u043d\u0443\u0442\u044b 30 \u0441\u0435\u043a\u0443\u043d\u0434","laps":[{"number":1,"set":{"exhaleHold":60,"inhaleHold":15,"breaths":30,"lapTime":"3 \u043c\u0438\u043d\u0443\u0442\u044b 30 \u0441\u0435\u043a\u0443\u043d\u0434"}}],"user":{"id":1},"sessionNumber":123,"dateCreate":"31.12.9999"}';

        self::assertEquals($json, $result);
    }

    /**
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function testDeserializeCollectionArray()
    {
        $exercise2 = clone $this->exercise;
        $exercise2->setSessionNumber(222);

        $result = BreathingExerciseDeserializer::deserializeCollection(new ArrayCollection([
            $this->exercise,
            $exercise2
        ]), 'array');

        $standard = [
            [
                'uuid'          => '57d8a1e6-9366-4c7f-98a8-092f87878e6d',
                'duration'      => '3 минуты 30 секунд',
                'laps'          => [
                    0 => [
                        'number' => 1,
                        'set'    =>
                            [
                                'exhaleHold' => 60,
                                'inhaleHold' => 15,
                                'breaths'    => 30,
                                'lapTime'    => '3 минуты 30 секунд',
                            ],
                    ],
                ],
                'user'          => ['id' => 1],
                'sessionNumber' => 123,
                'dateCreate'    => '31.12.9999',
            ],
            [
                'uuid'          => '57d8a1e6-9366-4c7f-98a8-092f87878e6d',
                'duration'      => '3 минуты 30 секунд',
                'laps'          => [
                    0 => [
                        'number' => 1,
                        'set'    =>
                            [
                                'exhaleHold' => 60,
                                'inhaleHold' => 15,
                                'breaths'    => 30,
                                'lapTime'    => '3 минуты 30 секунд',
                            ],
                    ],
                ],
                'user'          => ['id' => 1],
                'sessionNumber' => 222,
                'dateCreate'    => '31.12.9999',
            ]
        ];

        self::assertEquals($standard, $result);
    }

    /**
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function testDeserializeCollectionJson()
    {
        $exercise2 = clone $this->exercise;
        $exercise2->setSessionNumber(222);

        $result = BreathingExerciseDeserializer::deserializeCollection(new ArrayCollection([
            $this->exercise,
            $exercise2
        ]), 'json');

        $standard = '[{"uuid":"57d8a1e6-9366-4c7f-98a8-092f87878e6d","duration":"3 \u043c\u0438\u043d\u0443\u0442\u044b 30 \u0441\u0435\u043a\u0443\u043d\u0434","laps":[{"number":1,"set":{"exhaleHold":60,"inhaleHold":15,"breaths":30,"lapTime":"3 \u043c\u0438\u043d\u0443\u0442\u044b 30 \u0441\u0435\u043a\u0443\u043d\u0434"}}],"user":{"id":1},"sessionNumber":123,"dateCreate":"31.12.9999"},{"uuid":"57d8a1e6-9366-4c7f-98a8-092f87878e6d","duration":"3 \u043c\u0438\u043d\u0443\u0442\u044b 30 \u0441\u0435\u043a\u0443\u043d\u0434","laps":[{"number":1,"set":{"exhaleHold":60,"inhaleHold":15,"breaths":30,"lapTime":"3 \u043c\u0438\u043d\u0443\u0442\u044b 30 \u0441\u0435\u043a\u0443\u043d\u0434"}}],"user":{"id":1},"sessionNumber":222,"dateCreate":"31.12.9999"}]';

        self::assertEquals($standard, $result);
    }
}
