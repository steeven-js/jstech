<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
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
    public function index(): Response
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();


        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }

     #[Route('/produit/{slug}', name: 'app_product')]
    public function show($slug): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);

        if (!$product){
            return $this->redirectToRoute('products');
        }

        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }
}
