<?php

namespace App\Entity;

use App\Repository\TAFRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TAFRepository::class)]
class TAF
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("taf")]
    private $id;

    #[ORM\ManyToOne(targetEntity: PAC::class)]
    #[Groups("taf")]
    private $pac;

    #[ORM\ManyToMany(targetEntity: Utilisateur::class)]
    #[Groups("taf")]
    private $participants;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPac(): ?PAC
    {
        return $this->pac;
    }

    public function setPac(?PAC $pac): self
    {
        $this->pac = $pac;

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Utilisateur $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
        }

        return $this;
    }

    public function removeParticipant(Utilisateur $participant): self
    {
        $this->participants->removeElement($participant);

        return $this;
    }
}
