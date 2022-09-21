<?php
/**
 * Commentaires
 */


namespace App\Controller;

use App\Classe\Cart;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    // Mon panier

    // Récapitulatif de mon panier. On le renomme 'mon-panier'
	// Pour debugger la session et ce qui se trouve dans cart
	//Embarque avec toi ma class Cart dans une variable $cart
    #[Route('/mon-panier', name: 'app_cart')]
    public function index(Cart $cart)
    {
        // dans le dd on dit: "$cart tu m'affiche le contenu du panier
		// On va donc créer une fonction get() dans la Class Cart
        // dd($cart->get());
        
        return $this->render('cart/index.html.twig', [
            'cart' => $cart->getFull()
        ]);
    }

    // Ajout
    #[Route('/cart/add/{id}', name: 'add_to_cart')]
    public function add(Cart $cart, $id)
    {
        //On passe dans la variable add le paramètre id pour pouvoir l'exploiter dans cette public function add en lui passant en paramètre.
		//Le controller ne connait la variable $cart que le viens de créer dans la Class Cart. On utilise donc le même mécanique d'injection de dépendance.
		//Des que tu vas entrer dans CartController et dans la fonction add je veux que tu embarques avec toi ma Class Cart que tu stock dans la variable $cart comme nouvel objet de la class.

        //La fonction add connait $cart grace à l'injection de dépendance.
        $cart->add($id);

        // On transforme le rendu en redirection vers app_cart.
        return $this->redirectToRoute('app_cart');

    }

    // Suppression de panier 
    #[Route('/cart/remove', name: 'remove_my_cart')]
    public function remove(Cart $cart)
    {
        //La fonction remove connait $cart grace à l'injection de dépendance 
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