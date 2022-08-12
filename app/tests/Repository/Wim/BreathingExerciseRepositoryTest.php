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

    public function testFindOneBy()
    {
        $uuid = 'c9e09d42-006f-42fc-90b2-950667953e2a';
        $exercise = $this->breathingExerciseRepository->findOneBy(['id' => $uuid]);

        self::assertEquals($exercise->getUuid()->getUlid(), $uuid);
        self::assertEquals($exercise->getUser()->getEmail(), 'serbinyo@gmail.com');
    }

    public function testFindBy()
    {
    }

    public function testFind()
    {
    }

    public function testAdd()
    {
    }

    public function testGetEmptyObject()
    {
    }

    public function testFindAll()
    {
    }
}
