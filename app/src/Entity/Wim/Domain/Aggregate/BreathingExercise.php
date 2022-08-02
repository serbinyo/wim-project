<?php

declare(strict_types=1);

/**
 * Created by PhpStorm
 * User: serbin
 * Date: 31.07.2022
 * Time: 21:36
 */

namespace App\Entity\Wim\Domain\Aggregate;


use App\Entity\Ulid;
use App\Entity\User;
use App\Entity\Wim\Domain\Entity\Lap;
use DateInterval;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use App\Repository\Wim\BreathingExerciseRepository;

/**
 * Class BreathingExercise
 *
 * Агрегат Дыхательное упражнение
 *
 * @package App\Entity\Wim\Domain
 * @ORM\Entity(repositoryClass=BreathingExerciseRepository::class)
 * @ORM\Table(name="breathing_exercise")
 */
class BreathingExercise
{

    /**
     * @ORM\Id
     * @ORM\Column(name="id", unique=true, length=36)
     *
     * @var Ulid
     */
    public Ulid $uuid;


    /**
     * @ORM\Column(type="integer")
     */
    private int $sessionNumber;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="breathingExercises")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private User $user;

    /**
     * @ORM\OneToMany(targetEntity=Lap::class, mappedBy="breathingExercise")
     */
    private array $laps;

    /**
     * @ORM\Column(type="string")
     */
    private DateInterval $duration;

    /**
     * BreathingExercise constructor.
     *
     * @param Uuid $uuid
     * @param User $user
     */
    public function __construct(Uuid $uuid, User $user)
    {
        $this->uuid = $uuid;
        $this->user = $user;
        $this->laps = new ArrayCollection();
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
     * @return Collection<int, Lap>
     */
    public function getLaps(): Collection
    {
        return $this->laps;
    }

    public function addBreathing(Lap $lap): self
    {
        if (!$this->laps->contains($lap)) {
            $this->laps[] = $lap;
            $lap->setBreathingExercise($this);
        }

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

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return BreathingExercise
     */
    public function setUser(User $user): BreathingExercise
    {
        $this->user = $user;

        return $this;
    }
}