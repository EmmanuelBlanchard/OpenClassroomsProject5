<?php

namespace App\DataFixtures;

use App\Entity\State;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class StateFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $state = [
            1 => [
                'name' => 'Neuf'
            ],
            2 => [
                'name' => 'A l’état neuf/comme neuf'
            ],
            3 => [
                'name' => 'Excellent état'
            ],
            4 => [
                'name' => 'Très bon état'
            ],
            5 => [
                'name' => 'Bon état'
            ],
            6 => [
                'name' => 'Acceptable'
            ],
            7 => [
                'name' => 'Autre'
            ],
        ];

        foreach($state as $key => $value) {
            $state = new State();
            $state->setName($value['name']);
            $manager->persist($state);
        }
        
        $manager->flush();
    }
}
