<?php

namespace App\Controller;

use App\Entity\Header;
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
    public function idex(): Response
    {
        $category = $this->entityManager->getRepository(Category::class)->findAll();

        $headers = $this->entityManager->getRepository(Header::class)->findall();
        // dd($headers);

        return $this->render('category/index.html.twig', [
            'category' => $category,
            'headers' => $headers
        ]);
        
    }
    
    #[Route('/category/{id}', name: 'app_category')]
    public function show($id): Response
    {
        // dd($slug);
        // On recherche en base de donnée un produit associer à son slug.
        $category = $this->entityManager->getRepository(Category::class)->findOneById($id);

        $products = $category->getProducts();

        // dd($category);

        return $this->render('category/show.html.twig', [
            'category' => $category,
            'products' => $products
            
        ]);
        
    }
}
