<?php

namespace App\Controller;

use App\Entity\TAF;
use App\Repository\FinalResultRepository;
use App\Repository\PACRepository;
use App\Repository\TAFRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TAFController extends AbstractController
{
    #[Route('/taf/ajouter', name: 'app_taf_ajouter', methods:['POST'])]
    public function ajouter(Request $request, EntityManagerInterface $entityManagerInterface, PACRepository $PACRepository, UtilisateurRepository $utilisateurRepository)
    {
        $data = json_decode($request->getContent(),true);
        $taf = new TAF();
        $pacs = $PACRepository->findBy(['id' => $data['pac']]);
        $taf->setPac($pacs[0]);
        $entityManagerInterface->persist($taf);
        $entityManagerInterface->flush();
        return $this->json(["Message" => "Ajouter avec succés"], 200);
    }

    #[Route('/taf/liste', name: 'app_taf_affiche', methods: ['GET'])]
    public function afficherTAF(TAFRepository $TAFRepository)
    {
        $tafs = $TAFRepository->findAll();
        return $this->json($tafs,Response::HTTP_OK, [], ['groups' => ['pac', 'user', 'taf']]);
    }

    #[Route('/taf', name: 'app_taf')]
    public function afficher(FinalResultRepository $finalResultRepository)
    {
        $result = $finalResultRepository->findActivite();
        return $this->json($result, Response::HTTP_OK);
    }
}
