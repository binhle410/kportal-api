<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     attributes={"access_control"="is_granted('ROLE_USER')"},
 * )
 * @ORM\Entity(repositoryClass="App\Repository\NationalityRepository")
 * @ORM\Table(name="person__nationality")
 */
class Nationality
{
    public function __construct()
    {
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="App\Doctrine\Generator\RandomIdGenerator")
     * @ORM\Column(type="string", length=191)
     * @Groups("read")
     */
    private $uuid;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Person", inversedBy="nationalities")
     * @ORM\JoinColumn(name="id_person", referencedColumnName="uuid", onDelete="CASCADE")
     */
    private $person;

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nricNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $passportNumber;

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getNricNumber(): ?string
    {
        return $this->nricNumber;
    }

    public function setNricNumber(?string $nricNumber): self
    {
        $this->nricNumber = $nricNumber;

        return $this;
    }

    public function getPassportNumber(): ?string
    {
        return $this->passportNumber;
    }

    public function setPassportNumber(?string $passportNumber): self
    {
        $this->passportNumber = $passportNumber;

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
}
