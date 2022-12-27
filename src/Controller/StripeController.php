<?php
/**
 * Commentaires
 */


namespace App\Controller;

use Stripe\Stripe;
use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\Product;
use Stripe\Checkout\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class StripeController extends AbstractController
{
    #[Route('/commande/create-session/{reference}', name: 'stripe_create_session')]
    public function index(EntityManagerInterface $entityManager, Cart $cart, $reference)
    {
        $YOUR_DOMAIN = 'http://127.0.0.1:8000';
        // $YOUR_DOMAIN = 'http://jsprod.fr';
        $product_for_stripe = [];

        // On récupère la commande en base de données à l'aide de la référence (REQUETE)
        $order = $entityManager->getRepository(Order::class)->findOneByReference($reference);

        // Panier
        foreach ($order->getOrderDetails()->getValues() as $product) {

            $product_object = $entityManager->getRepository(Product::class)->findOneBy([
                'name' => $product->getProduct()]
            );


            $product_for_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product->getPrice(),
                    'product_data' => [
                        'name' => $product->getProduct(),
                        'images' => [$YOUR_DOMAIN."/uploads/".$product_object->getIllustration()],
                    ],
                ],
                'quantity' => $product->getQuantity(),
            ];
        }

        // Transporteur
        $product_for_stripe[] = [
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $order->getCarrierPrice(),
                'product_data' => [
                    'name' => $order->getCarrierName(),
                    'images' => [$YOUR_DOMAIN],
                ],
            ],
            'quantity' => 1,
        ];

        // dd($product_for_stripe);

        // API Stripe pour le paiement
        Stripe::setApiKey('sk_test_51LeOHYBy39DOXZlGW09bx55BbH1bl4HiaBQbUKUns3aW94VFvRowCJUx8b7gohpOWSe7g4ms1y57H3AAub444zsX00ehwupWiB');

        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getEmail(),
            'line_items' => [
                $product_for_stripe
            ],
            'payment_method_types' => [
                'card',
            ],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/commande/merci/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/commande/erreur/{CHECKOUT_SESSION_ID}',
        ]);

        $order->setStripeSessionId($checkout_session->id);

        $entityManager->flush();
 
        return $this->redirect($checkout_session->url);
    }
    
}
