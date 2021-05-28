<?php

namespace App\DataFixtures;

use App\Entity\Language;
use App\DataFixtures\BaseFixture;
use Doctrine\Persistence\ObjectManager;

class LanguageFixtures extends BaseFixture
{
    private static $bookLanguage = [
        'Anglais',
        'Chinois mandarin',
        'Hindi',
        'Espagnol',
        'Français',
        'Arabe',
        'Bengali',
        'Russe',
        'Portugais',
        'Indonésien',
        'Autre',
    ];

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Language::class, 11, function (Language $language, $count) use ($manager) {
            $language->setName($this->faker->randomElement(self::$bookLanguage));
            
            $manager->persist($language);
        });

        $manager->flush();
    }
}
