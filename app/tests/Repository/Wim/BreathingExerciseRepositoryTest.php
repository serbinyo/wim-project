<?php

declare(strict_types=1);

namespace App\Tests\Repository\Wim;

use App\Repository\Wim\BreathingExerciseRepository;
use App\Service\Builder\Entity\Wim\Domain\Aggregate\BreathingExerciseBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 *
 */
class BreathingExerciseRepositoryTest extends KernelTestCase
{
    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function testFindOneBy()
    {
        $uuid = 'c9e09d42-006f-42fc-90b2-950667953e2a';
        $breathingExerciseRepository = $this->getStorage();
        $exercise = $breathingExerciseRepository->findOneBy(['id' => $uuid]);

        self::assertEquals($exercise->getUuid()->getUlid(), $uuid);
        self::assertEquals($exercise->getUser()->getEmail(), 'serbinyo@gmail.com');
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function testFindBy()
    {
        $uuid = 'c9e09d42-006f-42fc-90b2-950667953e2a';
        $breathingExerciseRepository = $this->getStorage();
        $collection = $breathingExerciseRepository->findBy(['id' => $uuid]);

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
        $breathingExerciseRepository = $this->getStorage();
        $exercise = $breathingExerciseRepository->find($uuid);

        self::assertEquals($exercise->getUuid()->getUlid(), $uuid);
        self::assertEquals($exercise->getUser()->getEmail(), 'serbinyo@gmail.com');
    }

    public function testAdd()
    {
        $breathingExerciseRepository = $this->getStorage();
        $before = $breathingExerciseRepository->findAll()->count();
        $exercise = BreathingExerciseBuilder::buildTestObject();
        $breathingExerciseRepository->add($exercise);
        $after = $breathingExerciseRepository->findAll()->count();

        self::assertEquals($after, $before + 1);
    }

    public function testGetEmptyObject()
    {
        $breathingExerciseRepository = $this->getStorage();
        $emptyBreathingExercise = $breathingExerciseRepository->getEmptyObject();

        self::assertEquals($emptyBreathingExercise->getUuid()->getUlid(), '00000000-0000-0000-0000-000000000000');
        self::assertEquals($emptyBreathingExercise->getLaps()->count(), 0);
        self::assertEquals($emptyBreathingExercise->getUser()->getId(), 0);
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function testFindAll()
    {
        $breathingExerciseRepository = $this->getStorage();
        $collection = $breathingExerciseRepository->findAll();

        self::assertEquals($collection->count(), 2);
    }

    public function testRemoveBy()
    {
        $uuid = 'c9e09d42-006f-42fc-90b2-950667953e2a';

        $breathingExerciseRepository = $this->getStorage();
        $before = $breathingExerciseRepository->findAll()->count();
        $breathingExerciseRepository->removeBy(['id' => $uuid]);
        $after = $breathingExerciseRepository->findAll()->count();

        self::assertEquals($after, $before -1);
    }

    public function testRemove()
    {
        $uuid = 'c9e09d42-006f-42fc-90b2-950667953e2a';

        $breathingExerciseRepository = $this->getStorage();
        $before = $breathingExerciseRepository->findAll()->count();
        $breathingExerciseRepository->remove($uuid);
        $after = $breathingExerciseRepository->findAll()->count();

        self::assertEquals($after, $before -1);
    }


    /**
     * @return BreathingExerciseRepository
     */
    private function getStorage(): BreathingExerciseRepository
    {
        static::bootKernel();

        /** @var EntityManagerInterface $entityManager */
        $entityManager = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        return new BreathingExerciseRepository($entityManager);
    }
}
