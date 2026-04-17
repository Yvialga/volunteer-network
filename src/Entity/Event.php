<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'fk_events')]
    private ?Organization $fk_organization_id = null;

    #[ORM\OneToOne(mappedBy: 'fk_event_id', cascade: ['persist', 'remove'])]
    private ?Announcement $fk_announcement_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

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

    public function getFkOrganizationId(): ?Organization
    {
        return $this->fk_organization_id;
    }

    public function setFkOrganizationId(?Organization $fk_organization_id): static
    {
        $this->fk_organization_id = $fk_organization_id;

        return $this;
    }

    public function getFkAnnouncementId(): ?Announcement
    {
        return $this->fk_announcement_id;
    }

    public function setFkAnnouncementId(?Announcement $fk_announcement_id): static
    {
        // unset the owning side of the relation if necessary
        if ($fk_announcement_id === null && $this->fk_announcement_id !== null) {
            $this->fk_announcement_id->setFkEventId(null);
        }

        // set the owning side of the relation if necessary
        if ($fk_announcement_id !== null && $fk_announcement_id->getFkEventId() !== $this) {
            $fk_announcement_id->setFkEventId($this);
        }

        $this->fk_announcement_id = $fk_announcement_id;

        return $this;
    }
}
