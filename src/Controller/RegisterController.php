<?php
/**
 * Commentaires
 */


namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    // 1. Dès que ce formulaire est saisi (ecoute submit)
    // 2. Traiter les informations
    // 3. Les valider ou pas...
    // 4. Si tout est ok => enregister en DB

    #[Route('/inscription', name: 'app_register')]
    public function index(Request $request, UserPasswordHasherInterface $encoder)
    {
        $user = new User(); 
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request); // 1. ecoute de la request

        if ($form->isSubmitted() && $form->isValid()) { // if 2(ecoute) && 3(check EmailType etc...

            $user = $form->getData();
            // dd($user); // 1.

            $password = $encoder->hashPassword($user, $user->getPassword());
            $user->setPassword($password);

            // dd($password); // 2.
            // $doctrine = $this->getDoctrine()->getManager(); $doctrine est passé en parametre il pourra être utilisé plusieurs fois
            $this->entityManager->persist($user);
            $this->entityManager->flush();// 4.

            // dd($user);
            return $this->redirectToRoute('app_login');

        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
