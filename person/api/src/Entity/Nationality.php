<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NationalityRepository")
 * @ORM\Table(name="person__nationality")
 */
class Nationality
{
    /**
     * @var int|null The Event Id
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Person", inversedBy="nationalities")
     */
    private $person;

    public function getId(): ?int
    {
        return $this->id;
    }

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
