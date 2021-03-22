<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $category = [
            1 => [
                'name' => 'Art musique et cinéma'
            ],
            2 => [
                'name' => 'Bandes dessinées'
            ],
            3 => [
                'name' => 'Cuisine'
            ],
            4 => [
                'name' => 'Développement personnel'
            ],
            5 => [
                'name' => 'Dictionnaires & langues'
            ],
            6 => [
                'name' => 'Droit & économie'
            ],
            7 => [
                'name' => 'Essais et documents'
            ],
            8 => [
                'name' => 'Guides pratiques'
            ],
            9 => [
                'name' => 'Histoire'
            ],
            10 => [
                'name' => 'Humour'
            ],
            11 => [
                'name' => 'Informatique et internet'
            ],
            12 => [
                'name' => 'Jeunesse'
            ],
            13 => [
                'name' => 'Littérature'
            ],
            14 => [
                'name' => 'Littérature sentimentale'
            ],
            15 => [
                'name' => 'Policier, suspense, thrillers'
            ],
            16 => [
                'name' => 'Religion et spiritualité'
            ],
            17 => [
                'name' => 'Sciences sociales'
            ],
            18 => [
                'name' => 'Sciences, techniques & médecine'
            ],
            19 => [
                'name' => 'Scolaire'
            ],
            20 => [
                'name' => 'SF, Fantasy'
            ],
            21 => [
                'name' => 'Sport loisirs et vie pratique'
            ],
            22 => [
                'name' => 'Théâtre'
            ],
            23 => [
                'name' => 'Tourisme et voyages'
            ],
            24 => [
                'name' => 'Autre'
            ],
        ];

        foreach($category as $key => $value) {
            $category = new Category();
            $category->setName($value['name']);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
