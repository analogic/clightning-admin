<?php

namespace App\Controller;

use App\Form\ChannelType;
use App\Form\ConnectType;
use App\Form\FundType;
use App\Request\ChannelRequest;
use App\Request\ConnectRequest;
use App\Request\FundRequest;
use CLightning\CLightning;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ChannelController extends Controller
{
    /**
     * @Route("/channel", name="channel")
     */
    public function index(CLightning $c)
    {
        return $this->render('channel/index.html.twig', [
            'rpc' => $c
        ]);
    }


    /**
     * @Route("/channel/{id}/fund", name="fund")
     */
    public function fund(string $id, CLightning $c, Request $request)
    {
        $fund = new FundRequest();
        $fund->id = $id;
        $form = $this->createForm(FundType::class, $fund);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $c->fundchannel($fund->id, $fund->satoshi);
                $this->addFlash('success', 'Successfully connected');
                return $this->redirectToRoute('channel');
            } catch (\RuntimeException $e) {
                $this->addFlash('danger', 'Error: '.$e->getMessage());
            }
        }

        return $this->render('channel/fund.html.twig', array(
            'form' => $form->createView(),
            'id' => $id
        ));
    }

    /**
     * @Route("/channel/{id}/close", name="close")
     */
    public function close(string $id, CLightning $c)
    {
        try {
            $c->close($id);
            $this->addFlash('success', 'Successfully closed');
        } catch (\RuntimeException $e) {
            $this->addFlash('danger', 'Error: '.$e->getMessage());
        }

        return $this->redirectToRoute('channel');
    }
}
