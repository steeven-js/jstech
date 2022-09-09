<?php

namespace App\Controller;

use App\Classe\Cart;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    // Mon panier
    #[Route('/mon-panier', name: 'app_cart')]
    public function index(Cart $cart)
    {
        
        return $this->render('cart/index.html.twig', [
            'cart' => $cart->getFull()
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


        return $this->redirectToRoute('app_products');

    }

    // Suppression du produit
    #[Route('/cart/delete/{id}', name: 'delete_to_cart')]
    public function delete(Cart $cart, $id)
    {
        // je définis delete dans l'entité Cart
        $cart->delete($id);

        
        return $this->redirectToRoute('app_cart');

    }

    // REDUIRE
    #[Route('/cart/descrease/{id}', name: 'decrease_to_cart')]
    public function decrease(Cart $cart, $id)
    {
        // je définis decrease dans l'entité Cart
        $cart->decrease($id);

    
        return $this->redirectToRoute('app_cart');

    }

}