<?php

namespace App\Controller;

use App\Entity\VisiteClient;
use App\Repository\EvenementRepository;
use App\Repository\HotelRepository;
use App\Repository\RestaurantRepository;
use App\Repository\TransportRepository;
use App\Repository\VisiteClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VisiteClientController extends AbstractController
{
    #[Route('/visite/client', name: 'app_visite_client')]
    public function index(): Response
    {
        return $this->render('visite_client/index.html.twig', [
            'controller_name' => 'VisiteClientController',
        ]);
    }

    #[Route('/visiteclient/liste', name: 'visite_client_liste', methods: ['GET'])]
    public function afficherVisiteClient(VisiteClientRepository $visiteClientRepository)
    {
        $visiteClient = $visiteClientRepository->findAll();
        return $this->json($visiteClient, 200);
    }

    #[Route('/visiteclient/afficher/{id}', name: 'visite_client_afficher', methods: ['GET'])]
    public function afficherVisiteClientt($id, VisiteClientRepository $visiteClientRepository){
        $visiteClient = $visiteClientRepository->find($id);
        return $this->json($visiteClient, 200);
    }

    #[Route('/visiteclient/ajouter', name: 'visite_client_ajouter', methods: ['POST'])]
    public function ajouterVisiteClient(Request $request, EntityManagerInterface $emi, TransportRepository $transportRepository, RestaurantRepository $restaurantRepository, HotelRepository $hotelRepository, EvenementRepository $evenementRepository){
        $visiteClient = new VisiteClient();
        $data = json_decode($request->getContent(), true);

         $transport = $transportRepository->findBy(['id' => $data['transport']]);
        $restaurant = $restaurantRepository->findBy(['id' => $data['restaurant']]);
        $evenement = $evenementRepository->findBy(['id' => $data['evenement']]);
        $hotel = $hotelRepository->findBy(['id' => $data['hotel']]);

        $visiteClient->setJour(new \DateTime($data["jour"]));
        $visiteClient->setProgrammeDeJour($data["programmedejour"]);
        $visiteClient->setHeure(new \DateTime($data["houre"]));
        $visiteClient->setNombreDePax($data["nombredepax"]);
        $visiteClient->setTransport($transport[0]);
        $visiteClient->setHotel($hotel[0]);
        $visiteClient->setRestaurant($restaurant[0]);
        $visiteClient->setEvenement($evenement[0]);

        $emi->persist($visiteClient);
        $emi->flush();

        return $this->json(["Message" => "Visite Client( Ajoute"], 200);

    }

    #[Route('/visiteclient/modifier/{id}', name: 'visite_client_modifier', methods: ['PUT'])]
    public function modifierVisiteClient($id, Request $request, VisiteClientRepository $visiteClientRepository, EntityManagerInterface $emi, TransportRepository $transportRepository, HotelRepository $hotelRepository, RestaurantRepository $restaurantRepository, EvenementRepository $evenementRepository){
        $visiteClient = $visiteClientRepository->find($id);
        $data =json_decode($request->getContent(), true);

        $transport = $transportRepository->findBy(['id' => $data['transport']]);
        $restaurant = $restaurantRepository->findBy(['id' => $data['restaurant']]);
        $hotel = $hotelRepository->findBy(['id' => $data['hotel']]);
        $evenement = $evenementRepository->findBy(['id' => $data['evenement']]);

        $visiteClient->setJour(new \DateTime($data["Jour"]));
        $visiteClient->setProgrammeDeJour($data["programmeDeJour"]);
        $visiteClient->setHeure(new \DateTime($data["heure"]));
        $visiteClient->setNombreDePax($data["nombreDePax"]);
        $visiteClient->setTransport($transport[0]);
        $visiteClient->setHotel($hotel[0]);
        $visiteClient->setRestaurant($restaurant[0]);
        $visiteClient->setEvenement($evenement[0]);

        $emi->persist($visiteClient);
        $emi->flush();

        return $this->json(["Message"=>"Visite Client Modifier"],200);
    }

    #[Route('/visiteclient/supprimer/{id}', name: 'visite_client_supprimer', methods: ['DELETE'])]
    public function supprimerVisiteClient($id, VisiteClientRepository $visiteClientRepository, EntityManagerInterface $emi){
        $visiteClient = $visiteClientRepository->find($id);

        $emi->remove($visiteClient);
        $emi->flush();

        return $this->json(["Message"=>"Visite Client Supprimer"]);
    }
}
