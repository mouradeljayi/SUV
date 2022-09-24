<?php

namespace App\Entity;

use App\Repository\ReservationTransportRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationTransportRepository::class)]
class ReservationTransport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $date;

    #[ORM\Column(type: 'string', length: 255)]
    private $lieuDepart;

    #[ORM\Column(type: 'string', length: 255)]
    private $destination;

    #[ORM\Column(type: 'integer')]
    private $nombrePax;

    #[ORM\ManyToOne(targetEntity: Transport::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $transport;

    #[ORM\ManyToOne(targetEntity: Evenement::class)]
    private $evenement;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLieuDepart(): ?string
    {
        return $this->lieuDepart;
    }

    public function setLieuDepart(string $lieuDepart): self
    {
        $this->lieuDepart = $lieuDepart;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getNombrePax(): ?int
    {
        return $this->nombrePax;
    }

    public function setNombrePax(int $nombrePax): self
    {
        $this->nombrePax = $nombrePax;

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
