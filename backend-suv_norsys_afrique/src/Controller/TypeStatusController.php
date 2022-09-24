<?php

namespace App\Controller;

use App\Entity\StatusEvenement;
use App\Repository\StatusEvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypeStatusController extends AbstractController
{
    #[Route('/type/status', name: 'app_type_status', methods:['GET'])]
    public function afficherTypeStatus(StatusEvenementRepository $statusEvenementRepository){
        $typestatus = $statusEvenementRepository->findBy(["archive" => false]);
        return $this->json($typestatus, 200);
    }

    #[Route('/type/status/{id}', name:'app_un_type_status', methods:['GET'])]
    public function afficherUnTypeStatus($id, StatusEvenementRepository $statusEvenementRepository){
        $typestatus = $statusEvenementRepository->find($id);
        return $this->json($typestatus,200);
    }

    #[Route('/type/status/ajouter', name:'Ajouter_Type_Status', methods:['POST'])]
    public function AjouterStatus(Request $request, EntityManagerInterface $entityManager){
        $data = json_decode($request->getContent(),true);
        $statusEvenement = new StatusEvenement();
        $statusEvenement->setNom($data['nom']);
        $statusEvenement->setArchive(false);
        $entityManager->persist($statusEvenement);
        $entityManager->flush();
        return $this->json(["Message" => "Type status ajoutée"], 200);
    }

    #[Route('/type/status/modifier/{id}', name: 'Modifier_status', methods: ['PUT'])]
    public function ModifierStatus(Request $request, $id, EntityManagerInterface $entityManager, StatusEvenementRepository $statusEvenementRepository){
        $data = json_decode($request->getContent(), true);
        $statusEvenement = $statusEvenementRepository->find($id);
        $statusEvenement->setNom($data['nom']);
        $statusEvenement->setArchive(false);
        $entityManager->persist($statusEvenement);
        $entityManager->flush();
        return $this->json(["Message" => "Status Evenement Modifiée"], 200);
    }

    #[Route('/type/status/archiver/{id}', name: 'Archiver status', methods: ['PUT'])]
    public function ArchiverStatus($id, EntityManagerInterface $entityManager, StatusEvenementRepository $statusEvenementRepository){
        $statusEvenement = $statusEvenementRepository->find($id);
        $statusEvenement->setArchive(true);
        $entityManager->persist($statusEvenement);
        $entityManager->flush();
        return $this->json(["Message" => "Archivée avec succès"], 200);
    }

    #[Route('/type/status/supprimer/{id}', name:'Supprimer status', methods:['DELETE'])]
    public function SupprimerStaus($id, StatusEvenementRepository $statusEvenementRepository, EntityManagerInterface $entityManager){
        $statusEvenement = $statusEvenementRepository->find($id);
        if($statusEvenement->getArchive()){
            $entityManager->remove($statusEvenement);
            $entityManager->flush();
        }
        else{
            return $this->json(["Message" => "Status non archivée"], 400);
        }
        return $this->json(["Message" => "Status supprimée"], 200);
    }
}
