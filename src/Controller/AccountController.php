<?php
/**
 * Commentaires
 */


namespace App\Controller;

use App\Classe\Cart;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountController extends AbstractController
{
    #[Route('/compte', name: 'app_account')]
    public function index(Cart $cart): Response
    {
        $cart = $cart->get();

        return $this->render('account/index.html.twig', [
            'cart' => $cart
        ]);
    }
}
