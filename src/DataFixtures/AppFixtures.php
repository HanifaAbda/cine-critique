<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Movie;
use App\Entity\Review;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private const CATEGORY_NAMES = ['Action', 'Comédie', 'Drame', 'Science-fiction', 'Animation'];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // --- CATEGORIES -----------------------------------------------------
        $categories = [];

        foreach (self::CATEGORY_NAMES as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $category->setSlug($categoryName);
            $manager->persist($category);
            $categories[] = $category;    
        }

        // --- MOVIES ----------------------------------------------------------
        $movies = [];
        for ($i = 0; $i < 10; $i++) {
            $movie = new Movie();
            $movie->setTitle($faker->sentence(3))
                  ->setPoster('poster' . $i . '.jpg')
                  ->setSummary($faker->realTextBetween(400,750))
                  ->setReleaseDate($faker->dateTimeBetween('-10years', 'now'))
                  ->setDirector($faker->name())
                  ->setMainActors($faker->name() . ',' . $faker->name())
                  ->setCreatedAt(new \DateTimeImmutable());

            $randomCategories = $faker->randomElements($categories, rand(1, 3));
            foreach  ($randomCategories as $cat) {
                $movie->addCategory($cat);
            }

            $manager->persist($movie);
            $movies[] = $movie;
        }

        // --- REVIEWS ----------------------------------------------------------
        foreach ($movies as $movie) {
            for ($j = 0; $j < rand(2, 5); $j++) {
                $review = new Review();
                $review->setRatings(rand(1, 5))
                       ->setContent($faker->realTextBetween(50, 300))
                       ->setCreatedAt(new \DateTimeImmutable())
                       ->setMovie($movie);

                       $manager->persist($review);
            }

        }
        
        // $product = new Product();
        // $manager->persist($product);
        $manager->flush();
    }
}
