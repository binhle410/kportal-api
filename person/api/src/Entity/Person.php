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
 *     attributes={"access_control"="is_granted('ROLE_USER')"},
 * )
 * @ORM\Entity(repositoryClass="App\Repository\PersonRepository")
 * @ORM\Table(name="person__person")
 * @ORM\HasLifecycleCallbacks()
 */
class Person
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="App\Doctrine\Generator\RandomIdGenerator")
     * @ORM\Column(type="string", length=191)
     * @Groups("read")
     */
    private $uuid;

    const GENDER_MALE = 'MALE';

    const GENDER_FEMALE = 'FEMALE';

    public function getNationality()
    {
        return $this->nationalities->first();
    }

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Nationality", mappedBy="person")
     */
    private $nationalities;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $birthDate;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $givenName;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $familyName;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $phoneNumber;


    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $middleName;

    public function __construct()
    {
        $this->nationalities = new ArrayCollection();
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getGivenName(): ?string
    {
        return $this->givenName;
    }

    public function setGivenName(string $givenName): self
    {
        $this->givenName = $givenName;

        return $this;
    }

    public function getFamilyName(): ?string
    {
        return $this->familyName;
    }

    public function setFamilyName(?string $familyName): self
    {
        $this->familyName = $familyName;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return Collection|Nationality[]
     */
    public function getNationalities(): Collection
    {
        return $this->nationalities;
    }

    public function addNationality(Nationality $nationality): self
    {
        if (!$this->nationalities->contains($nationality)) {
            $this->nationalities[] = $nationality;
            $nationality->setPerson($this);
        }

        return $this;
    }

    public function removeNationality(Nationality $nationality): self
    {
        if ($this->nationalities->contains($nationality)) {
            $this->nationalities->removeElement($nationality);
            // set the owning side to null (unless already changed)
            if ($nationality->getPerson() === $this) {
                $nationality->setPerson(null);
            }
        }

        return $this;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function setMiddleName(?string $middleName): self
    {
        $this->middleName = $middleName;

        return $this;
    }
}
