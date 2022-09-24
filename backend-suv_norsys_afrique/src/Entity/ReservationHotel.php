<?php

namespace App\Entity;

use App\Repository\ReservationHotelRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationHotelRepository::class)]
class ReservationHotel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $dateEntree;

    #[ORM\Column(type: 'date')]
    private $dateSortie;

    #[ORM\Column(type: 'integer')]
    private $nbrPersonne;

    #[ORM\Column(type: 'string', length: 255)]
    private $chambre;

    #[ORM\Column(type: 'integer')]
    private $nbrNuitParPersonne;

    #[ORM\Column(type: 'integer')]
    private $totalNuitee;

    #[ORM\ManyToOne(targetEntity: Hotel::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $hotel;

    #[ORM\ManyToOne(targetEntity: Evenement::class)]
    private $evenement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEntree(): ?\DateTimeInterface
    {
        return $this->dateEntree;
    }

    public function setDateEntree(\DateTimeInterface $dateEntree): self
    {
        $this->dateEntree = $dateEntree;

        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->dateSortie;
    }

    public function setDateSortie(\DateTimeInterface $dateSortie): self
    {
        $this->dateSortie = $dateSortie;

        return $this;
    }

    public function getNbrPersonne(): ?int
    {
        return $this->nbrPersonne;
    }

    public function setNbrPersonne(int $nbrPersonne): self
    {
        $this->nbrPersonne = $nbrPersonne;

        return $this;
    }

    public function getChambre(): ?string
    {
        return $this->chambre;
    }

    public function setChambre(string $chambre): self
    {
        $this->chambre = $chambre;

        return $this;
    }

    public function getNbrNuitParPersonne(): ?int
    {
        return $this->nbrNuitParPersonne;
    }

    public function setNbrNuitParPersonne(int $nbrNuitParPersonne): self
    {
        $this->nbrNuitParPersonne = $nbrNuitParPersonne;

        return $this;
    }

    public function getTotalNuitee(): ?int
    {
        return $this->totalNuitee;
    }

    public function setTotalNuitee(int $totalNuitee): self
    {
        $this->totalNuitee = $totalNuitee;

        return $this;
    }

    public function getHotel(): ?Hotel
    {
        return $this->hotel;
    }

    public function setHotel(?Hotel $hotel): self
    {
        $this->hotel = $hotel;

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
