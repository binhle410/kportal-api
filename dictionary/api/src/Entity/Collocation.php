<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Util\AppUtil;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\CollocationRepository")
 * @ORM\Table(name="dictionary__collocation")
 * @ORM\HasLifecycleCallbacks()
 */
class Collocation
{

    public function __construct()
    {
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
     * @Groups("read")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="App\Doctrine\Generator\RandomIdGenerator")
     * @ORM\Column(type="string", length=191)
     */
    private $uuid;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $type;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     */
    private $text;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }
}
