<?php

declare(strict_types=1);
/**
 * Created by PhpStorm
 * User: serbin
 * Date: 01.08.2022
 * Time: 19:51
 */


namespace App\Controller\Wim;


use App\UseCase\Wim\AddExercise\Command;
use App\UseCase\Wim\AddExercise\Handler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
    public function add(Request $request, Handler $handler)
    {
        $laps = json_decode($request->request->get('laps'), true);

        $command = new Command($laps);

        $handler->handle($command);

        return $this->json($laps, Response::HTTP_CREATED, [], []);
    }

}