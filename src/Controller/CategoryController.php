<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Header;
use App\Entity\Product;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    private $entityManager; // 1  

    public function __construct(EntityManagerInterface $entityManager) // 1  
    {
        $this->entityManager = $entityManager; // 1  
    }
    
    #[Route('/category', name: 'app_nos_category')]
    public function idex(Cart $cart): Response
    {
        $category = $this->entityManager->getRepository(Category::class)->findAll(); // 2

        $cart = $cart->get();

        return $this->render('category/index.html.twig', [
            'category' => $category, // 4 
            'cart' => $cart
        ]);
        
    }
    
    #[Route('/category/{id}', name: 'app_category')] // 5  
    public function show($id, Cart $cart): Response
    {
        $category = $this->entityManager->getRepository(Category::class)->findOneById($id); // 6  

        // dd($category); // 7  

        // Partie sécurité
        if (!$category){     // 8                 
            return $this->redirectToRoute('app_nos_category');
        }

        $cart = $cart->get();

        return $this->render('category/show.html.twig', [
            'category' => $category, // 9
            'cart' => $cart
        ]);
        
    }
}


