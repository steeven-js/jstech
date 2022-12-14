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

    // 1. Dès que ce formulaire est saisi (ecoute submit)
    // 2. Traiter les informations
    // 3. Les valider ou pas...
    // 4. Si tout est ok => enregister en DB

    #[Route('/compte/adresses', name: 'app_account_address')]
    public function index(Cart $cart): Response
    {
        // dd($this->getUser());
        
        return $this->render('account/address.html.twig', [
            'count' => $cart->count()
        ]);
    }
    
    // AJOUTER une adresse
    #[Route('/compte/ajouter-une-adresse', name: 'app_account_address_add')]
    public function add(Request $request, Cart $cart): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        
        $address = new Address();

        $form = $this->createForm(AddressType::class, $address); // j'importe le formulaire

        $form->handleRequest($request); // 1. ecoute de la request du formulaire dans ce cas

        if ($form->isSubmitted() && $form->isValid()) {  // if 2(ecoute) && 3(check EmailType etc...

            // dd($address); // 1.

            // A quel utilisateur lié cette adresse?
            $address->setUser($this->getUser()); // L'addresse sera lié à l'id de l'utilisateur.

            $this->entityManager->persist($address);
            $this->entityManager->flush(); // 4

            if ($cart->get()) {
                return $this->redirectToRoute('app_order');
            }else {
                return $this->redirectToRoute('app_account_address');
            }
        }

        // dd($this->getUser());

        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView(),
            'count' => $cart->count()
        ]);
    }

    // MODIFIER une adresse
    #[Route('/compte/modifier-une-adresse/{id}', name: 'app_account_address_edit')]
    public function edit(Request $request, $id, Cart $cart): Response
    {
        // Je récupère l'adresse concernée à l'aide de doctrine en base de donnée
        $address = $this->entityManager->getRepository(Address::class)->findOneById($id);// De quel id on parle? De celui qui est passé en paramètre.

        // SECURITE
        // S'il n'y a aucune adresse, ou que l'utilisateur qui à renseinger l'adressse ne correspond pas à celui actuellement connecté.
        if (!$address || $address->getUser() != $this->getUser()) {
            return $this->redirectToRoute('app_account_address');
        }

        // dd($address);

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

        // dd($form);

        // dd($this->getUser());

        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView(),
            'count' => $cart->count()
        ]);
    }

    // SUPPRIMER une adresse
    #[Route('/compte/supprimer-une-adresse/{id}', name: 'app_account_address_delete')]
    public function delete($id, Cart $cart): Response
    {

        $address = $this->entityManager->getRepository(Address::class)->findOneById($id);

        if ($address && $address->getUser() === $this->getUser()){// REdirection si : l'adresse n'existe pas OU {sécurité} si l'user n'est pas le meme que l'user courrant (barre d'adresse, on peut taper n'importe quel id...) 
            $this->entityManager->remove($address);
			$this->entityManager->flush();
        }

        return $this->redirectToRoute('app_account_address', [
            'count' => $cart->count()
        ]);
    }
}
