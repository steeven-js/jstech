<?php
/**
 * Commentaires
 */


namespace App\Controller;

use App\Classe\Cart;
use App\Classe\Search;
use App\Entity\Product;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProductController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/nos-produits', name: 'app_products')]
    public function index(Request $request, Cart $cart): Response
    {
        
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $products = $this->entityManager->getRepository(Product::class)->findWithSearch($search);
        } else {
            $products = $this->entityManager->getRepository(Product::class)->findAll();
        }

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
            'cart' => $cart->getFull()
        ]);
    }

    #[Route('/produit/{slug}', name: 'app_product')]
    public function show($slug, Cart $cart): Response
    {
        // dd($slug);
        // On recherche en base de donnée un produit associer à son slug.
        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);

        // dd($product);

         // Partie sécurité
        if (!$product){
            return $this->redirectToRoute('app_products');
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'cart' => $cart->getFull()
        ]);
    }
}
