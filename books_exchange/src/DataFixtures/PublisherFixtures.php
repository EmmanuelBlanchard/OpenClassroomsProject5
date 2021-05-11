<?php

namespace App\DataFixtures;

use App\Entity\Publisher;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PublisherFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $publisher = [
            1 => [
                'name' => 'Hachette'
            ],
            2 => [
                'name' => 'Seuil'
            ],
            3 => [
                'name' => 'Larousse'
            ],
            4 => [
                'name' => 'Gauthier-Villars, Bordas'
            ],
            5 => [
                'name' => 'Michelin'
            ],
            6 => [
                'name' => 'Gallimard'
            ],
            7 => [
                'name' => 'Flammarion, Arthaud'
            ],
            8 => [
                'name' => 'Nathan'
            ],
            9 => [
                'name' => 'Dunod, Ediscience, Masson'
            ],
            10 => [
                'name' => 'Éditions des services de l\'État'
            ],
            11 => [
                'name' => 'AFNOR'
            ],
            12 => [
                'name' => 'Presses Universitaires de France (PUF)'
            ],
            13 => [
                'name' => 'L\'Harmattan'
            ],
            14 => [
                'name' => 'Armand Colin'
            ],
            15 => [
                'name' => 'Éditeurs français réunis'
            ],
            16 => [
                'name' => 'Centre de documentation Sciences humaines du CNRS'
            ],
            17 => [
                'name' => 'Casterman'
            ],
            18 => [
                'name' => 'Cerf'
            ],
            19 => [
                'name' => 'Dargaud'
            ],
            20 => [
                'name' => 'Delagrave'
            ],
            21 => [
                'name' => 'Denoël'
            ],
            22 => [
                'name' => 'Didier'
            ],
            23 => [
                'name' => 'Messidor'
            ],
            24 => [
                'name' => 'Magnard'
            ],
            25 => [
                'name' => 'L\'École des loisirs'
            ],
            26 => [
                'name' => 'Eyrolles'
            ],
            27 => [
                'name' => 'Fayard'
            ],
            28 => [
                'name' => 'La Pensée universelle'
            ],
            29 => [
                'name' => 'Fleurus'
            ],
            30 => [
                'name' => 'Foucher'
            ],
            31 => [
                'name' => 'Gautier-Languereau'
            ],
            32 => [
                'name' => 'Hatier'
            ],
            33 => [
                'name' => 'Istra'
            ],
            34 => [
                'name' => 'Desclée de Brouwer'
            ],
            35 => [
                'name' => 'Robert Laffont, Fixot'
            ],
            36 => [
                'name' => 'CNRS périodiques'
            ],
            37 => [
                'name' => 'MDI'
            ],
            38 => [
                'name' => 'Éditions Vigot-Maloine'
            ],
            39 => [
                'name' => 'Elsevier Masson'
            ],
            40 => [
                'name' => 'Albin Michel'
            ],
            41 => [
                'name' => 'Bayard'
            ],
            42 => [
                'name' => 'Payot'
            ],
            43 => [
                'name' => 'STOCK'
            ],
            44 => [
                'name' => 'Grasset'
            ],
            45 => [
                'name' => 'Presses de la Cité'
            ],
            46 => [
                'name' => 'PLON'
            ],
            47 => [
                'name' => 'PERRIN'
            ],
            48 => [
                'name' => 'Solar'
            ],
            49 => [
                'name' => 'ARCHIMBAUD LE ROCHER'
            ],
            50 => [
                'name' => 'France Loisirs'
            ],
            51 => [
                'name' => 'Le Robert'
            ],
            52 => [
                'name' => 'Gründ'
            ],
            53 => [
                'name' => 'Actes Sud'
            ],
            54 => [
                'name' => 'Atlas, Glénat, Vent d\'Ouest'
            ],
            55 => [
                'name' => 'Éditions Spinelle'
            ],
            56 => [
                'name' => 'Lys Bleu'
            ],
            57 => [
                'name' => 'ARTHAUD'
            ],
            58 => [
                'name' => 'DIDIER & RICHARD'
            ],
            59 => [
                'name' => 'JC Lattès'
            ],
            60 => [
                'name' => 'Belfond'
            ],
            61 => [
                'name' => 'Mercure de France'
            ],
            62 => [
                'name' => 'Loisirs GALLIMARD'
            ],
            63 => [
                'name' => 'Michel Lafon'
            ],
            64 => [
                'name' => 'Succès du Livre'
            ],
            65 => [
                'name' => 'Éditions Féret'
            ],
            66 => [
                'name' => 'Baudelaire'
            ],
            67 => [
                'name' => 'Phébus'
            ],
            68 => [
                'name' => 'le Monde'
            ],
            69 => [
                'name' => 'Harper-Collins'
            ],
            70 => [
                'name' => 'Le Livre de Poche'
            ],
            71 => [
                'name' => 'Pocket'
            ],
            72 => [
                'name' => 'L` Iconoclaste'
            ],
            73 => [
                'name' => 'Les Editions du Rocher'
            ],
            74 => [
                'name' => 'Cyplog'
            ],
            75 => [
                'name' => 'Fleuve Editions'
            ],
            76 => [
                'name' => 'Le Cherche midi'
            ],
            77 => [
                'name' => 'Bamboo Edition'
            ],
            78 => [
                'name' => 'Charleston'
            ],
            79 => [
                'name' => 'Finitude'
            ],
        ];

        foreach ($publisher as $key => $value) {
            $publisher = new Publisher();
            $publisher->setName($value['name']);
            $manager->persist($publisher);
        }
        
        $manager->flush();
    }
}
