<?php

namespace App\Entity;

use App\Repository\QuestionnaireConfirmationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionnaireConfirmationRepository::class)]
class QuestionnaireConfirmation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $titre;

    #[ORM\OneToMany(mappedBy: 'questionnaireConfirmation', targetEntity: PAC::class)]
    private $pacs;

    public function __construct()
    {
        $this->pacs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * @return Collection<int, PAC>
     */
    public function getPacs(): Collection
    {
        return $this->pacs;
    }

    public function addPac(PAC $pac): self
    {
        if (!$this->pacs->contains($pac)) {
            $this->pacs[] = $pac;
            $pac->setQuestionnaireConfirmation($this);
        }

        return $this;
    }

    public function removePac(PAC $pac): self
    {
        if ($this->pacs->removeElement($pac)) {
            // set the owning side to null (unless already changed)
            if ($pac->getQuestionnaireConfirmation() === $this) {
                $pac->setQuestionnaireConfirmation(null);
            }
        }

        return $this;
    }
}
