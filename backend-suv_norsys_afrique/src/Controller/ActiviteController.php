<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Entity\QuestionnaireActivites;
use App\Entity\Utilisateur;
use App\Repository\ActiviteRepository;
use App\Repository\EvenementRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActiviteController extends AbstractController
{
    #[Route('/activites', name: 'activite_liste', methods: ['GET'])]
    public function index(ActiviteRepository $activiteRepository): JsonResponse{
        $activites = $activiteRepository->findBy(["archive" => false]);
        return $this->json($activites, Response::HTTP_OK);
    }

    /**
     * @throws \Exception
     */
    #[Route('/activites/ajouter', name: 'app_activite_ajouter', methods: ['POST'])]
    public function ajouter(Request $request, EntityManagerInterface $entityManager, UtilisateurRepository $utilisateurRepository, EvenementRepository $evenementRepository): JsonResponse{
        $data = json_decode($request->getContent(), true);
        $evenement = $evenementRepository->findBy(['id' => $data['evenement']]);
        $activite = new Activite();
        $utilisateur = $utilisateurRepository->findBy(['id' => $data['responsable_etude']]);
        $activite->setNom($data['nom']);
        $activite->setDate(new \DateTime($data['date']));
        $activite->setCotisation($data['cotisation']);
        $activite->setCotisationEntreprise($data['cotisation_entreprise']);
        $activite->setCotisationParSalarie($data['cotisation_par_salarie']);
        $activite->setMontant($data['montant']);
        $activite->setDetailMontant($data['detail_montant']);
        $activite->setPrixGlobalParSalarie($data['prix_globale_par_salarie']);
        $activite->setDescription($data['description']);
        $activite->setParticipant($data['participant']);
        $activite->setResponsableEtude($utilisateur[0]);
        $activite->setEvenement($evenement[0]);
        $activite->setArchive(false);
        $entityManager->persist($activite);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Activité ajoutée avec succès'], Response::HTTP_CREATED);
    }

    #[Route('/activites/afficher/{id}', name: 'app_activite_une', methods: ['GET'])]
    public function afficher(ActiviteRepository $activiteRepository, int $id): JsonResponse{
        $activite = $activiteRepository->find($id);
        return $this->json($activite, Response::HTTP_OK);
    }

    #[Route('/activites/modifier/{id}', name: 'app_activite_modifier', methods: ['PUT'])]
    public function modifier(Request $request, EntityManagerInterface $entityManager, int $id, ActiviteRepository $activiteRepository, UtilisateurRepository $utilisateurRepository, EvenementRepository $evenementRepository): JsonResponse{
        $data = json_decode($request->getContent(), true);

        $activite = $activiteRepository->find($id);
        $evenement = $evenementRepository->findBy(['id' => $data['evenement']]);
        $utilisateur = $utilisateurRepository->findBy(['id' => $data['responsableEtude']]);

        $activite->setNom($data['nom']);
        $activite->setDate(new \DateTime($data['date']));
        $activite->setCotisation($data['cotisation']);
        $activite->setCotisationEntreprise($data['cotisation_entreprise']);
        $activite->setCotisationParSalarie($data['cotisation_par_salarie']);
        $activite->setMontant($data['montant']);
        $activite->setDetailMontant($data['detail_montant']);
        $activite->setPrixGlobalParSalarie($data['prixGlobalParSalarie']);
        $activite->setDescription($data['description']);
        $activite->setParticipant($data['participant']);
        $activite->setResponsableEtude($utilisateur[0]);
        $activite->setEvenement($evenement[0]);
        $entityManager->persist($activite);
        $entityManager->flush();


        return new JsonResponse(['message' => 'Activité modifiée avec succès'], Response::HTTP_OK);
    }

    #[Route('/activites/archiver/{id}', name: 'app_activite_archiver', methods: ['PUT'])]
    public function archiver(EntityManagerInterface $entityManager, int $id, ActiviteRepository $activiteRepository): JsonResponse{
        $activite = $activiteRepository->find($id);
        $activite->setArchive(true);

        $entityManager->persist($activite);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Activité archivée avec succès'], Response::HTTP_OK);
    }

    #[Route('/activites/supprimer/{id}', name: 'app_activite_supprimer', methods: ['DELETE'])]
    public function supprimer(EntityManagerInterface $entityManager, int $id, ActiviteRepository $activiteRepository): JsonResponse{
        $activite = $activiteRepository->find($id);
        if ($activite->getArchive()){
            $entityManager->remove($activite);
            $entityManager->flush();
        } else{
            return new JsonResponse(['message' => 'Activité non archivée'], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse(['message' => 'Activité supprimée avec succès'], Response::HTTP_OK);
    }
}
