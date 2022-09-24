<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class RestaurantController extends AbstractController
{
    #[Route('/restaurant', name: 'app_restaurant', methods: ['GET'])]
    public function afficher(RestaurantRepository $restaurantRepository)
    {
        $estaurant = $restaurantRepository->findBy(["archive" => false]);
        return $this->json($estaurant, Response::HTTP_OK);
    }

    #[Route('/restaurant/{id}', name: 'app_restaurant_un', methods: ['GET'])]
    public function afficherUn(RestaurantRepository $restaurantRepository, int $id)
    {
        $restaurant = $restaurantRepository->find($id);
        return $this->json($restaurant, Response::HTTP_OK);
    }

    #[Route('/restaurant/ajouter', name: 'app_restaurant_ajouter', methods: ['POST'])]
    public function ajouter(Request $request, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), true);
        $restaurant = new Restaurant();
        $restaurant->setNom($data['nom']);
        $restaurant->setAdresse($data['adresse']);
        $restaurant->setArchive(false);
        $entityManager->persist($restaurant);
        $entityManager->flush();
        return $this->json(['message' => 'Restaurant ajoutée avec succès'], Response::HTTP_CREATED);
    }

    #[Route('/restaurant/modifier/{id}', name: 'app_restaurant_modifier', methods: ['PUT'])]
    public function modifier(Request $request, EntityManagerInterface $entityManager, int $id, RestaurantRepository $restaurantRepository)
    {
        $data = json_decode($request->getContent(), true);
        $restaurant = $restaurantRepository->find($id);
        $restaurant->setNom($data['nom']);
        $restaurant->setAdresse($data['adresse']);
        $entityManager->persist($restaurant);
        $entityManager->flush();
        return $this->json(['message' => 'Restaurant modifiée avec succès'], Response::HTTP_OK);
    }

    #[Route('/restaurant/archiver/{id}', name: 'app_restaurant_archiver', methods: ['PUT'])]
    public function archiver(EntityManagerInterface $entityManager, int $id, RestaurantRepository $restaurantRepository)
    {
        $restaurant = $restaurantRepository->find($id);
        $restaurant->setArchive(true);
        $entityManager->persist($restaurant);
        $entityManager->flush();
        return $this->json(['message' => 'Restaurant archivée avec succès'], Response::HTTP_OK);
    }

    #[Route('/restaurant/supprimer/{id}', name: 'app_restaurant_supprimer', methods: ['DELETE'])]
    public function supprimer(EntityManagerInterface $entityManager, int $id, RestaurantRepository $restaurantRepository)
    {
        $restaurant = $restaurantRepository->find($id);
        if ($restaurant->getArchive()){
            $entityManager->remove($restaurant);
            $entityManager->flush();
        } else{
            return $this->json(['message' => 'Restaurant non archivée'], Response::HTTP_BAD_REQUEST);
        }
        return $this->json(['message' => 'Restaurant supprimée avec succès'], Response::HTTP_OK);
    }


}
