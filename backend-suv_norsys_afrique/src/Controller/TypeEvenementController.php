<?php

namespace App\Controller;

use App\Entity\TypeEvenement;
use App\Repository\TypeEvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypeEvenementController extends AbstractController
{
    #[Route('/typeevenement/liste', name: 'type_evenement_liste', methods: ['GET'])]
    public function afficherTypeEvenement(TypeEvenementRepository $typeEvenementRepository)
    {
        $typeEvenement = $typeEvenementRepository->findAll();

        return $this->json($typeEvenement, 200);
    }

    #[Route('/typeevenement/afficher/{id}', name: 'type_evenement_afficher', methods: ['GET'])]
    public function afficherUnTypeEvenement($id, TypeEvenementRepository $typeEvenementRepository){
        $typeEvenement = $typeEvenementRepository->find($id);
        return $this->json($typeEvenement, 200);

    }

    #[Route('/typeevenement/ajouter', name: 'type_evenement_ajouter', methods: ['POST'])]
    public function ajouterTypeEvenement(Request $request, EntityManagerInterface $emi){
        $typeEvenement = new TypeEvenement();
        $data = json_decode($request->getContent(), true);

        $typeEvenement->setNom($data["nom"]);

        $emi->persist($typeEvenement);
        $emi->flush();

        return $this->json(["Message" => "Type Evenement Ajoute"], 200);

    }

    #[Route('/typeevenement/modifier/{id}', name: 'type_evenement_modifier', methods: ['PUT'])]
    public function modifierTypeEvenement($id, Request $request, TypeEvenementRepository $typeEvenementRepository, EntityManagerInterface $emi){
        $typeEvenement = $typeEvenementRepository->find($id);

        $data =json_decode($request->getContent(), true);
        $typeEvenement->setNom($data["nom"]);

        $emi->persist($typeEvenement);
        $emi->flush();

        return $this->json(["Message"=>"Type Evenement Modifier"],200);
    }

    #[Route('/typeevenement/supprimer/{id}', name: 'type_evenement_supprimer', methods: ['DELETE'])]
    public function supprimerTypeEvenement($id, TypeEvenementRepository $typeEvenementRepository, EntityManagerInterface $emi){
        $typeEvenement = $typeEvenementRepository->find($id);

        $emi->remove($typeEvenement);
        $emi->flush();

        return $this->json(["Message"=>"Type Evenement Supprimer"]);
    }

}
