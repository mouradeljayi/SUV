<?php

namespace App\Entity;

use App\Repository\ResultRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResultRepository::class)]
class Result
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    private $utilisateur;

    #[ORM\ManyToOne(targetEntity: Activite::class)]
    private $activite;

    #[ORM\ManyToOne(targetEntity: QuestionnaireActivites::class)]
    private $questionnaire;

    #[ORM\Column(type: 'boolean', nullable: true)]
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

    public function getActivite(): ?Activite
    {
        return $this->activite;
    }

    public function setActivite(?Activite $activite): self
    {
        $this->activite = $activite;

        return $this;
    }

    public function getQuestionnaire(): ?QuestionnaireActivites
    {
        return $this->questionnaire;
    }

    public function setQuestionnaire(?QuestionnaireActivites $questionnaire): self
    {
        $this->questionnaire = $questionnaire;

        return $this;
    }

    public function getVote(): ?bool
    {
        return $this->vote;
    }

    public function setVote(?bool $vote): self
    {
        $this->vote = $vote;

        return $this;
    }
}
