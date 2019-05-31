<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonRepository")
 * @ORM\Table(name="user__person")
 * @ORM\HasLifecycleCallbacks()
 */
class Person
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=191)
     * @Groups("read")
     */
    private $uuid;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="person", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="id_account", referencedColumnName="uuid", onDelete="CASCADE")
     */
    private $account;

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(?string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getAccount(): ?User
    {
        return $this->account;
    }

    public function setAccount(?User $account): self
    {
        $this->account = $account;

        return $this;
    }
}
