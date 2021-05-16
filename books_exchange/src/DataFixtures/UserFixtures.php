<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('user@user.com');
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'azerty'));
        $user->setIsVerified(true);
        $user->setLastname('User');
        $user->setFirstname('Toto');
        $user->setPseudo('TotoAzerty');
        $user->setZipCode(10000);
        $user->setCity('Bourg-en-Bresse');
        $manager->persist($user);

        $user2 = new User();
        $user2->setEmail('user2@user.com');
        $user2->setRoles(["ROLE_USER"]);
        $user2->setPassword($this->passwordEncoder->encodePassword($user2, 'Azertyazerty74!'));
        $user2->setIsVerified(true);
        $user2->setLastname('User');
        $user2->setFirstname('Toto2');
        $user2->setPseudo('Toto2Azerty');
        $user2->setZipCode(11000);
        $user2->setCity('Carcassonne');
        $manager->persist($user2);

        $user3 = new User();
        $user3->setEmail('admin@admin.com');
        $user3->setRoles(['ROLE_ADMIN']);
        $user3->setPassword($this->passwordEncoder->encodePassword($user3, 'AdminAzertyazerty74!'));
        $user3->setIsVerified(true);
        $user3->setLastname('Admin');
        $user3->setFirstname('Toto');
        $user3->setPseudo('AdminTotoAzerty');
        $user3->setZipCode(12000);
        $user3->setCity('Rodez');
        $manager->persist($user3);
    
        $manager->flush();
    }
}
