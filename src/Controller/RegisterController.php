<?php

namespace App\Controller;


use App\Classe\Cart;
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

    #[Route('/inscription', name: 'app_register')]
    public function index(Request $request, UserPasswordHasherInterface $encoder, Cart $cart)
    {
        $cart = $cart->get();

        $notification = null;

        $user = new User(); 
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request); // 1. ecoute de la request

        if ($form->isSubmitted() && $form->isValid()) { // if 2(ecoute) && 3(check EmailType etc...
            
            // dd($user); // 1.
            
            $user = $form->getData();

            $serch_email = $this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());

            if (!$serch_email) {
                $password = $encoder->hashPassword($user, $user->getPassword());

                $user->setPassword($password);

                // dd($password); // 2.
                // $doctrine = $this->getDoctrine()->getManager(); $doctrine est passé en parametre il pourra être utilisé plusieurs fois
                $this->entityManager->persist($user);
                $this->entityManager->flush();// 4.

                // $mail = new Mail();

                // $content = "Bonjour ".$user->getFirstname()."<br>Bienvenue sur jstech";

                // $mail->send($user->getEmail(), $user->getFirstname(), 'Bienvenue sur la Boutique Française', $content);

                $notification = "Votre inscripition c'est correctement déroulé. Vous pouvez dès à présent vous connecter à votre compte";

            }else {

                $notification = "L'email que vous avez renseigné existe déjà.";
                
            }

            // dd($user);
            
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification,
            'cart' => $cart
        ]);
    }
}
