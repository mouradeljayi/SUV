<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateursController extends AbstractController
{
    #ajouter utilisateur :
    /**
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    #[Route('/utilisateur/ajouter', name: 'user.create', methods: ['POST'])]
    public function create(Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $emi, MailerInterface $mailer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $utilisateur = new Utilisateur();
        $utilisateur->setNom($data["nom"]);
        $utilisateur->setPrenom($data["prenom"]);
        $utilisateur->setEmail($data["email"]);
        $utilisateur->setPassword($hasher->hashPassword($utilisateur, $data["password"]));
        $utilisateur->setRoles(["ROLE_USER"]);
        $utilisateur->setDateNaissance(new \DateTime($data["dateNaissance"]));
        $utilisateur->setVille($data["ville"]);
        $utilisateur->setPays($data["pays"]);
        $utilisateur->setCodePostal($data["codePostal"]);
        $utilisateur->setAdresse($data["adresse"]);
        $utilisateur->setTelephone($data["telephone"]);
        $emi->persist($utilisateur);
        $emi->flush();
        $email = (new Email())
            ->from("no-reply@suvnaf.ma")
            ->to($data["email"])
            ->subject('Information de connexion')
            ->html("<p>Bonjour,</p><br>Veuillez trouver ci-joint vos identifiants de connexion a votre portail<a href='http://localhost:8080/dashboard' style='color: #1b1b1b;'><i> SUV Norsys Afrique: </i></a> 
                           <br><b>Adresse email: </b>".$data['email']."
                           <br><b>Mot de passe: </b>". $data['password']);
        $mailer->send($email);

        return $this->json([
            'message' => 'Utilisateur créé',
        ], 201);
    }
#afficher utilisateur :
    #[Route('/utilisateurs', name: 'user.list', methods: ['GET'])]
    public function utilisateur(UtilisateurRepository $utilisateurRepository): JsonResponse
    {
        $utilisateurs = $utilisateurRepository->findAll();
        return $this->json($utilisateurs, 201);
    }
    #[Route('/utilisateurs/{id}', name: 'user.find', methods: ['GET'])]
    public function find(UtilisateurRepository $utilisateurRepository, $id): JsonResponse
    {
        $utilisateurs = $utilisateurRepository->find($id);
        return $this->json($utilisateurs, 201);
    }
#modifier utilisateur :
    #[Route('/utilisateurs/edit/{id}', name: 'user.update', methods: ['PUT'])]
    public function editutilisateur(ManagerRegistry $doctrine,$id, UserPasswordHasherInterface $hasher,Request $request){
        $entityManager = $doctrine->getManager();
        $utilisateur = $doctrine->getRepository(Utilisateur::class)->find($id);
        if ($utilisateur == null) {
            return $this->json('utilisateur n\'existe pas' , 404);
        }
        $parametre = json_decode($request->getContent(),true);
        $utilisateur->setNom($parametre["nom"]);
        $utilisateur->setPrenom($parametre["prenom"]);
        $utilisateur->setEmail($parametre["email"]);
        $utilisateur->setDateNaissance(new \DateTime($parametre["dateNaissance"]));
        $utilisateur->setVille($parametre["ville"]);
        $utilisateur->setPays($parametre["pays"]);
        $utilisateur->setCodePostal($parametre["codePostal"]);
        $utilisateur->setAdresse($parametre["adresse"]);
        $utilisateur->setTelephone($parametre["telephone"]);
        $entityManager->flush();
        return new JsonResponse(
            [
                "message"=>"utilisateur updated successfully !"
            ]
        );
    }
#supprimer utilisateur :
    #[Route('/utilisateurs/delete/{id}', name: 'user.delete', methods: ['DELETE'])]
    public function deleteUtilisateur($id, UtilisateurRepository $repository, EntityManagerInterface $entityManager) {
        $entityManager->remove($repository->find($id));
        $entityManager->flush();
        return $this->json("Deleted", 200);
    }
}