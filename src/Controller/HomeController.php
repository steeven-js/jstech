<?php
/**
 * Commentaires
 */


namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Header;
use App\Entity\Category;
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
        $category = $this->entityManager->getRepository(Category::class)->findAll(); // 2

        $headers = $this->entityManager->getRepository(Header::class)->findall();
        // dd($headers);
        // dd($cart->get());
        
        return $this->render('home/index.html.twig', [
            'headers' => $headers,
            'category' => $category,
            'cart' => $cart->getFull()
        ]);
    }
}
