<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\BreathingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BreathingRepository::class)
 */
class Breathing
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
    private $session;

    /**
     * @ORM\Column(type="integer")
     */
    private $laps;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $duration;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="breathings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Round::class, mappedBy="breath_id", orphanRemoval=true)
     */
    private $rounds;

    public function __construct()
    {
        $this->rounds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSession(): ?int
    {
        return $this->session;
    }

    public function setSession(int $session): self
    {
        $this->session = $session;

        return $this;
    }

    public function getLaps(): ?int
    {
        return $this->laps;
    }

    public function setLaps(int $laps): self
    {
        $this->lap = $laps;

        return $this;
    }

    public function getDuration(): ?float
    {
        return $this->duration;
    }

    public function setDuration(?float $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user;
    }

    public function setUserId(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Round>
     */
    public function getRounds(): Collection
    {
        return $this->rounds;
    }

    public function addRound(Round $round): self
    {
        if (!$this->rounds->contains($round)) {
            $this->rounds[] = $round;
            $round->setBreathId($this);
        }

        return $this;
    }

    public function removeRound(Round $round): self
    {
        if ($this->rounds->removeElement($round)) {
            // set the owning side to null (unless already changed)
            if ($round->getBreathId() === $this) {
                $round->setBreathId(null);
            }
        }

        return $this;
    }
}
