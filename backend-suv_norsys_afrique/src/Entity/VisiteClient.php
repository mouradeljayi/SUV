<?php

namespace App\Entity;

use App\Repository\VisiteClientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisiteClientRepository::class)]
class VisiteClient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date', nullable: true)]
    private $Jour;

    #[ORM\Column(type: 'text', nullable: true)]
    private $programme_de_jour;

    #[ORM\Column(type: 'time', nullable: true)]
    private $heure;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $nombre_de_pax;

    #[ORM\ManyToOne(targetEntity: Hotel::class)]
    private $hotel;

    #[ORM\ManyToOne(targetEntity: Transport::class)]
    private $transport;

    #[ORM\ManyToOne(targetEntity: Restaurant::class)]
    private $restaurant;

    #[ORM\ManyToOne(targetEntity: Evenement::class, inversedBy: 'visiteClients')]
    private $evenement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJour(): ?\DateTimeInterface
    {
        return $this->Jour;
    }

    public function setJour(?\DateTimeInterface $Jour): self
    {
        $this->Jour = $Jour;

        return $this;
    }

    public function getProgrammeDeJour(): ?string
    {
        return $this->programme_de_jour;
    }

    public function setProgrammeDeJour(?string $programme_de_jour): self
    {
        $this->programme_de_jour = $programme_de_jour;

        return $this;
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->heure;
    }

    public function setHeure(?\DateTimeInterface $heure): self
    {
        $this->heure = $heure;

        return $this;
    }

    public function getNombreDePax(): ?int
    {
        return $this->nombre_de_pax;
    }

    public function setNombreDePax(?int $nombre_de_pax): self
    {
        $this->nombre_de_pax = $nombre_de_pax;

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

    public function getTransport(): ?Transport
    {
        return $this->transport;
    }

    public function setTransport(?Transport $transport): self
    {
        $this->transport = $transport;

        return $this;
    }

    public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }

    public function setRestaurant(?Restaurant $restaurant): self
    {
        $this->restaurant = $restaurant;

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
