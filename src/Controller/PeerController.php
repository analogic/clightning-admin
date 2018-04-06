<?php

namespace App\Controller;

use App\Form\ConnectType;
use App\Request\ConnectRequest;
use CLightning\CLightning;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PeerController extends Controller
{
    /**
     * @Route("/peer", name="peer")
     */
    public function index(CLightning $c)
    {
        return $this->render('peer/index.html.twig', [
            'rpc' => $c,
        ]);
    }

    /**
     * @Route("/peer/connect", name="connect")
     */
    public function connect(CLightning $c, Request $request)
    {
        $connect = new ConnectRequest();
        $form = $this->createForm(ConnectType::class, $connect);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $c->connect($connect->id, $connect->host);
                $this->addFlash('success', 'Successfully connected');
                return $this->redirectToRoute('peer');
            } catch (\RuntimeException $e) {
                $this->addFlash('danger', 'Error: '.$e->getMessage());
            }
        }

        return $this->render('peer/connect.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
