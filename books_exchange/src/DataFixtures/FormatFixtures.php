<?php

namespace App\DataFixtures;

use App\Entity\Format;
use App\DataFixtures\BaseFixture;
use Doctrine\Persistence\ObjectManager;

class FormatFixtures extends BaseFixture
{
    private static $bookFormat = [
        '11*17 - Poche',
        '11*18 - Poche',
        '12*18 - Manga',
        '13*18',
        '11*20 - Romantique',
        '13*20 - Grand Poche',
        '14*20  - Broché',
        '14.8*21 - A5',
        '15*15 - Carré',
        '15*22 - Grand Poche',
        '16*23',
        '16*24 - Royal',
        '19*15 - Panoramique',
        '21*21 - Grand Carré',
        '16*25 - Comic US',
        '18*26 - MDO',
        '21*29.7 - A4',
        '24*32 - BD',
        '29.7*21 - A4 Paysage',
        'Autre',
    ];

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Format::class, 20, function (Format $format, $count) use ($manager) {
            $format->setName($this->faker->randomElement(self::$bookFormat));
            
            $manager->persist($format);
        });

        $manager->flush();
    }
}
