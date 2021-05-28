<?php

namespace App\DataFixtures;

use App\Entity\Publisher;
use App\DataFixtures\BaseFixture;
use Doctrine\Persistence\ObjectManager;

class PublisherFixtures extends BaseFixture
{
    private static $bookPublisher = [
        'Hachette',
        'Seuil',
        'Larousse',
        'Gauthier-Villars, Bordas',
        'Michelin',
        'Gallimard',
        'Flammarion, Arthaud',
        'Nathan',
        'Dunod, Ediscience, Masson',
        'Éditions des services de l\'État',
        'AFNOR',
        'Presses Universitaires de France (PUF)',
        'L\'Harmattan',
        'Armand Colin',
        'Éditeurs français réunis',
        'Centre de documentation Sciences humaines du CNRS',
        'Casterman',
        'Cerf',
        'Dargaud',
        'Delagrave',
        'Denoël',
        'Didier',
        'Messidor',
        'Magnard',
        'L\'École des loisirs',
        'Eyrolles',
        'Fayard',
        'La Pensée universelle',
        'Fleurus',
        'Foucher',
        'Gautier-Languereau',
        'Hatier',
        'Istra',
        'Desclée de Brouwer',
        'Robert Laffont, Fixot',
        'CNRS périodiques',
        'MDI',
        'Éditions Vigot-Maloine',
        'Elsevier Masson',
        'Albin Michel',
        'Bayard',
        'Payot',
        'STOCK',
        'Grasset',
        'Presses de la Cité',
        'PLON',
        'PERRIN',
        'Solar',
        'ARCHIMBAUD LE ROCHER',
        'France Loisirs',
        'Le Robert',
        'Gründ',
        'Actes Sud',
        'Atlas, Glénat, Vent d\'Ouest',
        'Éditions Spinelle',
        'Lys Bleu',
        'ARTHAUD',
        'DIDIER & RICHARD',
        'JC Lattès',
        'Belfond',
        'Mercure de France',
        'Loisirs GALLIMARD',
        'Michel Lafon',
        'Succès du Livre',
        'Éditions Féret',
        'Baudelaire',
        'Phébus',
        'Le Monde',
        'Harper-Collins',
        'Le Livre de Poche',
        'Pocket',
        'L` Iconoclaste',
        'Les Editions du Rocher',
        'Cyplog',
        'Fleuve Editions',
        'Le Cherche midi',
        'Bamboo Edition',
        'Charleston',
        'Finitude',
        'Autre',
    ];

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Publisher::class, 79, function (Publisher $publisher, $count) use ($manager) {
            $publisher->setName($this->faker->randomElement(self::$bookPublisher));
            
            $manager->persist($publisher);
        });

        $manager->flush();
    }
}
