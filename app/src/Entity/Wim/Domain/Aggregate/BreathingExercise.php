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
use Symfony\Component\Uid\Uuid;

/**
 * Class BreathingExercise
 *
 * Агрегат Дыхательное упражнение
 *
 * @package App\Entity\Wim\Domain
 */
class BreathingExercise
{

    /**
     * @var Uuid Идентификатор выполненного упражнения
     */
    private Uuid $uuid;

    /**
     * @var int Номер упражнения для пользователя
     */
    private int $sessionNumber;

    /**
     * @var User Пользователь
     */
    private User $user;

    /**
     * @var Lap[] массив кругов
     */
    private array $laps;

    /**
     * @var DateInterval Продолжительность упражнения
     */
    private DateInterval $duration;

    /**
     * BreathingExercise constructor.
     *
     * @param Uuid  $uuid
     * @param User  $user
     * @param Lap[] $laps
     */
    public function __construct(Uuid $uuid, User $user, array $laps)
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