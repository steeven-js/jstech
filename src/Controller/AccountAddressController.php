<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

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
    public function add(Request $request): Response
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

            return $this->redirectToRoute('app_account_address');
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
        // On va chercher l'objet adresse que l'on souhaite modifier
        $address = $this->entityManager->getRepository(Address::class)->findOneById($id);// De quel id on parle? De celui qui est passé en paramètre.

        // Secutité pour empecher que l'utilisateur ne modifie l'adresse d'une autre id avec l'url
        // Opérateur OU || voir si adresse et l'user lié 
        if (!$address || $address->getUser() != $this->getUser()) {
            return $this->redirectToRoute('app_account_address');
        }

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($address);
            // A quel utilisateur lié cette adresse?
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
