<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    #[Route('/mailer', name: 'app_mailer')]
    public function index(): Response
    {
        return $this->render('mailer/index.html.twig', [
            'controller_name' => 'MailerController',
        ]);
    }

    #[Route('/sendemail', name: "email")]
    public function sendEmail(MailerInterface $mailer, Request $request): Response
    {
        $tos = $request->get("to");

        $from = "no-reply@suvnaf.ma";
        $subject = "Demande de participation à l'organisation d'une événement";
        $email = (new Email());
            foreach ($tos as $to){
            $email->from($from)
            ->to($to)
            ->subject($subject)
            ->html('<p>Bonjour,</p><br>
                          <p>Nous aimerions vous inviter à participer à l organisation d un événement.</p>
                          <p>Merci de confimer votre participation par mail.</p>
                          <p>Cordialement.</p>');

        $mailer->send($email);
        }

        return new Response('email was sent !');
    }
}
