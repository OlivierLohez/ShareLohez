<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Entity\Contact;
use App\Entity\User;

class BaseController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(): Response
    {
        return $this->render('base/index.html.twig', [
            
        ]);
    }
    #[Route('/contact', name: 'contact')]
        public function contact(Request $request, MailerInterface $mailer): Response
        {
            $contact = new Contact();
            $form = $this->createForm(ContactType::class, $contact);

            if($request->isMethod('POST')){
                $form->handleRequest($request);
                if ($form->isSubmitted()&&$form->isValid()){   
                    $email = (new TemplatedEmail())
                    ->from($form->get('email')->getData())
                    ->to('olivier.lohezz@gmail.com')
                    ->subject($contact->getSujet())
                    ->htmlTemplate('emails/email.html.twig')
                    ->context([
                        'nom'=> $contact->getNom(),
                        'sujet'=> $contact->getSujet(),
                        'message'=> $contact->getMessage()
                    ]); 
                    $contact->setDateEnvoi(new \Datetime());
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($contact);
                    $em->flush();
                  
                    $mailer->send($email);
                    $this->addFlash('notice','Message envoyé');
                    return $this->redirectToRoute('contact');
                }
            }
            return $this->render('base/contact.html.twig', [
                'form' => $form->createView()
            ]);
        }
    


    #[Route('/mentions', name: 'mentions')]
    public function mentions(): Response
    {
        return $this->render('base/mentions.html.twig', [
            
        ]);
    }
    #[Route('/propos', name: 'propos')]
    public function propos(): Response
    {
        return $this->render('base/propos.html.twig', [
            
        ]);
    }

    #[Route('/liste-utilisateurs', name:'liste-utilsateurs')]
    public function listeutilisateurs(): Response
    {  
        $repoUtilisateurs = $this->getDoctrine()->getRepository(User::class);
        $user = $repoUtilisateurs->findAll();
        return $this->render('base/liste-utilisateurs.html.twig',[
            'user' => $user
        ]);
    }
}
    