<?php

namespace App\Entity;

use App\Repository\FinalResultRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FinalResultRepository::class)]
class FinalResult
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("finalresult")]
    private $id;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[Groups("finalresult")]
    private $utilisateur;

    #[ORM\ManyToOne(targetEntity: PAC::class)]
    #[Groups("finalresult")]
    private $pac;

    #[ORM\Column(type: 'boolean')]
    #[Groups("finalresult")]
    private $vote;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPac(): ?PAC
    {
        return $this->pac;
    }

    public function setPac(?PAC $pac): self
    {
        $this->pac = $pac;

        return $this;
    }

    public function getVote(): ?bool
    {
        return $this->vote;
    }

    public function setVote(bool $vote): self
    {
        $this->vote = $vote;

        return $this;
    }
}
