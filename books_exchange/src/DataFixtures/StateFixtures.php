<?php

namespace App\DataFixtures;

use App\Entity\State;
use App\DataFixtures\BaseFixture;
use Doctrine\Persistence\ObjectManager;

class StateFixtures extends BaseFixture
{
    private static $bookState = [
        'Neuf',
        'A l’état neuf/comme neuf',
        'Excellent état',
        'Très bon état',
        'Bon état',
        'Acceptable',
        'Autre',
    ];

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(State::class, 7, function (State $state, $count) use ($manager) {
            $state->setName($this->faker->randomElement(self::$bookState));
            
            $manager->persist($state);
        });

        $manager->flush();
    }
}
