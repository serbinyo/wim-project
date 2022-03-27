<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mercure\Authorization;
use Symfony\Component\Mercure\Discovery;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 */
class IndexController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     *
     */
    public function index(Request $request, Discovery $discovery, Authorization $authorization)
    {
        if ($this->getUser()) {

            $username = $this->getUser()->getUserIdentifier();

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
