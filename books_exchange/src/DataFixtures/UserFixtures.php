<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = [
            1 => [
                'email' => 'toto@mail.com',
                'roles' => [],
                'password' => '$argon2id$v=19$m=65536,t=4,p=1$bWVPVEgwL0NiUWZld0R6Yw$boOhIphm0zvo6IiS6wuyHkS53yphRwdr7dYzWFaeryM',
                'is_verified' => '1',
                'lastname' => 'Ro',
                'firstname' => 'toto',
                'pseudo' => 'Toto',
                'zip_code' => '10000',
                'city' => 'Bourg-en-Bresse'
            ],
            2 => [
                'email' => 'totoro@mail.com',
                'roles' => [],
                'password' => '$argon2id$v=19$m=65536,t=4,p=1$QkExZEFwUm92LkdlYzI3NQ$xMUTkTGJR4LBpb+MdhROdDDZsj5bxPXHbSfkGTPrX74',
                'is_verified' => '1',
                'lastname' => 'Ri',
                'firstname' => 'tito',
                'pseudo' => 'Tit0',
                'zip_code' => '10000',
                'city' => 'Bourg-en-Bresse'
            ],
        ];

        foreach($user as $key => $value) {
            $user = new User();
            $user->setEmail($value['email']);
            $user->setRoles($value['roles']);
            $user->setPassword($value['password']);
            $user->setIsVerified($value['is_verified']);
            $user->setLastname($value['lastname']);
            $user->setFirstname($value['firstname']);
            $user->setPseudo($value['pseudo']);
            $user->setZipCode($value['zip_code']);
            $user->setCity($value['city']);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
