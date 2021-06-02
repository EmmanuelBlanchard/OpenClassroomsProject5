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
            $user->setRoles([$this->faker->randomElement(["ROLE_USER","ROLE_ADMIN"])]);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'engage'
            ));
            $user->setIsVerified(true);
            $user->setLastname($this->faker->lastName);
            $user->setFirstname($this->faker->firstName);
            $user->setPseudo($this->faker->bothify('??????_?????-##'));
            $user->setZipCode($this->faker->randomNumber(5, true));
            $user->setCity($this->faker->city());
            $user->agreeTerms();
            
            $manager->persist($user);
            
            return $user;
        });

        $manager->flush();
    }
}
