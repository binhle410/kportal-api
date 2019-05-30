<?php

namespace App\DataFixtures;

use App\Entity\IndividualMember;
use App\Entity\Organisation;
use App\Entity\OrganisationUser;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class OrganisationFixtures extends Fixture implements DependentFixtureInterface
{
    private $passwordEncoder;

    const FIRST_ORG = 'ORG-5dd3c0ba00f40-103827042019';
    const FIRST_MEMBER_STRING = 'ORG_IM_1_1-5dd3c0ba00f40-103827042019';

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $org = new Organisation();
        $org->setCode('magenta');
        $org->setUuid(self::FIRST_ORG);
        $manager->persist($org);
        $manager->flush();

        $ou = new IndividualMember();
        $org->addIndividualMember($ou);

        $userRepo = $manager->getRepository(User::class);
        $user = $userRepo->findOneBy(['email' => 'user1@gmail.com',
        ]);

        $user->addIndividualMember($ou);
        $org->addIndividualMember($ou);

        $ou->setUuid(sprintf(self::FIRST_MEMBER_STRING, $org->getUuid(), $user->getUuid()));


        $manager->persist($user);
        $manager->persist($ou);

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}
