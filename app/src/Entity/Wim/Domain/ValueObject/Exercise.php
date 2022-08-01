<?php

declare(strict_types=1);
/**
 * Created by PhpStorm
 * User: serbin
 * Date: 31.07.2022
 * Time: 21:51
 */


namespace App\Entity\Wim\Domain\ValueObject;


/**
 * Class Exercise
 *
 * ����� ������� ����������� ���� ������ ���������� (��� �����)
 *
 * @package App\Entity\Wim\Domain\ValueObject
 */
class Exercise
{
    /**
     * @var int ���������� ������ �������
     */
    private int $breaths;

    /**
     * @var int �������� �� ������ (�������� ����� ������), ���.
     */
    private int $exhaleHold;

    /**
     * @var int �������� �� �����, ���.
     */
    private int $inhaleHold;


    /**
     * Exercise constructor.
     *
     * @param int $exhaleHold
     * @param int $breaths
     * @param int $inhaleHold
     */
    public function __construct(int $exhaleHold, int $breaths, int $inhaleHold)
    {
        $this->breaths = $breaths;
        $this->exhaleHold = $exhaleHold;
        $this->inhaleHold = $inhaleHold;
    }

    /**
     * @return int
     */
    public function getExhaleHold(): int
    {
        return $this->exhaleHold;
    }

    /**
     * @return int
     */
    public function getInhaleHold(): int
    {
        return $this->inhaleHold;
    }

    /**
     * @return int
     */
    public function getBreaths(): int
    {
        return $this->breaths;
    }
}
