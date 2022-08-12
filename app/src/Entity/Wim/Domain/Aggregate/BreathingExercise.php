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
use App\Repository\Wim\BreathingExerciseRepositoryInterface;
use App\Service\DateMaker;
use DateInterval;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\Wim\BreathingExerciseRepository;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class BreathingExercise
 *
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
     *
     * @param ArrayCollection|Lap[]
     */
    private ArrayCollection $laps;

    /**
     * @ORM\Column(type="string")
     */
    private DateInterval $duration;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private DateTimeImmutable $dateCreate;

    /**
     * BreathingExercise constructor.
     *
     * @param Ulid $uuid
     * @param UserInterface $user
     */
    public function __construct(Ulid $uuid, UserInterface $user, DateTimeImmutable $dateCreate)
    {
        $this->uuid = $uuid;
        $this->user = $user;
        $this->dateCreate = $dateCreate;
        $this->laps = new ArrayCollection();
    }

    /**
     * ƒобавить новое упражнение в базу
     *
     * @param BreathingExerciseRepositoryInterface $storage
     *
     * @return $this
     */
    public function save(BreathingExerciseRepositoryInterface $storage)
    {
        $storage->add($this);
        return $this;
    }

    public function addLap(Lap $lap): self
    {
        if (!$this->laps->contains($lap)) {
            $this->laps[] = $lap;
            $lap->setBreathingExercise($this);
        }

        return $this;
    }

    /**
     *
     */
    public function countDuration()
    {
        $duration = DateMaker::intervalEmpty();

        foreach ($this->laps as $lap) {
            $duration += $lap->getTime();
        }

        $this->duration = $duration;
    }

    /**
     *
     * ”становить новый пор€дковый номер упражнени€
     *
     * @return BreathingExercise
     */
    public function assignNewSessionNumber(): BreathingExercise
    {
        //todo

        return $this;
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
     *
     * @return BreathingExercise
     */
    public function setDuration(DateInterval $duration): BreathingExercise
    {
        $this->duration = $duration;

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
     * @return DateInterval
     */
    public function getDuration(): DateInterval
    {
        return $this->duration;
    }

    /**
     * @return Collection<int, Lap>
     */
    public function getLaps(): Collection
    {
        return $this->laps;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}