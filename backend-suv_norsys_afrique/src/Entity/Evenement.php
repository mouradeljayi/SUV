<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("pac")]
    private $nom;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $participants;

    #[ORM\Column(type: 'float', nullable: true)]
    private $montantGlobal;

    #[ORM\Column(type: 'float', nullable: true)]
    private $subventionEntreprise;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $description;

    #[ORM\ManyToMany(targetEntity: Utilisateur::class)]
    private $collaborateur;

    #[ORM\Column(type: 'datetime')]
    private $date;

    #[ORM\ManyToOne(targetEntity: TypeEvenement::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $Type;

    #[ORM\ManyToOne(targetEntity: StatusEvenement::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $status;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $archive;

    #[ORM\Column(type: 'date', nullable: true)]
    private $date_fin_evenement;

    public function __construct()
    {
        $this->collaborateur = new ArrayCollection();
    }

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

    public function getParticipants(): ?int
    {
        return $this->participants;
    }

    public function setParticipants(?int $participants): self
    {
        $this->participants = $participants;

        return $this;
    }

    public function getMontantGlobal(): ?float
    {
        return $this->montantGlobal;
    }

    public function setMontantGlobal(?float $montantGlobal): self
    {
        $this->montantGlobal = $montantGlobal;

        return $this;
    }

    public function getSubventionEntreprise(): ?float
    {
        return $this->subventionEntreprise;
    }

    public function setSubventionEntreprise(?float $subventionEntreprise): self
    {
        $this->subventionEntreprise = $subventionEntreprise;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getCollaborateur(): Collection
    {
        return $this->collaborateur;
    }

    public function addCollaborateur(Utilisateur $collaborateur): self
    {
        if (!$this->collaborateur->contains($collaborateur)) {
            $this->collaborateur[] = $collaborateur;
        }

        return $this;
    }

    public function removeCollaborateur(Utilisateur $collaborateur): self
    {
        $this->collaborateur->removeElement($collaborateur);

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

    public function getType(): ?TypeEvenement
    {
        return $this->Type;
    }

    public function setType(?TypeEvenement $Type): self
    {
        $this->Type = $Type;

        return $this;
    }

    public function getStatus(): ?StatusEvenement
    {
        return $this->status;
    }

    public function setStatus(?StatusEvenement $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getArchive(): ?bool
    {
        return $this->archive;
    }

    public function setArchive(?bool $archive): self
    {
        $this->archive = $archive;

        return $this;
    }

    public function getDateFinEvenement(): ?\DateTimeInterface
    {
        return $this->date_fin_evenement;
    }

    public function setDateFinEvenement(?\DateTimeInterface $date_fin_evenement): self
    {
        $this->date_fin_evenement = $date_fin_evenement;

        return $this;
    }
}
