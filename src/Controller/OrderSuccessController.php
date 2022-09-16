<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderSuccessController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    #[Route('/commande/merci/{stripeSessionId}', name: 'app_order_success')]
    public function index($stripeSessionId, Cart $cart): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        //Sécurité
        // Si l'utilisateur n'existe pas 
        // OU
        // Si $order->getUser() est différent de $this->getUser()
        if(!$order || $order->getUser() !== $this->getUser()){
            return $this->redirectToRoute('app_home');
        }

        // Modifier le statut isPaid de notre commande en mettant 1 (Booléen)
            // Seulement si la commande est en staut 'non payé'
        if(!$order->isIsPaid()){

            $cart->remove(); // JE SUPPRIME MON PANIER APRES LA CONFIRMATION DU PAIEMENT
            $order->setIsPaid(1);
            $this->entityManager->flush();

            // Envoyer un Email à notre client pour lui confirmer çà commande
        }

        // Afficher les quelques information de la commande de l'utilisateur

        // dd($order);
        
        return $this->render('order_success/index.html.twig', [
            'order' => $order
        ]);
    }
}
