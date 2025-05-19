<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Movie;
use App\Entity\Review;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private const NB_MOVIES = 40;
    private const NB_USERS = 5;
    private const CATEGORY_NAMES = ['Action', 'Comédie', 'Drame', 'Science-fiction', 'Animation'];

    public function __construct(
        private UserPasswordHasherInterface $hasher,
        private string $lang
    ) {
    }


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
                $review->setRating(rand(1, 5))
                       ->setContent($faker->realTextBetween(50, 300))
                       ->setCreatedAt(new \DateTimeImmutable())
                       ->setMovie($movie);

                       $manager->persist($review);
            }

        }

        // --- USERS ----------------------------------------------------------------
        $users = [];

        for ($i = 0; $i < self::NB_USERS; $i++) {
            $user = new User();
            $user
                ->setEmail("regular$i@user.com")
                ->setPassword($this->hasher->hashPassword($user, 'test'));

            $manager->persist($user);

            $users[] = $user;
        }

        $admin = new User();
        $admin
            ->setEmail("admin@user.com")
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->hasher->hashPassword($user, 'admin'));

        $manager->persist($admin);
        $users[] = $admin;

        // $product = new Product();
        // $manager->persist($product);
        $manager->flush();
    }
}
