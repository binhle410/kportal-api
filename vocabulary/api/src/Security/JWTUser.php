<?php


namespace App\Security;


use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;

final class JWTUser extends \Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUser implements JWTUserInterface
{
    // Your own logic

    private $orgUuid;

    private $imUuid;

    private $personUuid;

    public function __construct($username, array $roles, $org, $im, $person)
    {
        parent::__construct($username, $roles);
        $this->orgUuid = $org;
        $this->imUuid = $im;
        $this->personUuid = $person;
    }

    public static function createFromPayload($username, array $payload)
    {
        return new self(
            $username,
            $payload['roles'], // Added by default
            $payload['org'],  // Custom
            $payload['im'], // Custom
            $payload['person']  // Custom
        );
    }

    /**
     * @return mixed
     */
    public function getOrgUuid()
    {
        return $this->orgUuid;
    }

    /**
     * @return mixed
     */
    public function getImUuid()
    {
        return $this->imUuid;
    }

    /**
     * @return mixed
     */
    public function getPersonUuid()
    {
        return $this->personUuid;
    }
}
