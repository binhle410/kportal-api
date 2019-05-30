<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gesdinet\JWTRefreshTokenBundle\Entity\AbstractRefreshToken;
/**
 * This class override Gesdinet\JWTRefreshTokenBundle\Entity\RefreshToken to have another table name.
 * @ORM\Entity()
 * @ORM\Table("user__refresh_token")
 */
class RefreshToken extends AbstractRefreshToken
{
    /**
     * @var string The Universally Unique Id
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="App\Doctrine\Generator\RandomIdGenerator")
     * @ORM\Column(type="string", length=191)
     */
    protected $id;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        $this->id;
    }
}
