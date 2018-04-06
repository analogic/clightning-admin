<?php

namespace App\Controller;

use CLightning\CLightning;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FundsController extends Controller
{
    /**
     * @Route("/funds", name="funds")
     */
    public function index(CLightning $c)
    {
        return $this->render('funds/index.html.twig', [
            'rpc' => $c
        ]);
    }

    /**
     * @Route("/address", name="address")
     */
    public function address(CLightning $c)
    {
        return $this->render('funds/address.html.twig', [
            'rpc' => $c,
        ]);
    }
}
