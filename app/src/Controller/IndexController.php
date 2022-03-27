<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mercure\Authorization;
use Symfony\Component\Mercure\Discovery;
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
     */
    public function index(Request $request, Discovery $discovery, Authorization $authorization)
    {
        if ($this->getUser()) {

            $discovery->addLink($request);
            $authorization->setCookie($request, [
                '*'
            ]);


            $response =  $this->render('index/index.html.twig', [
                'controller_name' => 'IndexController',
            ]);


        } else {
            $response =  $this->render('index/index.html.twig', [
                'controller_name' => 'IndexController',
            ]);
        }

        return $response;
    }
}
