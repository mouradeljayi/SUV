<?php

namespace App\Entity;

use App\Repository\AbsenceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AbsenceRepository::class)]
class Absence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $Du;

    #[ORM\Column(type: 'datetime')]
    private $Au;

    #[ORM\Column(type: 'integer')]
    private $nbrDeJours;

    #[ORM\Column(type: 'string', length: 255)]
    private $Motif;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $utilisateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDu(): ?\DateTimeInterface
    {
        return $this->Du;
    }

    public function setDu(\DateTimeInterface $Du): self
    {
        $this->Du = $Du;

        return $this;
    }

    public function getAu(): ?\DateTimeInterface
    {
        return $this->Au;
    }

    public function setAu(\DateTimeInterface $Au): self
    {
        $this->Au = $Au;

        return $this;
    }

    public function getNbrDeJours(): ?int
    {
        return $this->nbrDeJours;
    }

    public function setNbrDeJours(int $nbrDeJours): self
    {
        $this->nbrDeJours = $nbrDeJours;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->Motif;
    }

    public function setMotif(string $Motif): self
    {
        $this->Motif = $Motif;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
}
