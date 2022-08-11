<?php

declare(strict_types=1);

namespace App\UseCase\Wim\AddExercise;

use App\DTO\Wim\LapDTO;
use App\Entity\Ulid;
use App\Entity\Wim\Domain\Aggregate\BreathingExercise;
use App\Repository\Wim\BreathingExerciseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 *
 */
class Handler
{
    public BreathingExerciseRepository $breathingExerciseRepository;

    /**
     * Exerciser constructor.
     */
    public function __construct(BreathingExerciseRepository $breathingExerciseRepository)
    {
        $this->breathingExerciseRepository = $breathingExerciseRepository;
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function handle(Command $command)
    {
        /** @var UserInterface $user */
        $user = $command->user;

        /** @var ArrayCollection|LapDTO[] $laps */
        $laps = $command->laps;



        $newExercise = new BreathingExercise(
            new Ulid(),
            $user,
        );
        $newExercise->addLap();


        echo '<pre>';print_r('addExercise');echo '</pre>';die;
    }
}