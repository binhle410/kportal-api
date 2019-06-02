<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Util\AppUtil;
use App\Util\AwsS3Util;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 * @ApiFilter(SearchFilter::class,
 *     properties={
 *     "uuid": "exact",
 *     "title": "exact",
 *     "briefComment": "exact",
 *     "phoneticSymbols": "partial",
 *     "definition": "partial"
 * })
 * @ORM\Entity(repositoryClass="App\Repository\EntryRepository")
 * @ORM\Table(name="dictionary__entry")
 * @ORM\HasLifecycleCallbacks()
 */
class Entry
{
    const TYPE_VERB_INTRANSITIVE = 'INTRANSITIVE_VERB';

    public function __construct()
    {
        $this->examples = new ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="App\Doctrine\Generator\RandomIdGenerator")
     * @ORM\Column(type="string", length=191)
     * @Groups("read")
     */
    private $uuid;

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    /**
     * @Groups("read")
     *
     * @return mixed|string|null
     */
    public function getAudioReadUrl()
    {
        if (empty($this->audio)) {
            return null;
        }
        $path = $this->buildAudioPath();

        return AwsS3Util::getInstance()->getObjectReadUrl($path);
    }

    /**
     * @Groups("read")
     *
     * @return mixed|string|null
     */
    public function getAudioWriteUrl()
    {
        $path = $this->buildAudioPath();

        return AwsS3Util::getInstance()->getObjectWriteUrl($path);
    }

    private function buildAudioPath()
    {
        return strtolower(AppUtil::APP_NAME).'/audio/'.$this->uuid.'-'.$this->audio;
    }

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToMany(targetEntity="App\Entity\Example", inversedBy="entries")
     * @ORM\JoinTable(name="dictionary__entries_examples",
     *      joinColumns={@ORM\JoinColumn(name="id_entry", referencedColumnName="uuid")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_example", referencedColumnName="uuid")}
     * )
     */
    private $examples;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=5)
     */
    private $locale;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $type;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=500)
     */
    private $definition;

    /**
     * Groups({"read", "write"})
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

    public function setType(?string $type): self
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
