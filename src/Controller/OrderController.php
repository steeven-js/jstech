<?php

namespace App\Controller;

use App\Form\OrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
     // dd($this->getUser()->getAdresses()->getValue());
        // getUser : get current user
        // getAddresses : get les addresses mais BdD relationnelle => il nous faut les valeurs correspondantes
        // getValues : get les valeurs correspondantes
    #[Route('/commande', name: 'app_order')]
    public function index(): Response
    {
        if( ! $this->getUser()->getAddresses()->getValues()){// si pas d'adresse => redir vers ajouter une adresse
            return $this->redirectToRoute('account_address_add');
        }

         // createForm : OrderType / null (instance de la classe ex : $search etc..) / [current user]
        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

        return $this->render('order/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
