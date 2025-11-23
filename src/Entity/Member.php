<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class Member implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(length: 180)]
    private ?string $email = null;
    
    /**
     * @var list<string>
     */
    #[ORM\Column]
    private array $roles = [];
    
    #[ORM\Column]
    private ?string $password = null;
    
    #[ORM\OneToOne(inversedBy: 'member', cascade: ['persist', 'remove'])]
    private ?CollectionVoitures $collectionVoitures = null;
    
    /**
     * @var Collection<int, Galerie>
     */
    #[ORM\OneToMany(targetEntity: Galerie::class, mappedBy: 'createur')]
    private Collection $galeries;
    
    public function __construct()
    {
        $this->galeries = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getEmail(): ?string
    {
        return $this->email;
    }
    
    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }
    
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }
    
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }
    
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }
    
    public function getPassword(): ?string
    {
        return $this->password;
    }
    
    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }
    
   
    public function eraseCredentials(): void
    {
        // Deprecated
    }
    
    public function getCollectionVoitures(): ?CollectionVoitures
    {
        return $this->collectionVoitures;
    }
    
    public function setCollectionVoitures(?CollectionVoitures $collectionVoitures): static
    {
        $this->collectionVoitures = $collectionVoitures;
        
        if ($collectionVoitures && $collectionVoitures->getMember() !== $this) {
            $collectionVoitures->setMember($this);
        }
        
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
            $galerie->setCreateur($this);
        }
        
        return $this;
    }
    
    public function removeGalerie(Galerie $galerie): static
    {
        if ($this->galeries->removeElement($galerie)) {
            if ($galerie->getCreateur() === $this) {
                $galerie->setCreateur(null);
            }
        }
        
        return $this;
    }
}
