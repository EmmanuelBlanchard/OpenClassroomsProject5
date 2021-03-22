<?php

namespace App\DataFixtures;

use App\Entity\Format;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class FormatFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $format = [
            1 => [
                'name' => '11*17 - Poche'
            ],
            2 => [
                'name' => '12*18 - Manga'
            ],
            3 => [
                'name' => '11*20 - Romantique'
            ],
            4 => [
                'name' => '14.8*21 - A5'
            ],
            5 => [
                'name' => '16*25 - Comic US'
            ],
            6 => [
                'name' => '18*26 - MDO'
            ],
            7 => [
                'name' => '21*29.7 - A4'
            ],
            8 => [
                'name' => '15*15 - Carré'
            ],
            9 => [
                'name' => '21*21 - Grand Carré'
            ],
            10 => [
                'name' => '19*15 - Panoramique'
            ],
            11 => [
                'name' => '29.7*21 - A4 Paysage'
            ],
            12 => [
                'name' => 'Autre'
            ],
        ];

        foreach($format as $key => $value) {
            $format = new Format();
            $format->setName($value['name']);
            $manager->persist($format);
        }
        
        $manager->flush();
    }
}
