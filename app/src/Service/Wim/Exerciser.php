<?php

declare(strict_types=1);
/**
 * Created by PhpStorm
 * User: serbin
 * Date: 01.08.2022
 * Time: 21:32
 */


namespace App\Service\Wim;


use App\Repository\Wim\BreathingExerciseRepository;

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

    public function addExercise(array $exercise): bool
    {


        echo '<pre>';print_r('addExercise');echo '</pre>';die;
    }
}