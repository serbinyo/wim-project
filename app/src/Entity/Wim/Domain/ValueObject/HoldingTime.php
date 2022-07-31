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
 * Class BreathHolding
 *
 * ����� ������� ������� �������� ������� �� ����� � ������, � ����� �����
 *
 * @package App\Entity\Wim\Domain\ValueObject
 */
class HoldingTime
{
    /**
     * @var int �������� �� ������ (�������� ����� ������), ���.
     */
    private int $exhaleHold;

    /**
     * @var int �������� �� �����, ���.
     */
    private int $inhaleHold;

    /**
     * BreathHolding constructor.
     *
     * @param int $exhaleHold
     * @param int $inhaleHold
     */
    public function __construct(int $exhaleHold, int $inhaleHold)
    {
        $this->exhaleHold = $exhaleHold;
        $this->inhaleHold = $inhaleHold;
    }
}
