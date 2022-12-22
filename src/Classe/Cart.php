<?php

namespace App\Classe;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
//use Symfony\Component\HttpFoundation\Session\SessionInterface;


class Cart 
	//Création de la sessionInterface
    //Création de la fonction qui va me permettre d'ajouter un produit à mon panier 
	//Pour cela on crée une varible private $session
{
	//private $session;
	private $requestStack;
	// Cette variable j'ai besoin de la contruire
	private $entityManager;
	// Cette variable j'ai besoin de la contruire

	//public function __construct(SessionInterface $session)
	public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack)
	//Des que ma class va être appelé la fonction __constructeur va s'initialiser.
	//J'ai besoin de lui injecter la SessionInterface et de lui donner la variable $session
	{

	//Pour que ce soit accessible au sein de la class on fait donc:
	$this->requestStack = $requestStack;
	$this->entityManager = $entityManager;
	}

	// AJOUTER
	public function add($id)
	{
		//Je veux que tu me set une session qui va s'appeler $cart et je veux que tu lui associe un tableau
		//Dans ce tableau je veux tous les produits de mon panier qui ont un couple id/qté

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
		// On stock les informations du panier dans une variable $cart de la session 'cart'
		$this->requestStack->getSession()->set('cart',$cart); 
	}

	// AFFICHE le panier
	public function get()
	{
		// Il s'agit du get de la biblihothèque SessionInterface (Returns an attribute.)
		// La session appelé va donc s'appellé 'cart'
		return $this->requestStack->getSession()->get('cart');
	}

	// SUPPRIME le panier
	public function remove()
	{
		// Il s'agit du remove de la biblihothèque SessionInterface (Removes an attribute.)
		// La session appelé 'cart' va donc être supprimé.
		return $this->requestStack->getSession()->remove('cart');
	}

	// SUPPRIME le produit du panier sans supprimer le reste du panier
	public function delete($id)
	{

		$cart = $this->requestStack->getSession()->get('cart', []);

		// Je retire du tableau l'entré cart qui à l'id qui correspond à l' id que je souhaite supprimer
		unset($cart[$id]);

		// Je redéfini la même route que mon panier avec les nouvelle informations.
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
            // Je récupère l'ID du produit en base de données
            foreach ($this->get() as $id => $quantity){
                $cartComplete[] = [
                    'product' => $this->entityManager->getRepository(Product::class)->findOneById($id),
                    'quantity' => $quantity
                ];
            }

			// dd($cartComplete);

        }
		return $cartComplete;

		// Sinon je retrouve le template mon panier vide
	}

}
