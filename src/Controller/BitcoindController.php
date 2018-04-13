<?php

namespace App\Controller;

use App\BitcoindForm\AddressType;
use App\BitcoindForm\PayType;
use App\BitcoindRequest\AddressRequest;
use App\BitcoindRequest\PayRequest;
use App\Form\FundType;
use App\Request\FundRequest;
use Nbobtc\Bitcoind\Client as Bitcoind;
use CLightning\CLightning;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BitcoindController extends Controller
{
    /**
     * @Route("/bitcoind", name="bitcoind")
     */
    public function balances(Bitcoind $c)
    {
        return $this->render('bitcoind/balances.html.twig', [
            'balances' => (array) $c->execute('listaccounts')->result,
            'transactions' => (array) $c->execute('listtransactions', ["", 35])->result,
        ]);
    }

    /**
     * @Route("/bitcoind/address", name="bitcoind_address")
     */
    public function address(Request $request, Bitcoind $c)
    {
        $ar = new AddressRequest();
        $form = $this->createForm(AddressType::class, $ar);
        $address = '';

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $address = (string) $c->execute('getnewaddress', [$ar->account, $ar->type])->result;
                $this->addFlash('success', 'Address generated');
            } catch (\Exception $e) {
                $this->addFlash('danger', 'Error: '.$e->getMessage());
            }
        }

        return $this->render('bitcoind/address.html.twig', array(
            'form' => $form->createView(),
            'address' => $address
        ));
    }

    /**
     * @Route("/bitcoind/pay", name="bitcoind_pay")
     */
    public function pay(Request $request, Bitcoind $c)
    {
        $pr = new PayRequest();
        $form = $this->createForm(PayType::class, $pr);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                if ($pr->fee !== null) {
                    $c->execute('settxfee', [$pr->fee * 100000000 / 1024]);
                }
                $c->execute("sendfrom", [
                    $pr->fromAccount ?? "",
                    $pr->toAddress,
                    $pr->amount,
                    $pr->minconf,
                    $pr->comment,
                    $pr->commentTo
                ]);
                $this->addFlash('success', 'Payment sent');
                return $this->redirectToRoute('bitcoind');
            } catch (\Exception $e) {
                $this->addFlash('danger', 'Error: '.$e->getMessage());
            }
        }

        return $this->render('bitcoind/pay.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
