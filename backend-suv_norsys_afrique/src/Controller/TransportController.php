<?php

namespace App\Controller;

use App\Entity\Transport;
use App\Repository\TransportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransportController extends AbstractController
{

    #[Route('/transport/liste', name: 'transport_liste', methods: ['GET'])]
    public function affichertransport(TransportRepository $transportRepository)
    {
        $transport = $transportRepository->findAll();

        return $this->json($transport, 200);
    }

    #[Route('/transport/afficher/{id}', name: 'transport_afficher', methods: ['GET'])]
    public function afficherUnTransport($id, TransportRepository $transportRepository){
        $transport = $transportRepository->find($id);
        return $this->json($transport, 200);

    }

    #[Route('/transport/ajouter', name: 'transport_ajouter', methods: ['POST'])]
    public function TransportAjouter(Request $request, EntityManagerInterface $emi){
        $transport = new Transport();
        $data = json_decode($request->getContent(),true);

        $transport->setNom($data["nom"]);

        $emi->persist($transport);
        $emi->flush();

        return $this->json(["Message"=>"transport Ajouter",200]);
    }

    #[Route('/transport/modifier/{id}', name: 'modifier-transport', methods: ['PUT'])]
    public function modifierTransport($id, Request $request, TransportRepository $TransportRepository, EntityManagerInterface $emi ){
        $transport = $TransportRepository->find($id);

        $data = json_decode($request->getContent(), true);
        $transport->setNom($data["nom"]);

        $emi->persist($transport);
        $emi->flush();

        return $this->json(["Message"=>"Transport Modifier"],200);

    }

    #[Route('/transport/supprimer/{id}', name: 'transport_supprimer', methods: ['DELETE'])]
    public function supprimerTransport($id, TransportRepository $transportRepository, EntityManagerInterface $emi){
        $transport = $transportRepository->find($id);

        $emi->remove($transport);
        $emi->flush();

        return $this->json(["Message"=>"Transport Supprimer"]);
    }
}
