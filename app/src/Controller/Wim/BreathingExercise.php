<?php

declare(strict_types=1);
/**
 * Created by PhpStorm
 * User: serbin
 * Date: 01.08.2022
 * Time: 19:51
 */


namespace App\Controller\Wim;


use App\DTO\Wim\TestLapDTO;
use App\Service\Serializer\Deserializer;
use App\UseCase\Wim\AddExercise\Command;
use App\UseCase\Wim\AddExercise\Handler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class BreathingExercise
 *
 * @package App\Controller\Wim
 */
class BreathingExercise extends AbstractController
{
    /**
     *
     * @return JsonResponse
     * @throws \Doctrine\DBAL\Exception
     */
    #[Route('/breath/add', name: 'addBreathExercise', methods: ['POST'])]
    public function add(Request $request, Handler $handler, UserInterface $user)
    {
        $laps = (new Deserializer())
            ->jsonCollectionToObjectCollection($request->request->get('laps'), TestLapDTO::class);

        $command = new Command($user, $laps);

        $handler->handle($command);

        return $this->json($laps, Response::HTTP_CREATED, [], []);
    }

}