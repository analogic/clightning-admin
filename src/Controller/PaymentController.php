<?php

namespace App\Controller;

use App\Form\PayType;
use App\Request\PayRequest;
use CLightning\CLightning;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PaymentController extends Controller
{
    /**
     * @Route("/payment", name="payment")
     */
    public function index(CLightning $c)
    {
        return $this->render('payment/index.html.twig', [
            'rpc' => $c
        ]);
    }

    /**
     * @Route("/payment/new", name="payment_new")
     */
    public function new(CLightning $c, Request $request)
    {
        $pr = new PayRequest();
        $form = $this->createForm(PayType::class, $pr);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $c->pay($pr->bolt11, $pr->msatoshi, $pr->description, $pr->riskfactor, $pr->maxfeepercent);
                $this->addFlash('success', 'Payment successfully created');
                return $this->redirectToRoute('payment');
            } catch (\RuntimeException $e) {
                $this->addFlash('danger', 'Error: '.$e->getMessage());
            }
        }

        return $this->render('payment/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
