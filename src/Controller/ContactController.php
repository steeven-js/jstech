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
            $gerant = "JSTech";             
            $admin = "kisama972@gmail.com";              
            
            $content = "Bonjour " . $gerant . ",<br/><br/>Vous avez reçu une nouvelle demande de contact:<br/>" . $form->get('prenom')->getData() . " " . $form->get('nom')->getData() . "<br/>" . $form->get('email')->getData() . "<br/>" .                 
            "Message : " . $form->get('content')->getData() . "<br/>"; 

            // dd($form->getData());

            $mail->send($admin, $gerant, 'Nouvelle demande de contact', $content);
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
