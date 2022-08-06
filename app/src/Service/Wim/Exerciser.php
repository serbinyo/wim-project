<?php

declare(strict_types=1);
/**
 * Created by PhpStorm
 * User: serbin
 * Date: 01.08.2022
 * Time: 21:32
 */


namespace App\Service\Wim;


use App\Entity\Wim\Domain\Aggregate\BreathingExercise;
use App\Repository\Wim\BreathingExerciseRepository;
use Exception;

/**
 * Class Exerciser
 *
 * @package App\Service\Wim
 */
class Exerciser implements ExerciserInterface
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
     * @throws Exception
     */
    public function addExercise(array $exercise): bool
    {
        $a = $this->breathingExerciseRepository->findOneBy(['id' => 'c9e09d42-006f-42fc-90b2-950667953e2a']);

        echo '<pre>';print_r($a);echo '</pre>';

        echo '<pre>';print_r($exercise);echo '</pre>';


        echo '<pre>';print_r('addExercise');echo '</pre>';die;
    }
}