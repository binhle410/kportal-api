<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\OccurrenceRepository")
 * @ORM\Table(name="vocabulary__occurrence")
 * @ORM\HasLifecycleCallbacks()
 */
class Occurrence
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="App\Doctrine\Generator\RandomIdGenerator")
     * @ORM\Column(type="string", length=191)
     * @Groups("read")
     */
    private $uuid;

    /**
     * @ORM\ManyToOne(targetEntity="PersonalEntry", inversedBy="occurrences")
     * @ORM\JoinColumn(name="id_entry_personal", referencedColumnName="uuid", onDelete="CASCADE")
     */
    private $entry;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $text;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function getEntry(): ?PersonalEntry
    {
        return $this->entry;
    }

    public function setEntry(?PersonalEntry $entry): self
    {
        $this->entry = $entry;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
