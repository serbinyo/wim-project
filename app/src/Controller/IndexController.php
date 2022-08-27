<?php

declare(strict_types=1);

namespace App\Controller;

use App\UseCase\Wim\FillUserExercises\Command;
use App\UseCase\Wim\FillUserExercises;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 *
 */
class IndexController extends AbstractController
{
    private Environment $twig;

    /**
     * ConferenceController constructor.
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/", name="homepage")
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function index(FillUserExercises\Handler $getExercisesService)
    {
        $user = $this->getUser();

        if ($user !== null) {
            $getExercisesService->handle(
                new Command($user)
            );
        }

        $response =  $this->render('index/index.html.twig');

        return $response;
    }
}
