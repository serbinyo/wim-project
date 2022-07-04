<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\RoundRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoundRepository::class)
 */
class Round
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $lap;

    /**
     * @ORM\Column(type="integer")
     */
    private $breaths;

    /**
     * @ORM\Column(type="time")
     */
    private $hold_time;

    /**
     * @ORM\Column(type="time")
     */
    private $round_time;

    /**
     * @ORM\ManyToOne(targetEntity=Breathing::class, inversedBy="rounds")
     * @ORM\JoinColumn(nullable=false)
     */
    private $breath;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLap(): ?int
    {
        return $this->lap;
    }

    public function setLap(int $lap): self
    {
        $this->lap = $lap;

        return $this;
    }

    public function getBreaths(): ?int
    {
        return $this->breaths;
    }

    public function setBreaths(int $breaths): self
    {
        $this->breaths = $breaths;

        return $this;
    }

    public function getHoldTime(): ?\DateTimeInterface
    {
        return $this->hold_time;
    }

    public function setHoldTime(\DateTimeInterface $hold_time): self
    {
        $this->hold_time = $hold_time;

        return $this;
    }

    public function getRoundTime(): ?\DateTimeInterface
    {
        return $this->round_time;
    }

    public function setRoundTime(\DateTimeInterface $round_time): self
    {
        $this->round_time = $round_time;

        return $this;
    }

    public function getBreathId(): ?Breathing
    {
        return $this->breath;
    }

    public function setBreathId(?Breathing $breath): self
    {
        $this->breath = $breath;

        return $this;
    }
}
