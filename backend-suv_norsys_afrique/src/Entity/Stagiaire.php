<?php

namespace App\Entity;

use App\Repository\StagiaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StagiaireRepository::class)]
class Stagiaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $prenom;

    #[ORM\Column(type: 'string', length: 255)]
    private $CV;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $diplome;

    #[ORM\ManyToOne(targetEntity: Absence::class)]
    private $absence;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $universite;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $photo;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $formationActuelle;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    private $encadrant;

    #[ORM\Column(type: 'boolean')]
    private $technomaker;

    #[ORM\ManyToOne(targetEntity: Projet::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $sujetStage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getCV(): ?string
    {
        return $this->CV;
    }

    public function setCV(string $CV): self
    {
        $this->CV = $CV;

        return $this;
    }

    public function getDiplome(): ?string
    {
        return $this->diplome;
    }

    public function setDiplome(?string $diplome): self
    {
        $this->diplome = $diplome;

        return $this;
    }

    public function getAbsence(): ?Absence
    {
        return $this->absence;
    }

    public function setAbsence(?Absence $absence): self
    {
        $this->absence = $absence;

        return $this;
    }

    public function getUniversite(): ?string
    {
        return $this->universite;
    }

    public function setUniversite(?string $universite): self
    {
        $this->universite = $universite;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getFormationActuelle(): ?string
    {
        return $this->formationActuelle;
    }

    public function setFormationActuelle(?string $formationActuelle): self
    {
        $this->formationActuelle = $formationActuelle;

        return $this;
    }

    public function getEncadrant(): ?Utilisateur
    {
        return $this->encadrant;
    }

    public function setEncadrant(?Utilisateur $encadrant): self
    {
        $this->encadrant = $encadrant;

        return $this;
    }

    public function getTechnomaker(): ?bool
    {
        return $this->technomaker;
    }

    public function setTechnomaker(bool $technomaker): self
    {
        $this->technomaker = $technomaker;

        return $this;
    }

    public function getSujetStage(): ?Projet
    {
        return $this->sujetStage;
    }

    public function setSujetStage(?Projet $sujetStage): self
    {
        $this->sujetStage = $sujetStage;

        return $this;
    }
}
