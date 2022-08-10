<?php

declare(strict_types=1);

namespace App\UseCase\Wim\AddExercise;

use App\Entity\Ulid;
use App\Entity\Wim\Domain\Entity\Lap;
use App\Repository\Wim\BreathingExerciseRepository;
use Doctrine\Common\Collections\ArrayCollection;

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
        $lapsCollection = new ArrayCollection();

        $laps = $command->laps;

        foreach ($command->laps as $lap) {
            $lapsCollection = new Lap(
                new Ulid('')
            );
        }

        $a = $this->breathingExerciseRepository->findOneBy(['id' => 'c9e09d42-006f-42fc-90b2-950667953e2a']);

        echo '<pre>';print_r($a);echo '</pre>';


        echo '<pre>';print_r('addExercise');echo '</pre>';die;
    }
}