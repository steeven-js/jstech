<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\RequestStack;
//use Symfony\Component\HttpFoundation\Session\SessionInterface;


class Cart 

{
	//private $session;
	private $requestStack;

	//public function __construct(SessionInterface $session)
	public function __construct(RequestStack $requestStack)
	{
	//$this->session = $session;
	$this->requestStack = $requestStack;
	}


	public function add($id)
	{
		$cart = $this->requestStack->getSession()->get('cart', []);

		if (!empty($cart[$id])) {
        	$cart[$id]++; 
		} else {
			$cart[$id] = 1;
		}
		// Il s'agit du set de la biblihothèque SessionInterface (Sets an attribute.)
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

}
