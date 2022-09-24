<?php

namespace App\Controller;

use App\Entity\PAC;
use App\Repository\ActiviteRepository;
use App\Repository\PACRepository;
use App\Repository\ResultRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PacController extends AbstractController
{
    #[Route('/pac', name: 'app_pac')]
    public function afficher(ResultRepository $resultRepository)
    {
        $result = $resultRepository->findActiviteByVote();
        return $this->json($result, Response::HTTP_OK);
    }

    #[Route('/pac/liste', name: 'app_pac_affiche', methods: ['GET'])]
    public function afficherPAC(PACRepository $pacRepository)
    {
        $pac = $pacRepository->findAll();
        return $this->json($pac,Response::HTTP_OK, [], ['groups' => ['pac', 'user']]);
    }

    #[Route('/pac/ajouter', name: 'app_pac_ajouter', methods:['POST'])]
    public function ajouter(Request $request, EntityManagerInterface $entityManagerInterface, UtilisateurRepository $utilisateurRepository, ActiviteRepository $activiteRepository)
    {
        $data = json_decode($request->getContent(),true);
        $pac = new PAC();
        $activite = $activiteRepository->findBy(['id' => $data['activite']]);
        $pac->setActivite($activite[0]);
        $entityManagerInterface->persist($pac);
        $entityManagerInterface->flush();
        return $this->json(["Message" => "Ajouter avec succés"], 200);
    }
}