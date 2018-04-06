<?php

namespace App\Controller;

use CLightning\CLightning;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InfoController extends Controller
{
    /**
     * @Route("/info", name="info")
     */
    public function index(CLightning $c)
    {
        return $this->render('info/index.html.twig', [
            'rpc' => $c,
        ]);
    }
}
