<?php

declare(strict_types=1);

/**
 * Created by PhpStorm
 * User: serbin
 * Date: 31.07.2022
 * Time: 22:29
 */

namespace App\Repository\Wim;


use App\Entity\Ulid;
use App\Entity\User;
use App\Entity\Wim\Domain\Aggregate\BreathingExercise;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class BreathingExerciseRepository
 *
 * @package App\Repository\Wim
 *
 */
class BreathingExerciseRepository implements BreathingExerciseInterface
{
    /**
     * @var
     */
    private $connection;

    /**
     * BreathingExerciseRepository constructor.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->connection = $entityManager->getConnection();
    }

    /**
     * @param $id
     *
     * @return BreathingExercise
     */
    public function find($id): BreathingExercise
    {
        // TODO: Implement find() method.
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     *
     * @return BreathingExercise
     */
    public function findOneBy(array $criteria): BreathingExercise
    {
        // TODO: Implement findOneBy() method.
    }

    /**
     * @return ArrayCollection
     * @throws Exception
     */
    public function findAll(): ArrayCollection
    {
        return $this->findBy([]);
    }

    /**
     * Получить записи по фильтру
     *
     * @param array $filter
     *
     * @return ArrayCollection
     * @throws Exception
     * @throws \Exception
     */
    public function findBy(array $filter): ArrayCollection
    {
        $qb = $this->connection->createQueryBuilder()
            ->from(self::TABLE_NAME)
            ->select('id', 'user_id', 'session_number', 'duration', 'date_create');

        $res = $this->filter($qb, $filter)
            ->executeQuery()->fetchAllAssociative();
        
        return new ArrayCollection($res);
    }

    public function getEmptyObject(): BreathingExercise
    {
        return new BreathingExercise(
            new Ulid(0),
            new User(),
        );
    }

    /**
     * Подготовка фильтра
     *
     * @param QueryBuilder $qb
     * @param array        $filter
     *
     * @return QueryBuilder
     *
     * @throws \Exception
     */
    private function filter(QueryBuilder $qb, array $filter): QueryBuilder
    {
        $qb->where('1 = 1');

        $filter = array_map(
            static function ($item) {
                if (!is_array($item)) {
                    $item = trim((string)$item);
                }

                return $item;
            },
            $filter
        );

        $filter = array_filter($filter);

        if (array_key_exists('id', $filter)) {
            if (is_array($filter['id'])) {
                $qb->andWhere($qb->expr()->in('id', ':id'))
                    ->setParameter('id', $filter['id'], Connection::PARAM_STR_ARRAY);
            } else {
                $qb->andWhere('id = :id')
                    ->setParameter('id', $filter['id']);
            }
        }

        if (array_key_exists('user_id', $filter)) {
            $qb->andWhere('user_id = :user_id')
                ->setParameter('user_id', $filter['user_id']);
        }

        if (array_key_exists('session_number', $filter)) {
            $qb->andWhere('session_number = :session_number')
                ->setParameter('session_number', $filter['session_number']);
        }

        if (array_key_exists('duration', $filter)) {
            $qb->andWhere('duration = :duration')
                ->setParameter('duration', $filter['duration']);
        }

        if (array_key_exists('date_create', $filter)) {
            $qb->andWhere('date_create <= :date_create')
                ->setParameter(
                    'date_create',
                    new DateTime($filter['date_create']),
                    Types::DATETIME_MUTABLE
                );
        }

        return $qb;
    }
}