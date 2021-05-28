<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\User;
use App\Entity\State;
use App\Entity\Author;
use App\Entity\Format;
use App\Entity\Category;
use App\Entity\Language;
use App\Entity\Publisher;
use App\Service\UploaderHelper;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class BookFixtures extends BaseFixture implements DependentFixtureInterface
{
    private static $bookImages = [
        'asteroid.jpeg',
        'mercury.jpeg',
        'lightspeed.png',
    ];

    private $uploaderHelper;
    
    public function __construct(UploaderHelper $uploaderHelper)
    {
        $this->uploaderHelper = $uploaderHelper;
    }

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Book::class, 100, function (Book $book) {
            $book->setTitle($this->faker->realText(50));
            $book->setActive(true);
            $book->setUser($this->getRandomReference(User::class));
            $book->setCategory($this->getRandomReference(Category::class));
            $book->setPublisher($this->getRandomReference(Publisher::class));
            $book->setLanguage($this->getRandomReference(Language::class));
            $book->setFormat($this->getRandomReference(Format::class));
            $book->setState($this->getRandomReference(State::class));
            $book->setAuthor($this->getRandomReference(Author::class));
            $book->setSummary(
                $this->faker->boolean ? $this->faker->paragraph : $this->faker->sentences(5, true)
            );
            $book->setExchangeRequest(false);
            //$book->setExchangeRequest($this->faker->boolean(70));
            $book->setUserexchange($this->getRandomReference(User::class));
            $randomImage = $this->faker->randomElement(self::$bookImages);
            $imageFilename = $this->uploaderHelper
                ->uploadBookImage(new File(__DIR__.'/images/'.$randomImage));
            $book->setImageFilename($imageFilename);
        });
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            CategoryFixtures::class,
            PublisherFixtures::class,
            LanguageFixtures::class,
            FormatFixtures::class,
            StateFixtures::class,
            AuthorFixtures::class,
        ];
    }
}
