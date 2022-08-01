<?php

declare(strict_types=1);
/**
 * Created by PhpStorm
 * User: serbin
 * Date: 31.07.2022
 * Time: 21:39
 */


namespace App\Entity\Wim\Domain\Entity;


use App\Entity\Wim\Domain\Aggregate\BreathingExercise;
use App\Entity\Wim\Domain\ValueObject\Exercise;
use DateInterval;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * Class Lap
 *
 * @package App\Entity\Wim\Domain\Entity
 * @ORM\Entity
 * @ORM\Table(name="lap")
 */
class Lap
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     *
     * @var Uuid Идентификатор круга
     */
    private Uuid $uuid;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int Номер круга
     */
    private int $number;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int Количество вдохов выдохов
     */
    private int $breaths;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int Задержка на выдохе (Задержка перед вдохом), сек.
     */
    private int $exhaleHold;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int Задержка на вдохе, сек.
     */
    private int $inhaleHold;

    /**
     * @ORM\Column(type="string")
     *
     * @var DateInterval Время круга
     */
    private DateInterval $time;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Wim\Domain\Aggregate\BreathingExercise", inversedBy="laps")
     * @ORM\Column(type="string")
     */
    private BreathingExercise $breathingExercise;


    /**
     * Lap constructor.
     *
     * @param Uuid         $uuid
     * @param int          $number
     * @param Exercise     $exercise
     * @param DateInterval $time
     */
    public function __construct(Uuid $uuid, int $number, Exercise $exercise, DateInterval $time)
    {
        $this->uuid = $uuid;
        $this->number = $number;
        $this->breaths = $exercise->getBreaths();
        $this->exhaleHold = $exercise->getExhaleHold();
        $this->inhaleHold = $exercise->getInhaleHold();
        $this->time = $time;
    }

    /**
     * @return DateInterval
     */
    public function getTime(): DateInterval
    {
        return $this->time;
    }

    /**
     * @return BreathingExercise
     */
    public function getBreathingExercise(): BreathingExercise
    {
        return $this->breathingExercise;
    }

    /**
     * @param BreathingExercise $breathingExercise
     *
     * @return Lap
     */
    public function setBreathingExercise(BreathingExercise $breathingExercise): Lap
    {
        $this->breathingExercise = $breathingExercise;

        return $this;
    }
}
