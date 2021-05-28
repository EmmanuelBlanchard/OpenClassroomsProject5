<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\DataFixtures\BaseFixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends BaseFixture
{
    private static $bookCategory = [
        'Art musique et cinéma',
        'Bandes dessinées',
        'Développement personnel',
        'Dictionnaires & langues',
        'Droit & économie',
        'Essais et documents',
        'Guides pratiques',
        'Histoire',
        'Humour',
        'Informatique et internet',
        'Jeunesse',
        'Littérature',
        'Littérature sentimentale',
        'Policier, suspense, thrillers',
        'Religion et spiritualité',
        'Sciences sociales',
        'Sciences, techniques & médecine',
        'Scolaire',
        'SF, Fantasy',
        'Sport loisirs et vie pratique',
        'Théâtre',
        'Tourisme et voyages',
        'Autre',
    ];

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Category::class, 22, function (Category $category, $count) use ($manager) {
            $category->setName($this->faker->randomElement(self::$bookCategory));
            
            $manager->persist($category);
        });

        $manager->flush();
    }
}
