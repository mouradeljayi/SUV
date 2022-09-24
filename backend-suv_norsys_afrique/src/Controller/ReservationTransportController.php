<?php

namespace App\Controller;

use App\Entity\ReservationTransport;

use App\Repository\EvenementRepository;
use App\Repository\ReservationTransportRepository;
use App\Repository\TransportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;

class ReservationTransportController extends AbstractController
{
    #[Route('/reservationtransports/ajouter', name: 'reservationtransports.create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManagerInterface, EvenementRepository $evenementRepository, TransportRepository $transportRepository){
        $data = json_decode($request->getContent(),true);
        $reservationtransports = new ReservationTransport();
        $transport = $transportRepository->findBy(['id' => $data['transport']]);
        $evenement = $evenementRepository->findBy(['id' => $data['evenement']]);
        $reservationtransports->setTransport($transport[0]);
        $reservationtransports->setEvenement($evenement[0]);
        $reservationtransports->setDate(new \DateTime($data['date']));
        $reservationtransports->setLieuDepart($data["lieuDepart"]);
        $reservationtransports->setDestination($data["destination"]);
        $reservationtransports->setNombrePax($data["nombrePax"]);

        $entityManagerInterface->persist($reservationtransports);
        $entityManagerInterface->flush();
        return $this->json(["Message" => "Réservation  avec succés"], 200);
    }

    #[Route('/reservationtransports', name: 'reservationtransports.list', methods: ['GET'])]
    public function reservationtransports(ReservationTransportRepository $reservationTransportRepository): JsonResponse
    {
        $reservationtransports = $reservationTransportRepository->findAll();
        return $this->json($reservationtransports, 201);
    }
    #[Route('/reservationtransports/{id}', name: 'reservationtransports.find', methods: ['GET'])]
    public function find(ReservationTransportRepository $reservationTransportRepository, $id): JsonResponse
    {
        $reservationtransports = $reservationTransportRepository->find($id);
        return $this->json($reservationtransports, 201);
    }

    #[Route('/reservationtransports/edit/{id}', name: 'reservationtransports.update', methods: ['PUT'])]
    public function editReservationTransports($id, Request $request, EntityManagerInterface $entityManagerInterface, ReservationTransportRepository $reservationTransportRepository, EvenementRepository $evenementRepository, TransportRepository $transportRepository){
        $data = json_decode($request->getContent(), true);
        $reservationtransports = $reservationTransportRepository->find($id);
        $transport = $transportRepository->findBy(['id' => $data['transport']]);
        $evenement = $evenementRepository->findBy(['id' => $data['evenement']]);
        $reservationtransports->setTransport($transport[0]);
        $reservationtransports->setEvenement($evenement[0]);
        $reservationtransports->setDate(new \DateTime($data['date']));
        $reservationtransports->setLieuDepart($data["lieuDepart"]);
        $reservationtransports->setDestination($data["destination"]);
        $reservationtransports->setNombrePax($data["nombrePax"]);
        $entityManagerInterface->persist($reservationtransports);
        $entityManagerInterface->flush();
        return $this->json(["Message" => "Réservation modifier  avec succés"], 200);
    }

    #[Route('/reservationtransports/delete/{id}', name: 'reservationtransports.delete', methods: ['DELETE'])]
    public function deleteReservationTransports($id, ReservationTransportRepository $reservationTransportRepository, EntityManagerInterface $emi){
        $reservationtransports = $reservationTransportRepository->find($id);

        $emi->remove($reservationtransports);
        $emi->flush();

        return $this->json(["Message"=>"reservation transports Supprimer"]);
    }
}