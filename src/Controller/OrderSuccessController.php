<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Classe\Mail;
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
        // Si la commande n'existe pas OU que l'utilisateur ne correspond pas à celui actuellement connecté ALORS
        if(!$order || $order->getUser() !== $this->getUser()){
            return $this->redirectToRoute('app_home');
        }

        // Modifier le statut State de notre commande en mettant 1 (payée)
        // Seulement si la commande est en staut 'non payé'
        if($order->getState() == 0){

            // Vider la session "cart"
            $cart->remove(); // JE SUPPRIME MON PANIER APRES LA CONFIRMATION DU PAIEMENT

            // Modifier le statut State de notre commande en mettant 1
            $order->setState(1); // Mise à jour du statut
            $this->entityManager->flush(); // Mise à jour doctrine

            // Envoyer un Email à notre client pour lui confirmer çà commande
            // $mail = new Mail();
            // $content = "Merci pour votre commande";
            // $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstname(), 'Votre commande jstech est bien validée', $content);
        }

        // Afficher les quelques information de la commande de l'utilisateur

        // dd($order);

        $cart = $cart->get();
        
        return $this->render('order_success/index.html.twig', [
            'order' => $order,
            'cart' => $cart->getFull()
        ]);
    }
}
