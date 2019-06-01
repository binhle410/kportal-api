<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\PersonalEntryRepository")
 * @ORM\Table(name="vocabulary__vocabulary")
 * @ORM\HasLifecycleCallbacks()
 */
class PersonalEntry
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="App\Doctrine\Generator\RandomIdGenerator")
     * @ORM\Column(type="string", length=191)
     * @Groups("read")
     */
    private $uuid;

    public function __construct()
    {
        $this->occurrences = new ArrayCollection();
    }


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Person", inversedBy="entries")
     * @ORM\JoinColumn(name="id_person", referencedColumnName="uuid", onDelete="CASCADE")
     * @Groups({"read","write"})
     */
    private $person;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Entry", inversedBy="personalEntries")
     * @ORM\JoinColumn(name="id_entry", referencedColumnName="uuid", onDelete="CASCADE")
     */
    private $entry;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Occurrence", mappedBy="entry")
     */
    private $occurrences;
    /**
     * @ORM\Column(type="integer", options={"default":0})
     * @Groups("read")
     */
    private $score;

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): self
    {
        $this->person = $person;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    /**
     * @return Collection|Occurrence[]
     */
    public function getOccurrences(): Collection
    {
        return $this->occurrences;
    }

    public function addOccurrence(Occurrence $occurrence): self
    {
        if (!$this->occurrences->contains($occurrence)) {
            $this->occurrences[] = $occurrence;
            $occurrence->setEntry($this);
        }

        return $this;
    }

    public function removeOccurrence(Occurrence $occurrence): self
    {
        if ($this->occurrences->contains($occurrence)) {
            $this->occurrences->removeElement($occurrence);
            // set the owning side to null (unless already changed)
            if ($occurrence->getEntry() === $this) {
                $occurrence->setEntry(null);
            }
        }

        return $this;
    }

    public function getEntry(): ?Entry
    {
        return $this->entry;
    }

    public function setEntry(?Entry $entry): self
    {
        $this->entry = $entry;

        return $this;
    }
}
