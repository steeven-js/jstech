<?php

namespace App\Controller;

use App\Classe\Cart;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AboutController extends AbstractController
{
    #[Route('/about', name: 'app_about')]
    public function index(Cart $cart): Response
    {
        $cart = $cart->get();

        return $this->render('about/index.html.twig', [
            'cart' => $cart
        ]);
    }
}
