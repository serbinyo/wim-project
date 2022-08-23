<?php

declare(strict_types=1);

namespace App\Tests\Entity\Wim\Domain\Aggregate;

use App\Entity\Wim\Domain\Aggregate\BreathingExercise;
use App\Repository\Wim\BreathingExerciseRepository;
use App\Service\Builder\Entity\Wim\Domain\Aggregate\BreathingExerciseBuilder;
use App\Service\Builder\Entity\Wim\Domain\Entity\LapBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 *
 */
class BreathingExerciseTest extends KernelTestCase
{
    private BreathingExercise $exercise;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->exercise = BreathingExerciseBuilder::buildTestObject();
    }

    public function testCountDuration()
    {
        $exercise = $this->exercise;

        $newLap1 = LapBuilder::buildTestObject();
        $newLap2 = LapBuilder::buildTestObject();

        $exercise2 = clone $this->exercise;
        $exercise2->addLap($newLap1);
        $exercise2->addLap($newLap2);

        $exercise->addLap($newLap1);
        $exercise->addLap($newLap2);

        self::assertEquals($exercise->getDuration(), $exercise2->getDuration());
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function testSave()
    {
        $breathingExerciseRepository = $this->getStorage();

        $before = $breathingExerciseRepository->findAll()->count();

        $exercise = $this->exercise;

        $exercise->save($breathingExerciseRepository);

        $after = $breathingExerciseRepository->findAll()->count();

        self::assertEquals($after, $before + 1);
    }

    public function testAddLap()
    {
        $exercise = $this->exercise;

        $before = $exercise->getLaps()->count();

        $newLap1 = LapBuilder::buildTestObject();
        $newLap2 = LapBuilder::buildTestObject();

        $exercise->addLap($newLap1);
        $exercise->addLap($newLap2);

        self::assertEquals($exercise->getLaps()->count(), $before + 2);
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
