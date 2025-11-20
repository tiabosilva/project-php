<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(length: 255)]
    private ?string $modele = null;
    
    #[ORM\Column(length: 255)]
    private ?string $marque = null;
    
    #[ORM\Column(length: 255)]
    private ?string $annee = null;
    
    #[ORM\ManyToOne(inversedBy: 'voitures')]
    private ?CollectionVoitures $collectionVoitures = null;
    
    /**
     * @var Collection<int, Galerie>
     */
    #[ORM\ManyToMany(targetEntity: Galerie::class, mappedBy: 'voitures')]
    private Collection $galeries;
    
    public function __construct()
    {
        $this->galeries = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getModele(): ?string
    {
        return $this->modele;
    }
    
    public function setModele(string $modele): static
    {
        $this->modele = $modele;
        return $this;
    }
    
    public function getMarque(): ?string
    {
        return $this->marque;
    }
    
    public function setMarque(string $marque): static
    {
        $this->marque = $marque;
        return $this;
    }
    
    public function getAnnee(): ?string
    {
        return $this->annee;
    }
    
    public function setAnnee(string $annee): static
    {
        $this->annee = $annee;
        return $this;
    }
    
    public function getCollectionVoitures(): ?CollectionVoitures
    {
        return $this->collectionVoitures;
    }
    
    public function setCollectionVoitures(?CollectionVoitures $collectionVoitures): static
    {
        $this->collectionVoitures = $collectionVoitures;
        return $this;
    }
    
    /**
     * @return Collection<int, Galerie>
     */
    public function getGaleries(): Collection
    {
        return $this->galeries;
    }
    
    public function addGalerie(Galerie $galerie): static
    {
        if (!$this->galeries->contains($galerie)) {
            $this->galeries->add($galerie);
            $galerie->addVoiture($this);
        }
        
        return $this;
    }
    
    public function removeGalerie(Galerie $galerie): static
    {
        if ($this->galeries->removeElement($galerie)) {
            $galerie->removeVoiture($this);
        }
        
        return $this;
    }
}
