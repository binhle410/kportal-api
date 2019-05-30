<?php

namespace App\Entity;

use App\Util\AppUtil;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="user__organisation")
 * @ORM\HasLifecycleCallbacks()
 */
class Organisation
{


    /** @return User */
    public function findUserByAccessToken($accessToken){
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('accessToken',$accessToken))
//            ->orderBy(array('username' => Criteria::ASC))
            ->setFirstResult(0)
            ->setMaxResults(1);

        /** @var IndividualMember $ou */
        if(empty($ou = $this->individualMembers->matching($criteria)->first())){
            return null;
        }
        return $ou->getUser();
    }

    public function __construct()
    {
        $this->individualMembers = new ArrayCollection();
    }

    /**
     * @var string The Universally Unique Id
     * @ORM\Id
     * @ORM\Column(type="string", length=191)
     * @Groups("read")
     */
    private $uuid;

    /**
     * @var string code|null
     * @ORM\Column(type="string",nullable=true)
     * @Assert\NotBlank()
     */
    private $code;

    /**
     * @ORM\OneToMany(
     *     targetEntity="IndividualMember",
     *     mappedBy="organisation", cascade={"persist"}, orphanRemoval=true
     * )
     *
     * @var \Doctrine\Common\Collections\Collection ;
     */
    private $individualMembers;

    public function addIndividualMember(IndividualMember $orgUser)
    {
        $this->individualMembers->add($orgUser);
        $orgUser->setOrganisation($this);
    }

    public function removeIndividualMember(IndividualMember $orgUser)
    {
        $this->individualMembers->removeElement($orgUser);
        $orgUser->setOrganisation(null);
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIndividualMembers(): \Doctrine\Common\Collections\Collection
    {
        return $this->individualMembers;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $individualMembers
     */
    public function setIndividualMembers(\Doctrine\Common\Collections\Collection $individualMembers): void
    {
        $this->individualMembers = $individualMembers;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     */
    public function setCode(?string $code): void
    {
        $this->code = $code;
    }
}
