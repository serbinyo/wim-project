<?php

declare(strict_types=1);
/**
 * Created by PhpStorm
 * User: serbin
 * Date: 31.07.2022
 * Time: 21:39
 */


namespace App\Entity\Wim\Domain\Entity;


use App\Entity\Ulid;
use App\Entity\Wim\Domain\Aggregate\BreathingExercise;
use App\Entity\Wim\Domain\ValueObject\Exercise;
use DateInterval;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="id", unique=true, length=36)
     *
     * @var Ulid
     */
    private Ulid $uuid;


    /**
     * @ORM\Column(type="integer")
     */
    private int $number;


    /**
     * @ORM\Column(type="integer")
     */
    private int $breaths;


    /**
     * @ORM\Column(type="integer")
     */
    private int $exhaleHold;


    /**
     * @ORM\Column(type="integer")
     */
    private int $inhaleHold;


    /**
     * @ORM\Column(type="string")
     */
    private DateInterval $time;

    /**
     * @ORM\ManyToOne(targetEntity=BreathingExercise::class, inversedBy="laps")
     * @ORM\JoinColumn(nullable=false)
     */
    private BreathingExercise $breathingExercise;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private DateTime $dateCreate;


    /**
     * Lap constructor.
     *
     * @param Ulid         $uuid
     * @param int          $number
     * @param Exercise     $exercise
     * @param DateInterval $time
     */
    public function __construct(Ulid $uuid, int $number, Exercise $exercise, DateInterval $time)
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

    /**
     * @return Ulid
     */
    public function getUuid(): Ulid
    {
        return $this->uuid;
    }

    /**
     * @return DateTime
     */
    public function getDateCreate(): DateTime
    {
        return $this->dateCreate;
    }

    /**
     * @param DateTime $dateCreate
     *
     * @return Lap
     */
    public function setDateCreate(DateTime $dateCreate): Lap
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }
}
