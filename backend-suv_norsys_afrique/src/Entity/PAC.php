<?php

namespace App\Entity;

use App\Repository\PACRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PACRepository::class)]
class PAC
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("pac")]
    private $id;

    #[ORM\ManyToOne(targetEntity: Activite::class)]
    #[Groups("pac")]
    private $activite;

    #[ORM\ManyToMany(targetEntity: Utilisateur::class)]
    #[Groups("pac")]
    private $participants;

    #[ORM\ManyToOne(targetEntity: QuestionnaireConfirmation::class, inversedBy: 'pacs')]
    #[Groups("pac")]
    private $questionnaireConfirmation;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getQuestionnaireConfirmation(): ?QuestionnaireConfirmation
    {
        return $this->questionnaireConfirmation;
    }

    public function setQuestionnaireConfirmation(?QuestionnaireConfirmation $questionnaireConfirmation): self
    {
        $this->questionnaireConfirmation = $questionnaireConfirmation;

        return $this;
    }
}
