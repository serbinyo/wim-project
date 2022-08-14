<?php

declare(strict_types=1);

namespace App\Tests\Repository\Wim;

use App\Repository\Wim\BreathingExerciseRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 *
 */
class BreathingExerciseRepositoryTest extends KernelTestCase
{
    private BreathingExerciseRepository $breathingExerciseRepository;

    public function __construct()
    {
        parent::__construct();
        static::bootKernel();

        /** @var EntityManagerInterface $entityManager */
        $entityManager = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->breathingExerciseRepository = new BreathingExerciseRepository($entityManager);
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function testFindOneBy()
    {
        $uuid = 'c9e09d42-006f-42fc-90b2-950667953e2a';
        $exercise = $this->breathingExerciseRepository->findOneBy(['id' => $uuid]);

        self::assertEquals($exercise->getUuid()->getUlid(), $uuid);
        self::assertEquals($exercise->getUser()->getEmail(), 'serbinyo@gmail.com');
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function testFindBy()
    {
        $uuid = 'c9e09d42-006f-42fc-90b2-950667953e2a';
        $collection = $this->breathingExerciseRepository->findBy(['id' => $uuid]);

        $exercise = $collection->first();

        self::assertEquals($exercise->getUuid()->getUlid(), $uuid);
        self::assertEquals($exercise->getUser()->getEmail(), 'serbinyo@gmail.com');
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function testFind()
    {
        $uuid = 'c9e09d42-006f-42fc-90b2-950667953e2a';
        $exercise = $this->breathingExerciseRepository->find($uuid);

        self::assertEquals($exercise->getUuid()->getUlid(), $uuid);
        self::assertEquals($exercise->getUser()->getEmail(), 'serbinyo@gmail.com');
    }

    public function testAdd()
    {
        //todo
    }

    public function testGetEmptyObject()
    {
        $emptyBreathingExercise = $this->breathingExerciseRepository->getEmptyObject();

        self::assertEquals($emptyBreathingExercise->getUuid()->getUlid(), '00000000-0000-0000-0000-000000000000');
        self::assertEquals($emptyBreathingExercise->getLaps()->count(), 0);
        self::assertEquals($emptyBreathingExercise->getUser()->getId(), 0);
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function testFindAll()
    {
        $collection = $this->breathingExerciseRepository->findAll();

        self::assertEquals($collection->count(), 2);
    }
}
