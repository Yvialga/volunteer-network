<?php

namespace App\Entity;

use App\Repository\OrganizationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: OrganizationRepository::class)]
class Organization
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    /**
     * @var Collection<int, Event>
     */
    #[ORM\OneToMany(targetEntity: Event::class, mappedBy: 'fk_organization_id')]
    private Collection $fk_events;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'fk_organization_id')]
    private Collection $fk_users;

    public function __construct()
    {
        $this->fk_events = new ArrayCollection();
        $this->fk_users = new ArrayCollection();
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): static
    {
        $this->created_at = new \DateTimeImmutable;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getFkEvents(): Collection
    {
        return $this->fk_events;
    }

    public function addFkEvent(Event $fkEvent): static
    {
        if (!$this->fk_events->contains($fkEvent)) {
            $this->fk_events->add($fkEvent);
            $fkEvent->setFkOrganizationId($this);
        }

        return $this;
    }

    public function removeFkEvent(Event $fkEvent): static
    {
        if ($this->fk_events->removeElement($fkEvent)) {
            // set the owning side to null (unless already changed)
            if ($fkEvent->getFkOrganizationId() === $this) {
                $fkEvent->setFkOrganizationId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getFkUsers(): Collection
    {
        return $this->fk_users;
    }

    public function addFkUser(User $fkUser): static
    {
        if (!$this->fk_users->contains($fkUser)) {
            $this->fk_users->add($fkUser);
            $fkUser->addFkOrganizationId($this);
        }

        return $this;
    }

    public function removeFkUser(User $fkUser): static
    {
        if ($this->fk_users->removeElement($fkUser)) {
            $fkUser->removeFkOrganizationId($this);
        }

        return $this;
    }
}
