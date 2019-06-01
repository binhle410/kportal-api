<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntryRepository")
 */
class Entry
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=191)
     */
    private $uuid;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PersonalEntry", mappedBy="entry")
     */
    private $personalEntries;

    public function __construct()
    {
        $this->personalEntries = new ArrayCollection();
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|PersonalEntry[]
     */
    public function getPersonalEntries(): Collection
    {
        return $this->personalEntries;
    }

    public function addPersonalEntry(PersonalEntry $personalEntry): self
    {
        if (!$this->personalEntries->contains($personalEntry)) {
            $this->personalEntries[] = $personalEntry;
            $personalEntry->setEntry($this);
        }

        return $this;
    }

    public function removePersonalEntry(PersonalEntry $personalEntry): self
    {
        if ($this->personalEntries->contains($personalEntry)) {
            $this->personalEntries->removeElement($personalEntry);
            // set the owning side to null (unless already changed)
            if ($personalEntry->getEntry() === $this) {
                $personalEntry->setEntry(null);
            }
        }

        return $this;
    }
}
