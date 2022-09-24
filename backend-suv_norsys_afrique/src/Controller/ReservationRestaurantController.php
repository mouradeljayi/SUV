<?php

namespace App\Controller;

use App\Entity\ReservationRestaurant;
use App\Repository\EvenementRepository;
use App\Repository\ReservationRestaurantRepository;
use App\Repository\RestaurantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationRestaurantController extends AbstractController
{
    #[Route('/reservation/restaurant', name: 'app_reservation_restaurant', methods:['GET'])]
    public function Afficher(ReservationRestaurantRepository $reservationResaturantRepository)
    {
        $reservationResaturant = $reservationResaturantRepository->findBy(["archive" => false]);
        return $this->json($reservationResaturant, 200);
    }

    #[Route('/reservation/restaurant/{id}', name:'app_reservation_restaurantUn', methods:['GET'])]
    public function AfficherUn($id, ReservationRestaurantRepository $reservationResaturantRepository){
        $reservationResaturant = $reservationResaturantRepository->find($id);
        return $this->json($reservationResaturant);
    }

    #[Route('/reservation/restaurant/ajouter', name:'app_reservation_restaurant_ajouter', methods:['POST'])]
    public function Ajouter(Request $request, EntityManagerInterface $entityManagerInterface, EvenementRepository $evenementRepository, RestaurantRepository $restaurantRepository){
        $data = json_decode($request->getContent(),true);
        $reservationResaturant = new ReservationRestaurant();
        $restaurant = $restaurantRepository->findBy(['id' => $data['restaurant']]);
        $evenement = $evenementRepository->findBy(['id' => $data['evenement']]);
        $reservationResaturant->setRestaurant($restaurant[0]);
        $reservationResaturant->setEvenement($evenement[0]);
        $reservationResaturant->setDateEntree(new \DateTime($data['date_entree']));
        $reservationResaturant->setNbrPersonne($data['nbr_personne']);
        $reservationResaturant->setArchive(false);
        $entityManagerInterface->persist($reservationResaturant);
        $entityManagerInterface->flush();
        return $this->json(["Message" => "Réservation  avec succés"], 200);
    }

    #[Route('/reservation/restaurant/modifier/{id}', name:'app_reservation_restaurant_modifier', methods:['PUT'])]
    public function Modifier($id, Request $request, EntityManagerInterface $entityManagerInterface, ReservationRestaurantRepository $reservationResaturantRepository, EvenementRepository $evenementRepository, RestaurantRepository $restaurantRepository){
        $data = json_decode($request->getContent(), true);
        $reservationResaturant = $reservationResaturantRepository->find($id);
        $restaurant = $restaurantRepository->findBy(['id' => $data['restaurant']]);
        $evenement = $evenementRepository->findBy(['id' => $data['evenement']]);
        $reservationResaturant->setRestaurant($restaurant[0]);
        $reservationResaturant->setEvenement($evenement[0]);
        $reservationResaturant->setDateEntree(new \DateTime($data['dateEntree']));
        $reservationResaturant->setNbrPersonne($data['nbrPersonne']);
        $reservationResaturant->setArchive(false);
        $entityManagerInterface->persist($reservationResaturant);
        $entityManagerInterface->flush();
        return $this->json(["Message" => "Réservation modifier  avec succés"], 200);
    }

    #[Route('/reservation/restaurant/archiver/{id}', name: 'app_reservation_restaurant_archiver', methods: ['PUT'])]
    public function archiver(EntityManagerInterface $entityManager, int $id, ReservationRestaurantRepository $reservationResaturantRepository){
        $reservationResaturant = $reservationResaturantRepository->find($id);
        $reservationResaturant->setArchive(true);

        $entityManager->persist($reservationResaturant);
        $entityManager->flush();

        return $this->json(['message' => 'Reservation restaurant archivée avec succès'], Response::HTTP_OK);
    }

    #[Route('/reservation/restaurant/supprimer/{id}', name: 'app_reservation_restaurant_supprimer', methods: ['DELETE'])]
    public function supprimer(EntityManagerInterface $entityManager, int $id, ReservationRestaurantRepository $reservationResaturantRepository){
        $reservationResaturant = $reservationResaturantRepository->find($id);
        if ($reservationResaturant->getArchive()){
            $entityManager->remove($reservationResaturant);
            $entityManager->flush();
        } else{
            return $this->json(['message' => 'Reservation restaurant non archivée'], Response::HTTP_BAD_REQUEST);
        }
        return $this->json(['message' => 'Reservation restaurant supprimée avec succès'], Response::HTTP_OK);
    }
}
