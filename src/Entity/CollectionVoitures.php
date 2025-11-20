<?php

namespace App\Entity;

use App\Repository\CollectionVoituresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CollectionVoituresRepository::class)]
class CollectionVoitures
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(length: 255)]
    private ?string $name = null;
    
    #[ORM\Column(type: 'text')]
    private ?string $description = null;
    
    #[ORM\Column]
    private ?int $yearCreated = null;
    
    #[ORM\OneToOne(mappedBy: 'collectionVoitures', cascade: ['persist', 'remove'])]
    private ?Member $member = null;
    
    #[ORM\OneToMany(targetEntity: Voiture::class, mappedBy: 'collectionvoitures')]
    private Collection $voitures;
    
    public function __construct()
    {
        $this->voitures = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getName(): ?string
    {
        return $this->name;
    }
    
    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
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
    
    public function getYearCreated(): ?int
    {
        return $this->yearCreated;
    }
    
    public function setYearCreated(int $yearCreated): static
    {
        $this->yearCreated = $yearCreated;
        return $this;
    }
    
    public function getMember(): ?Member
    {
        return $this->member;
    }
    
    public function setMember(?Member $member): static
    {
        $this->member = $member;
        return $this;
    }
    
    /**
     * @return Collection<int, Voiture>
     */
    public function getVoitures(): Collection
    {
        return $this->voitures;
    }
}
s