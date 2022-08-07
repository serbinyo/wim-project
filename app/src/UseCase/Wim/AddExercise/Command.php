<?php

declare(strict_types=1);

namespace App\UseCase\Wim\AddExercise;

/**
 * Команда – это простая структура данных,
 * которая представляет текущий запрос пользователя.
 */
class Command
{
    public array $laps;

    public function __construct(array $laps)
    {
        $this->laps = $laps;
    }
}