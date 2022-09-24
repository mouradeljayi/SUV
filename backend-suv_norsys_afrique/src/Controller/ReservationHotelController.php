<?php

namespace App\Controller;

use App\Entity\ReservationHotel;
use App\Repository\EvenementRepository;
use App\Repository\HotelRepository;
use App\Repository\ReservationHotelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationHotelController extends AbstractController
{
    #[Route('/reservation/hotel/ajouter', name: 'ajouter_reservation_hotel', methods: ['POST'])]
    public function reserver(Request $request, EntityManagerInterface $entityManager, HotelRepository $hotelRepository, EvenementRepository $evenementRepository): Response
    {
        $params = json_decode($request->getContent(), true);
        $hotel = $hotelRepository->findBy(['id' => $params['hotel']]);
        $evenement = $evenementRepository->findBy(['id' => $params['evenement']]);

        $reservation = new ReservationHotel();
        $reservation->setChambre($params['chambre']);
        $reservation->setDateEntree(new \DateTime($params['dateEntree']));
        $reservation->setDateSortie(new \DateTime($params['dateSortie']));
        $reservation->setNbrNuitParPersonne($params['nuitParPersonne']);
        $reservation->setNbrPersonne($params['nbrPersonne']);
        $reservation->setTotalNuitee($params['totalNuitee']);
        $reservation->setHotel($hotel[0]);
        $reservation->setEvenement($evenement[0]);

        $entityManager->persist($reservation);
        $entityManager->flush();
        $message = 'résérvation bien ajoutée';
        return new JsonResponse($message);
    }

    #liste des reservations
    #[Route('/reservation/hotel/liste', name: 'liste_reservation_hotel', methods: ['GET'])]
    public function liste(ReservationHotelRepository $repository): Response
    {
        $reservationHotels = $repository->findAll();
        return $this->json($reservationHotels, 200);
    }

    #affichage d'une reservations
    #[Route('/reservation/hotel/afficher/{id}', name: 'afficher_reservation_hotel', methods: ['GET'])]
    public function afficher($id, ReservationHotelRepository $repository): Response
    {
        $reservationHotels = $repository->find($id);
        return $this->json($reservationHotels, 200);
    }

    #modification d'une reservations
    #[Route('/reservation/hotel/modifier/{id}', name: 'modifier_reservation_hotel', methods: ['PUT'])]
    public function modifier($id,Request $request,EntityManagerInterface $entityManager, ReservationHotelRepository $repository, HotelRepository $hotelRepository, EvenementRepository $evenementRepository): Response
    {
        $params = json_decode($request->getContent(), true);
        $hotel = $hotelRepository->findBy(['id' => $params['hotel']]);
        $evenement = $evenementRepository->findBy(['id' => $params['evenement']]);

        $reservationHotel = $repository->find($id);
        $reservationHotel->setHotel($hotel[0]);
        $reservationHotel->setDateSortie(new \DateTime($params['dateSortie']));
        $reservationHotel->setDateEntree(new \DateTime($params['dateEntree']));
        $reservationHotel->setNbrPersonne($params['nbrPersonne']);
        $reservationHotel->setNbrNuitParPersonne($params['nuitParPersonne']);
        $reservationHotel->setTotalNuitee($params['totalNuitee']);
        $reservationHotel->setChambre($params['chambre']);
        $reservationHotel->setEvenement($evenement[0]);

        $entityManager->persist($reservationHotel);
        $entityManager->flush();
        return new JsonResponse(['message' => 'Réservation bien modifié'], 200);
    }

    #supprimer d'une reservations
    #[Route('/reservation/hotel/supprimer/{id}', name: 'supprimer_reservation_hotel', methods: ['DELETE'])]
    public function supprimer($id, EntityManagerInterface $entityManager, ReservationHotelRepository $repository): Response
    {
        $reservationHotel = $repository->find($id);

        $entityManager->remove($reservationHotel);
        $entityManager->flush();
        return new JsonResponse(['message' => 'reservation bien supprimé']);
    }
}
