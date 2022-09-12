<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Address;


use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountAddressController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('/compte/adresses', name: 'app_account_address')]
    public function index(): Response
    {
        // dd($this->getUser());
        return $this->render('account/address.html.twig');
    }
    
    // AJOUTER une adresse
    #[Route('/compte/ajouter-une-adresse', name: 'app_account_address_add')]
    public function add(Request $request, Cart $cart): Response
    {
        $address = new Address();

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($address);
            // A quel utilisateur lié cette adresse?
            $address->setUser($this->getUser());

            $this->entityManager->persist($address);
            $this->entityManager->flush();

            if ($cart->get()) {
                return $this->redirectToRoute('app_account_address');
            }else {
                return $this->redirectToRoute('app_account_address');
            }
        }

        // dd($this->getUser());
        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    // MODIFIER une adresse
    #[Route('/compte/modifier-une-adresse/{id}', name: 'app_account_address_edit')]
    public function edit(Request $request, $id): Response
    {
        // Je récupère l'adresse concernée à l'aide de doctrine en base de donnée
        $address = $this->entityManager->getRepository(Address::class)->findOneById($id);// De quel id on parle? De celui qui est passé en paramètre.

        // SECURITE
        // S'il n'y a aucune adresse, ou que l'utilisateur qui à renseinger l'adressse ne correspond pas à celui actuellement connecté.
        if (!$address || $address->getUser() != $this->getUser()) {
            return $this->redirectToRoute('app_account_address');
        }

        // Je passe en paramètres à ma fonction creatForm() Le type du formulaire et L'objet
        $form = $this->createForm(AddressType::class, $address);

        // Ecoute la requête
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($address);
            // A quel utilisateur lié cette adresse?
            // Fige la data
            $this->entityManager->flush();

            return $this->redirectToRoute('app_account_address');
        }

        // dd($this->getUser());
        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    // SUPPRIMER une adresse
    #[Route('/compte/supprimer-une-adresse/{id}', name: 'app_account_address_delete')]
      public function delete($id): Response
    {
        $address = $this->entityManager->getRepository(Address::class)->findOneById($id);

        if ($address && $address->getUser() === $this->getUser()){// REdirection si : l'adresse n'existe pas OU {sécurité} si l'user n'est pas le meme que l'user courrant (barre d'adresse, on peut taper n'importe quel id...) 
            $this->entityManager->remove($address);
			$this->entityManager->flush();
        }
        return $this->redirectToRoute('app_account_address');
    }
}
