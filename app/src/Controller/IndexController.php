<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 */
class IndexController extends AbstractController
{
    /**
     * @throws \Exception
     */
    public function index()
    {
        return new Response(
            '<html><body>Hello world.</body></html>'
        );
    }
}