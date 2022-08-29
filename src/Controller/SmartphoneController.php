<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Smartphone;
use App\Form\SearchSmartphoneType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SmartphoneController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/smartphones', name: 'app_smartphones')]
    public function index(Request $request): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchSmartphoneType::class, $search);

        $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
            $smartphones = $this->entityManager->getRepository(Smartphone::class)->findWithSearch($search);
        } else {
            $smartphones = $this->entityManager->getRepository(Smartphone::class)->findAll();
        }


        return $this->render('smartphone/index.html.twig', [
            'smartphones' => $smartphones,
            'form' => $form->createView()
        ]);
    }

    #[Route('/smartphones/{slug}', name: 'app_smartphone')]
    public function show($slug): Response
    {
        // dd($slug);
        // On recherche en base de donnée un produit associer à son slug.
        $smartphone = $this->entityManager->getRepository(Smartphone::class)->findOneBySlug($slug);

         // Partie sécurité
        if (!$smartphone){
            return $this->redirectToRoute('app_smartphones');
        }

        return $this->render('smartphone/show.html.twig', [
            'smartphone' => $smartphone
        ]);
    }
}
