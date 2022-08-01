<?php

declare(strict_types=1);
/**
 * Created by PhpStorm
 * User: serbin
 * Date: 01.08.2022
 * Time: 21:27
 */


namespace App\Service\Wim;


/**
 * Interface ExerciserInterface
 *
 * @package App\Service\Wim
 */
interface ExerciserInterface
{
    public function addExercise(array $exercise): bool;
}