<?php

namespace App\Controller;

use App\Entity\ClientVisiteur;
use App\Repository\ClientVisiteurRepository;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientVisiteurController extends AbstractController
{

    #[Route('/clientvisiteur/liste', name: 'client_visiteur_liste', methods: ['GET'])]
    public function afficherClientVisiteur(ClientVisiteurRepository $clientVisiteurRepository)
    {
        $clientvisiteur = $clientVisiteurRepository->findAll();
        return $this->json($clientvisiteur, 200);
    }

    #[Route('/clientvisiteur/afficher/{id}', name: 'client_visiteur_afficher', methods: ['GET'])]
    public function afficherClientVisiteurr($id, ClientVisiteurRepository $clientVisiteurRepository){
        $clientvisiteur = $clientVisiteurRepository->find($id);
        return $this->json($clientvisiteur, 200);
    }

    #[Route('/clientvisiteur/ajouter', name: 'client_visiteur_ajouter', methods: ['POST'])]
    public function ajouterClientVisiteur(Request $request, EntityManagerInterface $emi, EvenementRepository $evenementRepository){
        $clientvisiteur = new ClientVisiteur();
        $data = json_decode($request->getContent(), true);
        $evenement = $evenementRepository->findBy(['id' => $data['evenement']]);
        $clientvisiteur->setNom($data["nom"]);
        $clientvisiteur->setPrenom($data["prenom"]);
        $clientvisiteur->setEvenement($evenement[0]);
        $emi->persist($clientvisiteur);
        $emi->flush();
        return $this->json(["Message" => " Client Visiteur( Ajoute"], 200);
    }

    #[Route('/clientvisiteur/modifier/{id}', name: 'client_visiteur_modifier', methods: ['PUT'])]
    public function modifierClientVisiteur($id, Request $request, ClientVisiteurRepository $clientVisiteurRepository, EntityManagerInterface $emi, EvenementRepository $evenementRepository){
        $clientvisiteur = $clientVisiteurRepository->find($id);
        $data =json_decode($request->getContent(), true);
        $evenement = $evenementRepository->findBy(['id' => $data['Evenement']]);
        $clientvisiteur->setNom($data["nom"]);
        $clientvisiteur->setPrenom($data["prenom"]);
        $clientvisiteur->setEvenement($evenement[0]);
        $emi->persist($clientvisiteur);
        $emi->flush();
        return $this->json(["Message"=>"Client Visiteur Modifier"],200);
    }

    #[Route('/clientvisiteur/supprimer/{id}', name: 'client_visiteur_supprimer', methods: ['DELETE'])]
    public function supprimerClientVisiteur($id, ClientVisiteurRepository $clientVisiteurRepository, EntityManagerInterface $emi){
        $clientvisiteur = $clientVisiteurRepository->find($id);
        $emi->remove($clientvisiteur);
        $emi->flush();
        return $this->json(["Message"=>"Client Visiteur Supprimer"]);
    }

}
