<?php

namespace App\Controller;

use ApiPlatform\Core\Filter\Validator\Length;
use App\Entity\Activite;
use App\Entity\Utilisateur;
use App\Entity\Questionnaire;
use App\Entity\QuestionnaireActivites;
use App\Repository\ActiviteRepository;
use App\Repository\QuestionnaireActivitesRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Doctrine\ORM\EntityManagerInterface;

class QuestionnaireActiviteController extends AbstractController
{

    #[Route('/questionnaire/activite', name: 'app_questionnaire_activite', methods: ['GET'])]
    public function index(ActiviteRepository $activiteRepository): JsonResponse
    {
        $activites = $activiteRepository->findBy(["archive" => false]);
        return $this->json($activites, Response::HTTP_OK,[],['groups' => 'activites:read']);
    }

    #[Route('/titre/questionnaire', name: 'app_questionnaire_activite', methods: ['GET'])]
    public function titre(QuestionnaireActivitesRepository $questionnaireActivitesRepository): JsonResponse
    {
        $titre = $questionnaireActivitesRepository->findAll();
        return $this->json($titre, Response::HTTP_OK);
    }

    #[Route('/questionnaire/activite/ajouter', name: 'app_questionnaire_cree')]
    public function ajouter(Request $request, EntityManagerInterface $entityManager, ActiviteRepository $activiteRepository)
    {
        $data = json_decode($request->getContent(), true); 
        $activiteslist = $activiteRepository->findBy(["archive" => false]);
        $nbActivite = count($activiteslist);
        $questionnaireActivite = new QuestionnaireActivites();
        for($i=0; $i<$nbActivite; $i++){
            $questionnaireActivite->addActivite($activiteslist[$i]);
        }
        $questionnaireActivite->setTitre($data['titre']);    
        $entityManager->persist($questionnaireActivite);
        $entityManager->flush();
        return new JsonResponse(['message' => 'Questionnaire ajoutée avec succès'], Response::HTTP_CREATED);
    }

    #[Route('/email', name: 'email_questionnaire_activite')]
    public function sendEmail(Request $request,MailerInterface $mailer, UtilisateurRepository $utilisateurRepository): JsonResponse
    {
        $utilisateurs = $utilisateurRepository->findAll();
        foreach ($utilisateurs as $utilisateur){
            $toAddresses[] = [$utilisateur->getEmail()];
        }
        $email = (new Email());
        foreach ($toAddresses as $adresse){
            $email->from("no-reply@suvnaf.fr");
            $email->to($adresse[0]);
            $email->subject('Questionnaire de sondage');
            $email->html("<p>Bonjour,</p><br>
                                <p>Merci de répondu à ce <a href='http://localhost:8080/Questionnaire'>Questionnaire</a> pour choisir les activites voulu</p><br>
                                <p>Cordialement.</p>");
            $mailer->send($email);
        }
        return new JsonResponse(['message' => 'Questionnaire envoyer avec succès'], Response::HTTP_OK);   
    }
}
