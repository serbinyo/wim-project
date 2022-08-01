<?php

declare(strict_types=1);
/**
 * Created by PhpStorm
 * User: serbin
 * Date: 01.08.2022
 * Time: 19:51
 */


namespace App\Controller\Wim;


use App\Service\Wim\Exerciser;
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
     */
    #[Route('/breath/add', name: 'addBreathExercise', methods: ['POST'])]
    public function add(Request $request, Exerciser $exerciser)
    {
        $laps = json_decode($request->request->get('laps'), true);

        $exerciser->addExercise($laps);

        return $this->json($laps, Response::HTTP_CREATED, [], []);
    }

}