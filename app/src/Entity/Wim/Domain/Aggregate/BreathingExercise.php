<?php

declare(strict_types=1);

/**
 * Created by PhpStorm
 * User: serbin
 * Date: 31.07.2022
 * Time: 21:36
 */


namespace App\Entity\Wim\Domain\Aggregate;


use App\Entity\User;
use App\Entity\Wim\Domain\Entity\Lap;
use DateInterval;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * Class BreathingExercise
 *
 * Агрегат Дыхательное упражнение
 *
 * @package App\Entity\Wim\Domain
 * @ORM\Entity
 * @ORM\Table(name="breathing_exercise")
 */
class BreathingExercise
{

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     *
     * @var Uuid
     */
    public Uuid $uuid;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int Номер упражнения для пользователя
     */
    private int $sessionNumber;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="breathingExercises")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var User Пользователь
     */
    private User $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Wim\Domain\Entity\Lap", mappedBy="breathingExercises")
     *
     * @var Lap[]|ArrayCollection массив кругов
     */
    private array $laps;

    /**
     * @ORM\Column(type="string")
     *
     * @var DateInterval Продолжительность упражнения
     */
    private DateInterval $duration;

    /**
     * BreathingExercise constructor.
     *
     * @param Uuid  $uuid
     * @param User  $user
     * @param ArrayCollection $laps
     */
    public function __construct(Uuid $uuid, User $user, ArrayCollection $laps)
    {
        $this->uuid = $uuid;
        $this->user = $user;
        $this->laps = $laps;
    }

    /**
     * @param int $sessionNumber
     *
     * @return BreathingExercise
     */
    public function setSessionNumber(int $sessionNumber): BreathingExercise
    {
        $this->sessionNumber = $sessionNumber;

        return $this;
    }

    /**
     * @param DateInterval $duration
     */
    public function setDuration(DateInterval $duration): BreathingExercise
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return Lap[]|ArrayCollection
     */
    public function getLaps(): ArrayCollection|array
    {
        return $this->laps;
    }

    /**
     * Посчитать временной интервал
     */
    public function countDuration()
    {
        $duration = DateInterval::createFromDateString('0 seconds');

        foreach ($this->laps as $lap) {
            $duration += $lap->getTime();
        }

        $this->duration = $duration;
    }
}