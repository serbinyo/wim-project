<?php

declare(strict_types=1);
/**
 * Created by PhpStorm
 * User: serbin
 * Date: 31.07.2022
 * Time: 21:39
 */


namespace App\Entity\Wim\Domain\Entity;


use App\Entity\Wim\Domain\ValueObject\HoldingTime;
use DateInterval;

/**
 * Class Lap
 *
 * @package App\Entity\Wim\Domain\Entity
 */
class Lap
{
    /**
     * @var int ����� �����
     */
    private int $number;

    /**
     * @var int ���������� ������ �������
     */
    private int $breaths;

    /**
     * @var HoldingTime ������ ������� �������� ������� ��� ������������ ����������
     */
    private HoldingTime $holdingTime;

    /**
     * @var DateInterval ����� �����
     */
    private DateInterval $time;

    /**
     * Lap constructor.
     *
     * @param int         $number
     * @param int         $breaths
     * @param HoldingTime $holdingTime
     */
    public function __construct(int $number, int $breaths, HoldingTime $holdingTime, DateInterval $time)
    {
        $this->number = $number;
        $this->breaths = $breaths;
        $this->holdingTime = $holdingTime;
        $this->time = $time;
    }

    /**
     * @return DateInterval
     */
    public function getTime(): DateInterval
    {
        return $this->time;
    }
}
