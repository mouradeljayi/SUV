<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Repository\HotelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HotelController extends AbstractController
{
    #affichage des hotels
    #[Route('/hotels', name: 'liste_hotel', methods: ['GET'])]
    public function afficher(HotelRepository $repository): JsonResponse
    {
        $hotels = $repository->findAll();
        return $this->json($hotels, Response::HTTP_OK);
    }

    #affichage d'un hotel
    #[Route('/hotel/afficher/{id}', name: 'affichage_hotel', methods: ['GET'])]
    public function afficherHotel($id, HotelRepository $repository)
    {
        $hotel = $repository->find($id);
        return $this->json($hotel, 200);

    }

    #ajouter un hotel
    #[Route('/hotel/ajouter', name: 'ajouter_hotel', methods: ['POST'])]
    public function ajouter(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $params = json_decode($request->getContent(), true);

        $hotel = new Hotel();
        $hotel->setNom($params['nom']);
        $hotel->setAdresse($params['adresse']);

        $entityManager->persist($hotel);
        $entityManager->flush();

        return new JsonResponse(['message' => 'hotel bien ajouté'], Response::HTTP_OK);
    }

    #modification d'un hotel
    #[Route('/hotel/modifier/{id}', name: 'modifier_hotel', methods: ['PUT'])]
    public function modifier($id, Request $request, EntityManagerInterface $entityManager, HotelRepository $repository): JsonResponse
    {
        $params = json_decode($request->getContent(), true);

        $hotel = $repository->find($id);
        $hotel->setNom($params['nom']);
        $hotel->setAdresse($params['adresse']);

        $entityManager->persist($hotel);
        $entityManager->flush();

        return new JsonResponse(['message' => 'hotel bien modifié'], Response::HTTP_OK);
    }

    #Supprimer un hotel
    #[Route('/hotel/supprimer/{id}', name: 'supprimer_hotel', methods: ['DELETE'])]
    public function supprimer($id, EntityManagerInterface $entityManager, HotelRepository $repository): JsonResponse
    {
        $hotel = $repository->find($id);

        $entityManager->remove($hotel);
        $entityManager->flush();
        return new JsonResponse(['message' => 'hotel bien supprimé']);
    }
}
