<?php

namespace App\Controller;

use App\Form\UserContactFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class UserContactController extends AbstractController
{
    #[Route('/user_contact', name: 'app_user_contact')]
    public function index(
        Request $request,
        EntityManagerInterface $manager,
        MailerInterface $mailer
    ): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserContactFormType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            $manager->persist($contact);
            $manager->flush();

            //Email
            $email = (new TemplatedEmail())
                ->from($contact->getEmail())
                ->to('admin@jstech.com')
                ->subject($contact->getSubject())
                // path of the Twig template to render
                ->htmlTemplate('emails/contact.html.twig')

                // pass variables (name => value) to the template
                ->context([
                'contact' => $contact
                ]);

            $mailer->send($email);

            $this->addFlash(
                'success',
                'Votre Email a été envoyé avec succès !'
            );

            return $this->redirectToRoute('app_user_contact');
        }

        return $this->render('user_contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
