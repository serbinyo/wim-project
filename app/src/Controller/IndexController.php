<?php

declare(strict_types=1);

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
     * @throws Exception
     */
    public function index()
    {
        return new Response(
            $this->twig->render('homepage/index.html.twig')
        );
    }
}