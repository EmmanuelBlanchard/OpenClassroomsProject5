<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\DataFixtures\BaseFixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends BaseFixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(User::class, 10, function (User $user, $count) use ($manager) {
            $user->setEmail($this->faker->email);
            $user->setRoles(["ROLE_USER"]);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'engage'
            ));
            $user->setIsVerified(true);
            $user->setLastname($this->faker->lastName);
            $user->setFirstname($this->faker->firstName);
            $user->setPseudo($this->faker->name);
            $user->setZipCode($this->faker->randomNumber(5, true));
            $user->setCity($this->faker->city());
            $user->agreeTerms();
            
            $manager->persist($user);
            
            return $user;
        });
        
        $this->createMany(User::class, 3, function (User $user, $count) use ($manager) {
            $user->setEmail($this->faker->email);
            $user->setRoles(["ROLE_ADMIN"]);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'azertyAzerty74!'
            ));
            $user->setIsVerified(true);
            $user->setLastname($this->faker->lastName);
            $user->setFirstname($this->faker->firstName);
            $user->setPseudo($this->faker->name);
            $user->setZipCode($this->faker->randomNumber(5, true));
            $user->setCity($this->faker->city());
            $user->agreeTerms();
            
            $manager->persist($user);
            
            return $user;
        });
        
        $manager->flush();
    }
}
