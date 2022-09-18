<?php
/**
 * Commentaires
 */


namespace App\Controller;

use App\Classe\Mail;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request): Response {

        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('notice', 'Merci de nous avoir contacté. Notre équipe va nous répondre dans les meilleur délais');

            $mail = new Mail();

            $content = "Bonjour </br>Vous avez reçus un message de <strong>".$form->getData()['prenom']." ".$form->getData()['nom']."</strong></br>Adresse email : <strong>".$form->getData()['email']."</strong> </br>Message : ".$form->getData()['content']."</br></br>";             
         
            $mail->send('kisama972@gmail.com', 'JSTech', 'Vous avez reçus une nouvelle demande de contact', $content); 

            // dd($form->getData());
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
