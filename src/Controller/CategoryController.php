<?php
/**
 * Commentaires
 * 
 * #[Route('/category', name: 'app_nos_category')]
 * 
 * 1. j'appel ma base de donnée
 * 1. Je stock les données issue de ma table (db) dans une variable
 * 1. Je renvoie les requêtes à ma vue twig
 * *******************************************************************
 * 
 * #[Route('/category/{id}', name: 'app_category')] 
 * 
 * 1. Je stock les données issue de ma table (db) dans une variable
 * 1. Je défini une route avec un id comme paramètre de l'url
 * 1. On recherche en base de donnée un produit associer à son id.
 * 1. Je vérifie si je retrouve bien id et le nom de la catégorie avec un dd($category);
 * 1. Si j'inscris un id dans l'url qui ne fais pas partie de la db je suis redirigé 
 * 1. Lorsque j'ai crée l'entité Category, j'ai fais une relation avec l'entité Product
 * 1. Je revoie les données de mon tableau category à ma vue twig
 * 1. Je revoie les données de mon tableau product à ma vue twig
 */

namespace App\Controller;

use App\Entity\Header;
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
    public function idex(): Response
    {
        $category = $this->entityManager->getRepository(Category::class)->findAll(); // 1  

        $headers = $this->entityManager->getRepository(Header::class)->findAll(); // 1  
        // dd($headers);

        return $this->render('category/index.html.twig', [
            'category' => $category, // 1  
            'headers' => $headers // 1  
        ]);
        
    }
    
    #[Route('/category/{id}', name: 'app_category')] // 1  
    public function show($id): Response
    {
        
        $category = $this->entityManager->getRepository(Category::class)->findOneById($id); // 1  

        // dd($category); // 1  

        // Partie sécurité
        if (!$category){     // 1                 
            return $this->redirectToRoute('app_nos_category');
        }

        $product = $category->getProducts(); // 1  

        // dd($product);

        return $this->render('category/show.html.twig', [
            'category' => $category, // 1 
            'product' => $product // 1 
            
        ]);
        
    }
}


