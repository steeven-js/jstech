<?php

namespace App\Classe;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
//use Symfony\Component\HttpFoundation\Session\SessionInterface;


class Cart 

{
	//private $session;
	private $requestStack;
	private $entityManager;

	//public function __construct(SessionInterface $session)
	public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack)
	{
	//$this->session = $session;
	$this->requestStack = $requestStack;
	$this->entityManager = $entityManager;
	}


	public function add($id)
	{
		// On récupère les informations du panier à l'aide de la session
		$cart = $this->requestStack->getSession()->get('cart', []);

		// Si dans le panier il y a un produit déjà inséré
		if (!empty($cart[$id])) {
			// On incrémente
        	$cart[$id]++; 
		} else {
			$cart[$id] = 1;
		}
		// Il s'agit du set de la biblihothèque SessionInterface (Sets an attribute.)
		// On stock les informations du panier dans une session (cart)
		$this->requestStack->getSession()->set('cart',$cart); 
	}

	// AFFICHE le panier
	public function get()
	{
		// Il s'agit du get de la biblihothèque SessionInterface (Returns an attribute.)
		return $this->requestStack->getSession()->get('cart');
	}

	// SUPPRIME le panier
	public function remove()
	{
		// Il s'agit du remove de la biblihothèque SessionInterface (Removes an attribute.)
		return $this->requestStack->getSession()->remove('cart');
	}

	// SUPPRIME le produit du panier sans supprimer le reste du panier
	public function delete($id)
	{

		$cart = $this->requestStack->getSession()->get('cart', []);

		// Je retire du tableau l'entré cart qui à l'id qui correspond à l' id que je souhaite supprimer
		unset($cart[$id]);

		// Je redéfini la même route que mon panier
		$this->requestStack->getSession()->set('cart',$cart); 
	}

	// REDUIRE
	public function decrease($id)
	{
		// On récupère les informations du panier à l'aide de la session
		$cart = $this->requestStack->getSession()->get('cart', []);

		// Vrérifier si la quantité de notre produit = 1
		if ($cart[$id] > 1) {
			// Retirer une quantité (-1)
			$cart[$id]--; 
			
		} else {
			// Supprimer mon produit
			unset($cart[$id]);
		}
		
		// Je redéfini la même route que mon panier
		$this->requestStack->getSession()->set('cart',$cart); 
	}

	public function getFull() 
	{
		$cartComplete = [];

        // Si il y a un ajout, je rente dans le tableau
        if ($this->get()) {
            // je définis get dans l'entité Cart
            foreach ($this->get() as $id => $quantity){
                $cartComplete[] = [
                    'product' => $this->entityManager->getRepository(Product::class)->findOneById($id),
                    'quantity' => $quantity
                ];
            }

        }
		return $cartComplete;
	}

}
