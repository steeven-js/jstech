<?php
/**
 * Commentaires
 * 
 * #[Route('/category', name: 'app_nos_category')]
 * 
 * 1. j'appel ma base de donnée
 * 2. Je stock les données issue de ma table (db) Category dans une variable $category (Création de la page catégory/index)
 * 3. Je stock les données issue de ma table (db) Header dans une variable $headers (Je récupère les données pour mon Carousel en haut de la page)
 * 4. Je renvoie les données/requêtes à ma vue twig
 * *******************************************************************
 * 
 * #[Route('/category/{id}', name: 'app_category')] 
 * 
 * 5. Je défini une route avec id comme paramètre de l'url
 * 6. Je stock les données issue de ma table (db) Category dans une variable $category et je les regroupe par id ->findOneById($id)
 * 7. Je vérifie si je retrouve bien id et le nom de la catégorie avec un dd($category);
 * 8. SECURITÉ : Si j'inscris un id dans l'url qui ne fais pas partie de la db je suis redirigé 
 * 9. Je revoie les données de mon tableau category à ma vue twig
 * 
 * #[ORM\OneToMany(mappedBy: 'category', targetEntity: Product::class)]
 *   private Collection $products;

 *   public function __construct()
 *   {
 *       $this->products = new ArrayCollection();
 *   }
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
        $category = $this->entityManager->getRepository(Category::class)->findAll(); // 2

        $headers = $this->entityManager->getRepository(Header::class)->findAll(); // 3
        // dd($headers);

        return $this->render('category/index.html.twig', [
            'category' => $category, // 4 
            'headers' => $headers // 4
        ]);
        
    }
    
    #[Route('/category/{id}', name: 'app_category')] // 5  
    public function show($id): Response
    {
        
        $category = $this->entityManager->getRepository(Category::class)->findOneById($id); // 6  

        // dd($category); // 7  

        // Partie sécurité
        if (!$category){     // 8                 
            return $this->redirectToRoute('app_nos_category');
        }

        return $this->render('category/show.html.twig', [
            'category' => $category, // 9
        ]);
        
    }
}


