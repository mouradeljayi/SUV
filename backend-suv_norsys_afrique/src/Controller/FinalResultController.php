<?php

namespace App\Controller;

use App\Entity\FinalResult;
use App\Repository\FinalResultRepository;
use App\Repository\PACRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FinalResultController extends AbstractController
{

    #[Route('/finalresult/ajouter', name: 'vote_finalresult_ajouter', methods: ['POST'])]
    public function ajouter(Request $request, EntityManagerInterface $entityManagerInterface, UtilisateurRepository $utilisateurRepository, PACRepository $PACRepository){
        $data = json_decode($request->getContent(), true);
        $finalresult = new FinalResult();
        $pac = $PACRepository->findBy(['id' => $data['pac']]);
        $utilisateur = $utilisateurRepository->findBy(['email' => $data['utilisateur']]);
        $finalresult->setUtilisateur($utilisateur[0]);
        $finalresult->setPac($pac[0]);
        $finalresult->setVote($data['vote']);
        $entityManagerInterface->persist($finalresult);
        $entityManagerInterface->flush();
        return $this->json(["Message"=>"Vote de confirmation ajouté"],200);
    }

    #[Route('/finalresults', name: 'final_result_all', methods: ['GET'])]
    public function finalResult(FinalResultRepository $finalResultRepository)
    {
        $resultat = $finalResultRepository->findAll();
        return $this->json($resultat, Response::HTTP_OK, [], ['groups' => ['finalresult', 'pac', 'user']]);
    }
}
