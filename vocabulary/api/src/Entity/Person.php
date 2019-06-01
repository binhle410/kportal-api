<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\PersonRepository")
 * @ORM\Table(name="vocabulary__person")
 * @ORM\HasLifecycleCallbacks()
 */
class Person
{

    public function __construct()
    {
        $this->entries = new ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=191)
     */
    private $uuid;

    /**
     * @ORM\OneToMany(targetEntity="PersonalEntry", mappedBy="person")
     */
    private $entries;

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @return Collection|PersonalEntry[]
     */
    public function getEntries(): Collection
    {
        return $this->entries;
    }

    public function addEntry(PersonalEntry $entry): self
    {
        if (!$this->entries->contains($entry)) {
            $this->entries[] = $entry;
            $entry->setPerson($this);
        }

        return $this;
    }

    public function removeEntry(PersonalEntry $entry): self
    {
        if ($this->entries->contains($entry)) {
            $this->entries->removeElement($entry);
            // set the owning side to null (unless already changed)
            if ($entry->getPerson() === $this) {
                $entry->setPerson(null);
            }
        }

        return $this;
    }

}
