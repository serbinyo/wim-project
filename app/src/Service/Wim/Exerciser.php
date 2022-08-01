<?php

declare(strict_types=1);
/**
 * Created by PhpStorm
 * User: serbin
 * Date: 01.08.2022
 * Time: 21:32
 */


namespace App\Service\Wim;


/**
 * Class Exerciser
 *
 * @package App\Service\Wim
 */
class Exerciser implements ExerciserInterface
{

    public function addExercise(array $exercise): bool
    {
        echo '<pre>';print_r('addExercise');echo '</pre>';die;
    }
}