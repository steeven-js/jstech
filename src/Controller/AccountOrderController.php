<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountOrderController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/compte/mes-commandes', name: 'app_account_order')]
    public function index(Cart $cart): Response
    {
        $orders = $this->entityManager->getRepository(Order::class)->findSucessOrders($this->getUser());

        // dd($orders);

        $count = $cart->count();

        return $this->render('account/order.html.twig', [
            'orders' => $orders,
            'count' => $count,
        ]);
    }

    #[Route('/compte/mes-commandes/{reference}', name: 'app_account_order_show')]
    public function show($reference, Cart $cart): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        
        $count = $cart->count();

        $order = $this->entityManager->getRepository(Order::class)->findOneByReference($reference);

        // SECURITÉ 
        if (!$order || $order->getUser() != $this->getUser()) {
            
            return $this->redirectToRoute('app_account_order');
        }

        return $this->render('account/order_show.html.twig', [
            'order' => $order,
            'count' => $count,
        ]);
    }
}
