<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)

    {
        $this->entityManager = $entityManager;
    }

    // Mon panier
    #[Route('/mon-panier', name: 'app_cart')]
    public function index(Cart $cart)
    {
        $cartComplete = [];

        // je définis get dans l'entité Cart
        foreach ($cart->get() as $id => $quantity){
            $cartComplete[] = [
                'product' => $this->entityManager->getRepository(Product::class)->findOneById($id),
                'quantity' => $quantity
            ];
        }

        return $this->render('cart/index.html.twig', [
            'cart' => $cartComplete
        ]);
    }

    // Ajout
    #[Route('/cart/add/{id}', name: 'add_to_cart')]
    public function add(Cart $cart, $id)
    {
        // je définis add dans l'entité Cart
        $cart->add($id);

        return $this->redirectToRoute('app_cart');

    }

    // Suppression de panier 
    #[Route('/cart/remove', name: 'remove_my_cart')]
    public function remove(Cart $cart)
    {
        // je définis remove dans l'entité Cart
        $cart->remove();

        // Il s'agit du remove de la biblihothèque SessionInterface (Removes an attribute.)
        return $this->redirectToRoute('app_products');

    }

    // Suppression du produit
    #[Route('/cart/delete/{id}', name: 'delete_to_cart')]
    public function delete(Cart $cart, $id)
    {
        // je définis remove dans l'entité Cart
        $cart->delete($id);

        // Il s'agit du remove de la biblihothèque SessionInterface (Removes an attribute.)
        return $this->redirectToRoute('app_cart');

    }

    // REDUIRE
    #[Route('/cart/descrease/{id}', name: 'decrease_to_cart')]
    public function decrease(Cart $cart, $id)
    {
        // je définis remove dans l'entité Cart
        $cart->decrease($id);

        // Il s'agit du remove de la biblihothèque SessionInterface (Removes an attribute.)
        return $this->redirectToRoute('app_cart');

    }


}