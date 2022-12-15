<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Classe\Mail;
use App\Entity\Header;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    private $entityManager;
	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;	
	}


    #[Route('/', name: 'app_home')]
    public function index(Cart $cart): Response
    {
        // $mail = new Mail();
        // $mail->send('kisama972@gmail.com', 'adminJSTECH', 'Mon premier mail', "Bonjour steeven, j'espère que tu vas bien");

        //Produits début
        // Les nouveautés
        $productsNew = $this->entityManager->getRepository(Product::class)->findByIsNew(1);

        // Les meilleurs ventes
        $productsBest = $this->entityManager->getRepository(Product::class)->findByIsBest(1);
        //Produits fin

        // Carousel
        $headers = $this->entityManager->getRepository(Header::class)->findAll(); 

        $cart = $cart->get();

        // dd($cart->get());

        // dd($productsNew);

        return $this->render('home/index.html.twig', [
            'headers' => $headers,
            'productsBest'  => $productsBest,
            'productsNew' => $productsNew,
            'cart' => $cart
        ]);
    }
}
