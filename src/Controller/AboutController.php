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
        $count = $cart->count();

        return $this->render('about/index.html.twig', [
            'count' => $count,
        ]);
    }
}
