<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Util\AppUtil;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\EntryRepository")
 * @ORM\Table(name="dictionary__entry")
 * @ORM\HasLifecycleCallbacks()
 */
class Entry
{
    /**
     * @var int|null
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    public function __construct()
    {
        $this->examples = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     */
    public function initiateUuid()
    {
        if (empty($this->uuid)) {
            $this->uuid = AppUtil::generateUuid();
        }
    }

    /**
     * @ORM\Column(type="string", length=191)
     * @Groups("read")
     */
    private $uuid;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=5)
     */
    private $locale;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=40)
     */
    private $type;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=500)
     */
    private $definition;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $audio;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phoneticSymbols;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $briefComment;

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToMany(targetEntity="App\Entity\Example", inversedBy="entries")
     * @ORM\JoinTable(name="dictionary__entries_examples",
     *      joinColumns={@ORM\JoinColumn(name="id_entry", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_example", referencedColumnName="id")}
     * )
     */
    private $examples;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDefinition(): ?string
    {
        return $this->definition;
    }

    public function setDefinition(string $definition): self
    {
        $this->definition = $definition;

        return $this;
    }

    public function getAudio(): ?string
    {
        return $this->audio;
    }

    public function setAudio(?string $audio): self
    {
        $this->audio = $audio;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPhoneticSymbols(): ?string
    {
        return $this->phoneticSymbols;
    }

    public function setPhoneticSymbols(?string $phoneticSymbols): self
    {
        $this->phoneticSymbols = $phoneticSymbols;

        return $this;
    }

    public function getBriefComment(): ?string
    {
        return $this->briefComment;
    }

    public function setBriefComment(?string $briefComment): self
    {
        $this->briefComment = $briefComment;

        return $this;
    }

    /**
     * @return Collection|Example[]
     */
    public function getExamples(): Collection
    {
        return $this->examples;
    }

    public function addExample(Example $example): self
    {
        if (!$this->examples->contains($example)) {
            $this->examples[] = $example;
        }

        return $this;
    }

    public function removeExample(Example $example): self
    {
        if ($this->examples->contains($example)) {
            $this->examples->removeElement($example);
        }

        return $this;
    }
}
