<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/auth/register', name: 'register', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $emi): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $utilisateur = new Utilisateur();
        $utilisateur->setEmail($data["email"]);
        $utilisateur->setPassword($hasher->hashPassword($utilisateur, $data["password"]));
        $utilisateur->setRoles(["ROLE_ADMIN"]);
        $utilisateur->setNom($data["nom"]);
        $utilisateur->setPrenom($data["prenom"]);
        $utilisateur->setTelephone($data["telephone"]);
        $utilisateur->setAdresse($data["adresse"]);
        $utilisateur->setVille($data["ville"]);
        $utilisateur->setCodePostal($data["codePostal"]);
        $utilisateur->setPays($data["pays"]);
        $utilisateur->setDateNaissance(new \DateTime($data["dateNaissance"]));
        $emi->persist($utilisateur);
        $emi->flush();
        return $this->json([
            'message' => 'Utilisateurs créé'
        ], 201);
    }

    #[Route('/auth/login', name: 'login', methods: ['POST'])]
    public function login(Request $request, UtilisateurRepository $utilisateurRepository, UserPasswordHasherInterface $hasher, JWTTokenManagerInterface $jwt): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $utilisateur = $utilisateurRepository->findOneBy(['email' => $data['email']]);
        if (!$utilisateur) {
            return $this->json([
                'code' => 404,
                'message' => 'Cet utilisateur n\'existe pas'
            ], 404);
        }
        if (!$hasher->isPasswordValid($utilisateur, $data['password'])) {
            return $this->json([
                'code' => 401,
                'message' => 'Mot de passe incorrect'
            ], 401);
        }
        return new JsonResponse([
            'token' => $jwt->create($utilisateur)
        ], 200);
    }
}
