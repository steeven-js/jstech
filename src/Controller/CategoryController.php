<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    private $entityManager; 

    public function __construct(EntityManagerInterface $entityManager)    
    {
        $this->entityManager = $entityManager;    
    }
    
    #[Route('/category', name: 'app_nos_category')]
    public function idex(Cart $cart): Response
    {
        $category = $this->entityManager->getRepository(Category::class)->findAll(); // 2

        $count = $cart->count();

        return $this->render('category/index.html.twig', [
            'category' => $category, // 4 
            'count' => $count
        ]);
        
    }
    
    #[Route('/category/{id}', name: 'app_category')]   
    public function show($id, Cart $cart): Response
    {
        $count = $cart->count();

        $categoryid = $this->entityManager->getRepository(Category::class)->findOneById($id);   

        // Partie sécurité
        if (!$categoryid){                   
            return $this->redirectToRoute('app_nos_category');
        }

        $categoryProduct = $categoryid->getProducts()->getValues();

        // dd($category->getProducts()->getValues());   

        // dd($categoryProduct);

        return $this->render('category/show.html.twig', [
            'categoryid' => $categoryid,
            'categoryProduct' => $categoryProduct,  
            'count' => $count,
        ]);
        
    }
}


