<?php

namespace App\Controller\Category;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ObjectconnecteController extends AbstractController
{
    private $entityManager; // 1  

    public function __construct(EntityManagerInterface $entityManager) // 1  
    {
        $this->entityManager = $entityManager; // 1  
    }
    
    #[Route('/object-connecté', name: 'app_object-connecte')]
    public function index(): Response
    {
        $category = $this->entityManager->getRepository(Category::class)->findAll(); // 2
        
        return $this->render('category/object-connecte.html.twig', [
            'category' => $category, 
        ]);
    }
}
