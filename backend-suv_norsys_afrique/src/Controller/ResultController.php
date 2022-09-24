<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Repository\ResultRepository;
use App\Entity\Result;
use App\Repository\ActiviteRepository;
use App\Repository\QuestionnaireActivitesRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ResultController extends AbstractController
{
    #[Route('/result', name: 'app_result_all', methods: ['GET'])]
    public function result(ResultRepository $resultRepository)
    {
        $resultat = $resultRepository->findAll();
        return $this->json($resultat, Response::HTTP_OK);
    }

    #[Route('/questionnairelist', name: 'app_questionnaire_all', methods: ['GET'])]
    public function Questionnaire(QuestionnaireActivitesRepository $questionnaireActivitesRepository)
    {
        $questionnaire = $questionnaireActivitesRepository->findAll();
        return $this->json($questionnaire, Response::HTTP_OK);
    }

    #[Route('/myresult', name: 'app_result', methods: ['GET'])]
    public function myResult(ResultRepository $resultRepository)
    {
        $resultat = $resultRepository->findBy(["utilisateur" => $this->getUser()]);
        return $this->json($resultat, Response::HTTP_OK);
    }

    #[Route('/result/ajouter', name: 'vote_ajouter', methods: ['POST'])]
    public function ajouter(Request $request, EntityManagerInterface $entityManagerInterface, UtilisateurRepository $utilisateurRepository, ActiviteRepository $activiteRepository, QuestionnaireActivitesRepository $questionnaireActivitesRepository){
        $data = json_decode($request->getContent(), true);
        $result = new Result();
        $activite = $activiteRepository->findBy(['id' => $data['activite']]);
        $utilisateur = $utilisateurRepository->findBy(['email' => $data['utilisateur']]);
        $result->setUtilisateur($utilisateur[0]);
        $result->setVote($data['vote']);
        $result->setActivite($activite[0]);
        $entityManagerInterface->persist($result);
        $entityManagerInterface->flush();
        return $this->json(["Message"=>"Vote Ajouter"],200);
    }

}
