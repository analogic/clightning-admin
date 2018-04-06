<?php

namespace App\Controller;

use App\Form\InvoiceType;
use App\Request\InvoiceRequest;
use CLightning\CLightning;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InvoiceController extends Controller
{
    /**
     * @Route("/invoice", name="invoice")
     */
    public function index(CLightning $c)
    {
        return $this->render('invoice/index.html.twig', [
            'rpc' => $c,
        ]);
    }

    /**
     * @Route("/invoice/new", name="invoice_new")
     */
    public function new(CLightning $c, Request $request)
    {
        $invoice = new InvoiceRequest();
        $invoice->label = uniqid();

        $form = $this->createForm(InvoiceType::class, $invoice);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $c->invoice($invoice->milliSatoshi, $invoice->label, $invoice->description, $invoice->expiry);
                $this->addFlash('success', 'Invoice successfully created');
                return $this->redirectToRoute('invoice');
            } catch (\RuntimeException $e) {
                $this->addFlash('danger', 'Error: '.$e->getMessage());
            }
        }

        return $this->render('invoice/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
