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
                'name' => '11*18 - Poche'
            ],
            3 => [
                'name' => '12*18 - Manga'
            ],
            4 => [
                'name' => '13*18'
            ],
            5 => [
                'name' => '11*20 - Romantique'
            ],
            6 => [
                'name' => '13*20 - Grand Poche'
            ],
            7 => [
                'name' => '14*20  - Broché'
            ],
            8 => [
                'name' => '14.8*21 - A5'
            ],
            9 => [
                'name' => '15*22 - Grand Poche'
            ],
            10 => [
                'name' => '16*25 - Comic US'
            ],
            11 => [
                'name' => '18*26 - MDO'
            ],
            12 => [
                'name' => '21*29.7 - A4'
            ],
            13 => [
                'name' => '15*15 - Carré'
            ],
            14 => [
                'name' => '16*23 - '
            ],
            15 => [
                'name' => '16*24 - Royal'
            ],
            16 => [
                'name' => '21*21 - Grand Carré'
            ],
            17 => [
                'name' => '19*15 - Panoramique'
            ],
            18 => [
                'name' => '24*32 - BD'
            ],
            19 => [
                'name' => '29.7*21 - A4 Paysage'
            ],
            20 => [
                'name' => 'Autre'
            ],
        ];

        foreach ($format as $key => $value) {
            $format = new Format();
            $format->setName($value['name']);
            $manager->persist($format);
        }
        
        $manager->flush();
    }
}
