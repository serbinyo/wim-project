<?php

declare(strict_types=1);
/**
 * Created by PhpStorm
 * User: serbin
 * Date: 31.07.2022
 * Time: 22:31
 */


namespace App\Repository\Wim;


use App\Entity\Wim\Domain\Aggregate\BreathingExercise;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface BreathingExerciseInterface
 *
 * @package App\Repository\Wim
 *
 */
interface BreathingExerciseInterface
{
    /**
     *
     */
    public const TABLE_NAME = 'breathing_exercise';

    /**
     *
     */
    public function find($id): BreathingExercise;

    public function findOneBy(array $criteria): BreathingExercise;

    public function findAll(): ArrayCollection;

    public function findBy(array $filter): ArrayCollection;

    public function getEmptyObject(): BreathingExercise;
}