<?php

namespace App\Controller\Category;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ImageetsonController extends AbstractController
{
    private $entityManager; // 1  

    public function __construct(EntityManagerInterface $entityManager) // 1  
    {
        $this->entityManager = $entityManager; // 1  
    }
    
    #[Route('/image-et-son', name: 'app_imageetson')]
    public function index(): Response
    {
        $category = $this->entityManager->getRepository(Category::class)->findAll(); 

        return $this->render('category/imageetson.html.twig', [
            'category' => $category, 
        ]);
    }
}
