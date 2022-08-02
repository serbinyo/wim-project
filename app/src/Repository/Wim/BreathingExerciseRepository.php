<?php
/**
 * Created by PhpStorm
 * User: serbin
 * Date: 31.07.2022
 * Time: 22:29
 */


namespace App\Repository\Wim;


use App\Entity\Wim\Domain\Aggregate\BreathingExercise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class BreathingExerciseRepository
 *
 * @package App\Repository\Wim
 *
 * @method BreathingExercise|null find($id, $lockMode = null, $lockVersion = null)
 * @method BreathingExercise|null findOneBy(array $criteria, array $orderBy = null)
 * @method BreathingExercise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BreathingExerciseRepository extends ServiceEntityRepository implements BreathingExerciseInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BreathingExercise::class);
    }
}