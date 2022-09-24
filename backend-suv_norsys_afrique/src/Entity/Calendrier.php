<?php

namespace App\Entity;

use App\Repository\CalendrierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CalendrierRepository::class)]
class Calendrier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'datetime')]
    private $date;

    #[ORM\ManyToMany(targetEntity: Reunion::class)]
    private $reunion;

    #[ORM\ManyToMany(targetEntity: Tache::class)]
    private $tache;

    #[ORM\ManyToMany(targetEntity: Evenement::class)]
    private $Evenement;

    #[ORM\ManyToMany(targetEntity: Projet::class)]
    private $projet;

    public function __construct()
    {
        $this->reunion = new ArrayCollection();
        $this->tache = new ArrayCollection();
        $this->Evenement = new ArrayCollection();
        $this->projet = new ArrayCollection();
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, Reunion>
     */
    public function getReunion(): Collection
    {
        return $this->reunion;
    }

    public function addReunion(Reunion $reunion): self
    {
        if (!$this->reunion->contains($reunion)) {
            $this->reunion[] = $reunion;
        }

        return $this;
    }

    public function removeReunion(Reunion $reunion): self
    {
        $this->reunion->removeElement($reunion);

        return $this;
    }

    /**
     * @return Collection<int, Tache>
     */
    public function getTache(): Collection
    {
        return $this->tache;
    }

    public function addTache(Tache $tache): self
    {
        if (!$this->tache->contains($tache)) {
            $this->tache[] = $tache;
        }

        return $this;
    }

    public function removeTache(Tache $tache): self
    {
        $this->tache->removeElement($tache);

        return $this;
    }

    /**
     * @return Collection<int, Evenement>
     */
    public function getEvenement(): Collection
    {
        return $this->Evenement;
    }

    public function addEvenement(Evenement $evenement): self
    {
        if (!$this->Evenement->contains($evenement)) {
            $this->Evenement[] = $evenement;
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        $this->Evenement->removeElement($evenement);

        return $this;
    }

    /**
     * @return Collection<int, Projet>
     */
    public function getProjet(): Collection
    {
        return $this->projet;
    }

    public function addProjet(Projet $projet): self
    {
        if (!$this->projet->contains($projet)) {
            $this->projet[] = $projet;
        }

        return $this;
    }

    public function removeProjet(Projet $projet): self
    {
        $this->projet->removeElement($projet);

        return $this;
    }
}
