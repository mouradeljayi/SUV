<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Repository\EvenementRepository;
use App\Repository\StatusEvenementRepository;
use App\Repository\TypeEvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EvenementController extends AbstractController
{
    #[Route('/evenement', name: 'app_evenement')]
    public function index(): Response
    {
        return $this->json([
        ]);
    }

    #[Route('/evenement/list', name: 'app_evenement_list', methods:['GET'])]
    public function Afficher(EvenementRepository $evenementRepository)
    {
        $evenement = $evenementRepository->findBy(["archive" => false]);
        return $this->json($evenement, 200);
    }

    #[Route('/evenement/afficher/{id}', name: 'app_evenement_un_list', methods:['GET'])]
    public function AfficherUn(EvenementRepository $evenementRepository, $id)
    {
        $evenement = $evenementRepository->find($id);
        return $this->json($evenement, 200);
    }

    #[Route('/evenement/create', name: 'create_evenement')]
    public function create(\Doctrine\Persistence\ManagerRegistry $doctrine, Request $request, TypeEvenementRepository $typeEvenementRepository, StatusEvenementRepository $statusEvenementRepository)
    {
        $content = $request->getContent();
        $param = json_decode($content, true);
        $type = $typeEvenementRepository->findBy(['id' => $param['type']]);
        $status = $statusEvenementRepository->findBy(['id' => $param['status']]);
        $evenement = new Evenement();
        $evenement->setNom($param['nom']);
        $evenement->setType($type[0]);
        $evenement->setStatus($status[0]);
        $evenement->setDate(new \DateTime($param['date']));
        $evenement->setDateFinEvenement(new \DateTime($param['date_fin_evenement']));
        $evenement->setDescription($param['description']);
        $evenement->setArchive(false);
        $entityManager = $doctrine->getManager();
        $entityManager->persist($evenement);
        $entityManager->flush();
        $message = "Event was successfully added";
        return new JsonResponse(array("message: $message"));
    }

    #[Route('/evenement/modifier/{id}', name: 'modifier_evenement', methods: ['PUT'])]
    public function modifier(Request $request, EntityManagerInterface $entityManager, int $id, EvenementRepository $evenementRepository, TypeEvenementRepository $typeEvenementRepository, StatusEvenementRepository $statusEvenementRepository)
    {
        $data = json_decode($request->getContent(), true);
        $status = $statusEvenementRepository->findBy(['id' => $data['status']]);
        $typeEvenement = $typeEvenementRepository->findBy(['id' => $data['Type']]);
        $evenement = $evenementRepository->find($id);
        $evenement->setNom($data['nom']);
        $evenement->setType($typeEvenement[0]);
        $evenement->setStatus($status[0]);
        $evenement->setDate(new \DateTime($data['date']));
        $evenement->setDateFinEvenement(new \DateTime($data['date_fin_evenement']));
        $evenement->setDescription($data['description']);
        $evenement->setArchive(false);
        $entityManager->persist($evenement);
        $entityManager->flush();
        return $this->json(['message' => 'Evenement modifiée avec succès'], Response::HTTP_OK);
    }

    #[Route('/evenement/archiver/{id}', name: 'app_evenement_archiver', methods: ['PUT'])]
    public function archiver(EntityManagerInterface $entityManager, int $id, EvenementRepository $evenementRepository)
    {
        $evenement = $evenementRepository->find($id);
        $evenement->setArchive(true);
        $entityManager->persist($evenement);
        $entityManager->flush();
        return $this->json(['message' => 'Evenement archivée avec succès'], Response::HTTP_OK);
    }

    #[Route('/restaurant/supprimer/{id}', name: 'app_restaurant_supprimer', methods: ['DELETE'])]
    public function supprimer(EntityManagerInterface $entityManager, int $id, EvenementRepository $evenementRepository)
    {
        $evenement = $evenementRepository->find($id);
        if ($evenement->getArchive()){
            $entityManager->remove($evenement);
            $entityManager->flush();
        } else{
            return $this->json(['message' => 'Evenement non archivée'], Response::HTTP_BAD_REQUEST);
        }
        return $this->json(['message' => 'Evenement supprimée avec succès'], Response::HTTP_OK);
    }

}
