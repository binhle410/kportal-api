<?php

namespace App\DataFixtures;

use App\Entity\Person;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    const FIRST_USER = 'USER-5dd3c0ba00f40-103827042019';
    const FIRST_MEMBER = 'USER-5dd3c0ba00f40-103827042019';

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setIdNumber('U1-024290123');
//        $user->setUuid('USER-5dd3c0ba00f40-103827042019');
        $user->setEmail('user1@gmail.com');
        $user->setUsername('user1');
        $user->setPhone('0369140916');
        $user->setBirthDate(new \DateTime('04-10-1987'));
        $user->setRoles(['ROLE_USER',
        ]);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'p@ssword'
        ));

        $person = new Person();
        $person->setUuid('PERSON-20190531160418-821-5cf1508260e14');
        $person->setAccount($user);

        $manager->persist($user);
        $manager->persist($person);
        $manager->flush();
    }
}
