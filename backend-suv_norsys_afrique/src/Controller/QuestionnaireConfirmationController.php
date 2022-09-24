<?php

namespace App\Controller;

use App\Entity\QuestionnaireActivites;
use App\Entity\QuestionnaireConfirmation;
use App\Repository\PACRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class QuestionnaireConfirmationController extends AbstractController
{
    #[Route('/questionnaire/pac/liste', name: 'app_questionnaire', methods: ['POST'])]
    public function ajouter(Request $request, EntityManagerInterface $entityManager, PACRepository $PACRepository)
    {
        $data = json_decode($request->getContent(), true);
        $pacliste = $PACRepository->findAll();
        $nbPacs = count($pacliste);
        $questionnaireConfirmation = new QuestionnaireConfirmation();
        for($i=0; $i<$nbPacs; $i++){
            $questionnaireConfirmation->addPac($pacliste[$i]);
        }
        $questionnaireConfirmation->setTitre($data['titre']);
        $entityManager->persist($questionnaireConfirmation);
        $entityManager->flush();

        return new JsonResponse(["message" => "Questionnaire de confirmation ajouté avec success !"]);
    }

    #envoyer le questionnaire
    #[Route('/envoyerQuestionnaire', name: 'email_questionnaire_PAC')]
    public function sendEmail(Request $request,MailerInterface $mailer, UtilisateurRepository $utilisateurRepository): JsonResponse
    {
        $utilisateurs = $utilisateurRepository->findAll();
        foreach ($utilisateurs as $utilisateur){
            $toAddresses[] = [$utilisateur->getEmail()];
        }
        $email = (new Email());
        foreach ($toAddresses as $adresse){
            $email->from("no-reply@suvnaf.ma");
            $email->to($adresse[0]);
            $email->subject('Questionnaire de Confirmation');
            $email->html("Bonjour,<br> Merci de répondre à ce <a href='http://localhost:8080/listeQuestionnaire'>questionnaire de confirmation</a> pour confirmer votre participation aux activités voulu");
            $mailer->send($email);
        }
        return new JsonResponse(['message' => 'Questionnaire envoyer avec succès'], Response::HTTP_OK);
    }
}
