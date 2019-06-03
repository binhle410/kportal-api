<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Util\AppUtil;
use App\Util\AwsS3Util;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use GuzzleHttp\Client;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\EntryRepository")
 * @ORM\Table(name="vocabulary__entry")
 * @ORM\HasLifecycleCallbacks()
 */
class Entry
{
    const REMOTE_ENDPOINT = 'ENDPOINT_DICT';
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=191)
     */
    private $uuid;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("read")
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PersonalEntry", mappedBy="entry")
     */
    private $personalEntries;

    private static $httpClient;

    public static function fetch($uuid, $token)
    {

        if (empty(self::$httpClient)) {
            self::$httpClient = new Client();
        }
        $response = self::$httpClient->get(getenv(self::REMOTE_ENDPOINT).'/entries/'.$uuid, [
            'accept' => ['application/ld+json'],
            'Authorization' => ['Bearer', $token,
            ]
        ]);

        $stdObj = json_decode($response->getBody()->getContents());
        $obj = new self();
        AppUtil::copyObjectScalarProperties($stdObj, $obj);

        return $obj;
    }

    public function __construct()
    {
        $this->personalEntries = new ArrayCollection();
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|PersonalEntry[]
     */
    public function getPersonalEntries(): Collection
    {
        return $this->personalEntries;
    }

    public function addPersonalEntry(PersonalEntry $personalEntry): self
    {
        if (!$this->personalEntries->contains($personalEntry)) {
            $this->personalEntries[] = $personalEntry;
            $personalEntry->setEntry($this);
        }

        return $this;
    }

    public function removePersonalEntry(PersonalEntry $personalEntry): self
    {
        if ($this->personalEntries->contains($personalEntry)) {
            $this->personalEntries->removeElement($personalEntry);
            // set the owning side to null (unless already changed)
            if ($personalEntry->getEntry() === $this) {
                $personalEntry->setEntry(null);
            }
        }

        return $this;
    }
}
