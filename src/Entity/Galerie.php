<?php

namespace App\Entity;

use App\Repository\GalerieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GalerieRepository::class)]
class Galerie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(length: 255)]
    private ?string $description = null;
    
    #[ORM\Column(type: 'boolean')]
    private bool $publiee = false;
    
    #[ORM\ManyToOne(inversedBy: 'galeries')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Member $createur = null;
    
    /**
     * @var Collection<int, Voiture>
     */
    #[ORM\ManyToMany(targetEntity: Voiture::class, inversedBy: 'galeries')]
    private Collection $voitures;
    
    public function __construct()
    {
        $this->voitures = new ArrayCollection();
    }
    
    // -------------------------
    // BASIC GETTERS/SETTERS
    // -------------------------
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getDescription(): ?string
    {
        return $this->description;
    }
    
    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }
    
    // -------------------------
    // BOOLEAN PUBLIEE
    // -------------------------
    
    public function isPubliee(): bool
    {
        return $this->publiee;
    }
    
    public function setPubliee(bool $publiee): static
    {
        $this->publiee = $publiee;
        return $this;
    }
    
    // -------------------------
    // CREATOR
    // -------------------------
    
    public function getCreateur(): ?Member
    {
        return $this->createur;
    }
    
    public function setCreateur(?Member $createur): static
    {
        $this->createur = $createur;
        return $this;
    }
    
    // -------------------------
    // VOITURES MANY-TO-MANY
    // -------------------------
    
    /**
     * @return Collection<int, Voiture>
     */
    public function getVoitures(): Collection
    {
        return $this->voitures;
    }
    
    public function addVoiture(Voiture $voiture): static
    {
        if (!$this->voitures->contains($voiture)) {
            $this->voitures->add($voiture);
        }
        return $this;
    }
    
    public function removeVoiture(Voiture $voiture): static
    {
        $this->voitures->removeElement($voiture);
        return $this;
    }
}
