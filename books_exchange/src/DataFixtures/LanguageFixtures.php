<?php

namespace App\DataFixtures;

use App\Entity\Language;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class LanguageFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $language = [
            1 => [
                'name' => 'Anglais'
            ],
            2 => [
                'name' => 'Chinois mandarin'
            ],
            3 => [
                'name' => 'Hindi'
            ],
            4 => [
                'name' => 'Espagnol'
            ],
            5 => [
                'name' => 'Français'
            ],
            6 => [
                'name' => 'Arabe'
            ],
            7 => [
                'name' => 'Bengali'
            ],
            8 => [
                'name' => 'Russe'
            ],
            9 => [
                'name' => 'Portugais'
            ],
            10 => [
                'name' => 'Indonésien'
            ],
            11 => [
                'name' => 'Autre'
            ],
        ];

        foreach($language as $key => $value) {
            $language = new Language();
            $language->setName($value['name']);
            $manager->persist($language);
        }
        
        $manager->flush();
    }
}
