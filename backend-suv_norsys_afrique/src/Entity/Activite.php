<?php

namespace App\Entity;

use App\Repository\ActiviteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: ActiviteRepository::class)]
class Activite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("pac")]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("pac")]
    private $nom;

    #[ORM\Column(type: 'datetime')]
    #[Groups("pac")]
    private $date;

    #[ORM\Column(type: 'float')]
    #[Groups("pac")]
    private $montant;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("pac")]
    private $detailMontant;

    #[ORM\Column(type: 'float')]
    #[Groups("pac")]
    private $cotisation;

    #[ORM\Column(type: 'float')]
    #[Groups("pac")]
    private $cotisationEntreprise;

    #[ORM\Column(type: 'float')]
    #[Groups("pac")]
    private $cotisationParSalarie;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("pac")]
    private $description;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $responsableEtude;

    #[ORM\Column(type: 'float')]
    private $prixGlobalParSalarie;

    #[ORM\Column(type: 'integer')]
    private $participant;

    #[ORM\Column(type: 'boolean')]
    private $archive;

    #[Ignore]
    #[ORM\ManyToOne(targetEntity: QuestionnaireActivites::class, inversedBy: 'activites')]
    private $questionnaireActivites;

    #[ORM\ManyToOne(targetEntity: Evenement::class, inversedBy: 'activites')]
    #[Groups("pac")]
    private $evenement;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDetailMontant(): ?string
    {
        return $this->detailMontant;
    }

    public function setDetailMontant(string $detailMontant): self
    {
        $this->detailMontant = $detailMontant;

        return $this;
    }

    public function getCotisation(): ?float
    {
        return $this->cotisation;
    }

    public function setCotisation(float $cotisation): self
    {
        $this->cotisation = $cotisation;

        return $this;
    }

    public function getCotisationEntreprise(): ?float
    {
        return $this->cotisationEntreprise;
    }

    public function setCotisationEntreprise(float $cotisationEntreprise): self
    {
        $this->cotisationEntreprise = $cotisationEntreprise;

        return $this;
    }

    public function getCotisationParSalarie(): ?float
    {
        return $this->cotisationParSalarie;
    }

    public function setCotisationParSalarie(float $cotisationParSalarie): self
    {
        $this->cotisationParSalarie = $cotisationParSalarie;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getResponsableEtude(): ?Utilisateur
    {
        return $this->responsableEtude;
    }

    public function setResponsableEtude(?Utilisateur $responsableEtude): self
    {
        $this->responsableEtude = $responsableEtude;

        return $this;
    }

    public function getPrixGlobalParSalarie(): ?float
    {
        return $this->prixGlobalParSalarie;
    }

    public function setPrixGlobalParSalarie(float $prixGlobalParSalarie): self
    {
        $this->prixGlobalParSalarie = $prixGlobalParSalarie;

        return $this;
    }

    public function getParticipant(): ?int
    {
        return $this->participant;
    }

    public function setParticipant(int $participant): self
    {
        $this->participant = $participant;

        return $this;
    }

    public function getArchive(): ?bool
    {
        return $this->archive;
    }

    public function setArchive(bool $archive): self
    {
        $this->archive = $archive;

        return $this;
    }

    public function getQuestionnaireActivites(): ?QuestionnaireActivites
    {
        return $this->questionnaireActivites;
    }

    public function setQuestionnaireActivites(?QuestionnaireActivites $questionnaireActivites): self
    {
        $this->questionnaireActivites = $questionnaireActivites;

        return $this;
    }

    public function getEvenement(): ?Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(?Evenement $evenement): self
    {
        $this->evenement = $evenement;

        return $this;
    }
}
