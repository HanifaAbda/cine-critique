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
        $faker = Factory::create($this->lang);

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

        $realMovies = [
            [
                'title' => 'Inception',
                'poster' => 'https://posters.movieposterdb.com/10_06/2010/1375666/l_1375666_07030c72.jpg',
                'summary' => 'Dom Cobb peut s\'approprier les secrets d\'une personne à travers ses rêves, talent qui a fait de lui le fugitif le plus recherché au monde.
                    Une ultime mission pourrait lui rendre sa vie, et la femme qu\'il aime : non pas voler mais implanter une idée dans l\'esprit d\'un homme.',
                'releaseDate' => new \DateTime('2010-07-21'),
                'director' => 'Christopher Nolan',
                'mainActors' => 'Leonardo DiCaprio, Joseph Gordon-Levitt',
                'categories' => ['Science-fiction', 'Action'],
            ],
            [
                'title' => 'The Godfather',
                'poster' => 'https://posters.movieposterdb.com/22_07/1972/68646/l_68646_8c811dec.jpg',
                'summary' => 'Dans l\'Amérique des années 40, la famille Corleone règne sur la mafia new-yorkaise. Lorsque le patriarche Vito est attaqué, son fils Michael, 
                    jusque-là éloigné du crime, est forcé d\'entrer dans l\'engrenage mafieux. 
                    Il va peu à peu prendre le pouvoir, au prix de son humanité. Un drame familial sombre sur la loyauté, le pouvoir et la corruption.',
                'releaseDate' => new \DateTime('1972-03-24'),
                'director' => 'Francis Ford Coppola',
                'mainActors' => 'Marlon Brando, Al Pacino',
                'categories' => ['Drame', 'Crime'],
            ],
            [
                'title' => 'Pulp Fiction',
                'poster' => 'https://posters.movieposterdb.com/25_04/1994/110912/l_pulp-fiction-movie-poster_0ee5fd42.png',
                'summary' => 'À travers un récit non linéaire, le film entrelace les destins de truands, d’un boxeur en fuite et d’un couple de braqueurs en crise. 
                    Dialogues percutants et scènes cultes jalonnent cette fresque urbaine aux accents de comédie noire. Tarantino joue avec la narration pour créer un puzzle cinématographique. 
                    Une œuvre audacieuse qui a marqué le cinéma indépendant.',
                'releaseDate' => new \DateTime('1994-10-14'),
                'director' => 'Quentin Tarantino',
                'mainActors' => 'John Travolta, Uma Thurman',
                'categories' => ['Crime', 'Thriller'],
            ],
            [
                'title' => 'The Dark Knight',
                'poster' => 'https://posters.movieposterdb.com/25_04/2008/468569/l_the-dark-knight-movie-poster_0dea85fd.jpg',
                'summary' => 'Batman affronte un ennemi imprévisible et chaotique : le Joker, qui cherche à plonger Gotham dans l’anarchie. 
                    Tandis que l\'ordre public vacille, Bruce Wayne s\'interroge sur les limites de la justice et du sacrifice. Le film pousse le héros dans ses retranchements moraux. 
                    Un thriller sombre et intense, où le bien et le mal s\'entremêlent.',
                'releaseDate' => new \DateTime('2008-07-16'),
                'director' => 'Christopher Nolan',
                'mainActors' => 'Christian Bale, Heath Ledger',
                'categories' => ['Action', 'Drame'],
            ],
            [
                'title' => 'Forrest Gump',
                'poster' => 'https://posters.movieposterdb.com/12_04/1994/109830/l_109830_58524cd6.jpg',
                'summary' => 'Forrest, un homme au cœur pur mais à l\'esprit simple, traverse les grandes étapes de l\'histoire américaine sans jamais les chercher. 
                    De la guerre du Vietnam aux marches pour la paix, il devient un héros malgré lui. Sa vie est guidée par l\'amour qu’il porte à son amie d\'enfance, Jenny. 
                    Un conte émouvant sur la destinée et l\'innocence.',
                'releaseDate' => new \DateTime('1994-07-06'),
                'director' => 'Robert Zemeckis',
                'mainActors' => 'Tom Hanks, Robin Wright',
                'categories' => ['Drame', 'Comédie'],
            ],
            [
                'title' => 'The Matrix',
                'poster' => 'https://posters.movieposterdb.com/24_03/1999/133093/l_the-matrix-movie-poster_ae290db0.jpg',
                'summary' => 'Thomas Anderson, informaticien discret, découvre que le monde qu\'il connaît est une simulation créée par des machines. Sous le nom de Neo, il rejoint un groupe de résistants pour libérer l\'humanité. 
                    Entre philosophie, action et science-fiction, il doit choisir entre réalité et illusion. 
                    Un film culte qui a redéfini la SF au cinéma.',
                'releaseDate' => new \DateTime('1999-03-31'),
                'director' => 'Lana Wachowski, Lilly Wachowski',
                'mainActors' => 'Keanu Reeves, Laurence Fishburne',
                'categories' => ['Science-fiction', 'Action'],
            ],
            [
                'title' => 'Fight Club',
                'poster' => 'https://posters.movieposterdb.com/05_02/1999/0137523/l_7868_0137523_d46e33b9.jpg',
                'summary' => 'Un employé désabusé crée avec le charismatique Tyler Durden un club de combat pour évacuer sa rage contre la société de consommation. Ce qui commence comme un exutoire devient rapidement un mouvement anarchiste incontrôlable. 
                    Le film explore les thèmes de l\'identité, de la virilité et de la rébellion. Un classique provocateur et dérangeant.',
                'releaseDate' => new \DateTime('1999-10-15'),
                'director' => 'David Fincher',
                'mainActors' => 'Brad Pitt, Edward Norton',
                'categories' => ['Drame', 'Thriller'],
            ],
            [
                'title' => 'Interstellar',
                'poster' => 'https://posters.movieposterdb.com/14_09/2014/816692/l_816692_593eaeff.jpg',
                'summary' => 'Dans un futur où la Terre se meurt, un groupe d’astronautes voyage à travers un trou de ver pour trouver une planète habitable. Cooper, pilote et père de famille, laisse ses enfants derrière pour sauver l\'humanité. 
                    Entre physique quantique et émotion profonde, le film mêle science et amour. 
                    Une odyssée spatiale visuellement époustouflante.',
                'releaseDate' => new \DateTime('2014-11-05'),
                'director' => 'Christopher Nolan',
                'mainActors' => 'Matthew McConaughey, Anne Hathaway',
                'categories' => ['Science-fiction', 'Drame'],
            ],
            [
                'title' => 'Gladiator',
                'poster' => 'https://posters.movieposterdb.com/08_08/2000/172495/l_172495_2cce6a7c.jpg',
                'summary' => 'Maximus, général romain trahi par l\'empereur Commode, devient esclave puis gladiateur. 
                    Porté par la vengeance et le souvenir de sa famille assassinée, il grimpe les échelons de l\'arène jusqu\'au cœur de Rome. Sa quête est celle de la justice dans un monde corrompu. 
                    Une fresque épique sur l\'honneur et la rédemption.',
                'releaseDate' => new \DateTime('2000-05-05'),
                'director' => 'Ridley Scott',
                'mainActors' => 'Russell Crowe, Joaquin Phoenix',
                'categories' => ['Action', 'Drame'],
            ],
            [
                'title' => 'The Lion King',
                'poster' => 'https://posters.movieposterdb.com/22_11/1994/323073/l_the-lion-king-movie-poster_07016269.jpg',
                'summary' => 'Destiné à devenir roi, Simba doit fuir son royaume après la mort de son père, orchestrée par son oncle Scar. 
                    En exil, il grandit, apprend, et doit affronter son passé pour reprendre sa place légitime. 
                    À travers la savane africaine, il découvre les responsabilités du pouvoir. Un récit initiatique vibrant porté par une bande-son inoubliable.',
                'releaseDate' => new \DateTime('1994-06-24'),
                'director' => 'Roger Allers, Rob Minkoff',
                'mainActors' => 'Matthew Broderick, James Earl Jones',
                'categories' => ['Animation', 'Drame'],
            ],
            [
                'title' => 'Titanic',
                'poster' => 'https://posters.movieposterdb.com/12_06/1997/120338/l_120338_80e415d1.jpg',
                'summary' => 'À bord du Titanic, paquebot de légende, naît une histoire d\'amour entre Rose, jeune aristocrate promise à un mariage arrangé, et Jack, artiste sans le sou. Leur romance est interrompue par la tragédie du naufrage. Le film mêle destin, classe sociale et passion dans une reconstitution grandiose. 
                    Un drame romantique qui a marqué toute une génération.',
                'releaseDate' => new \DateTime('1997-12-19'),
                'director' => 'James Cameron',
                'mainActors' => 'Leonardo DiCaprio, Kate Winslet',
                'categories' => ['Drame', 'Romance'],
            ],
            [
                'title' => 'Avengers: Endgame',
                'poster' => 'https://posters.movieposterdb.com/20_05/2019/4154796/l_4154796_2542f70b.jpg',
                'summary' => 'Après que Thanos a anéanti la moitié de l\'univers, les Avengers survivants doivent unir leurs forces une dernière fois. 
                    Ils voyagent à travers le temps pour tenter d\'inverser l\'issue fatale. Le film conclut une saga de 22 films avec émotion, humour et action spectaculaire. 
                    Un adieu épique à plusieurs héros emblématiques.',
                'releaseDate' => new \DateTime('2019-04-24'),
                'director' => 'Anthony Russo, Joe Russo',
                'mainActors' => 'Robert Downey Jr., Chris Evans',
                'categories' => ['Action', 'Science-fiction'],
            ],
            [
                'title' => 'Toy Story',
                'poster' => 'https://posters.movieposterdb.com/05_06/1995/0114709/l_23697_0114709_d701c04a.jpg',
                'summary' => 'Quand Andy reçoit Buzz l\'Éclair, un jouet high-tech, son fidèle cow-boy Woody se sent menacé. 
                    S\'ensuit une rivalité pleine de péripéties, qui se transformera en amitié. 
                    Ensemble, ils devront faire face à de nombreux dangers pour retrouver leur place. Premier film d\'animation entièrement en images de synthèse, Toy Story a marqué un tournant historique.',
                'releaseDate' => new \DateTime('1995-11-22'),
                'director' => 'John Lasseter',
                'mainActors' => 'Tom Hanks, Tim Allen',
                'categories' => ['Animation', 'Comédie'],
            ],
            [
                'title' => 'Shrek',
                'poster' => 'https://posters.movieposterdb.com/11_12/2001/126029/l_126029_cee44e30.jpg',
                'summary' => 'Shrek, un ogre bourru et solitaire, voit son marais envahi par des créatures de contes de fées bannies par Lord Farquaad. 
                    Pour récupérer son territoire, il accepte de sauver la princesse Fiona. 
                    Ce qui commence comme une mission se transforme en une aventure drôle et inattendue. Une parodie brillante des contes traditionnels.',
                'releaseDate' => new \DateTime('2001-05-18'),
                'director' => 'Andrew Adamson, Vicky Jenson',
                'mainActors' => 'Mike Myers, Eddie Murphy',
                'categories' => ['Animation', 'Comédie'],
            ],
            [
                'title' => 'Back to the Future',
                'poster' => 'https://posters.movieposterdb.com/23_01/1989/2197817/l_back-to-the-future-movie-poster_c8254646.jpg',
                'summary' => 'Marty McFly voyage accidentellement en 1955 à bord d\'une voiture à voyager dans le temps créée par Doc Brown. 
                    Il doit s\'assurer que ses parents tombent amoureux pour garantir son existence. Mais chaque action dans le passé peut bouleverser l\'avenir. 
                    Une aventure culte pleine d\'humour et d\'inventions.',
                'releaseDate' => new \DateTime('1985-07-03'),
                'director' => 'Robert Zemeckis',
                'mainActors' => 'Michael J. Fox, Christopher Lloyd',
                'categories' => ['Science-fiction', 'Comédie'],
            ],
            [
                'title' => 'Jurassic Park',
                'poster' => 'https://posters.movieposterdb.com/05_08/1993/0107290/l_45298_0107290_be4e0db3.jpg',
                'summary' => 'Un milliardaire ouvre un parc peuplé de dinosaures recréés à partir d\'ADN fossile. 
                    Lors d\'une visite d\'inspection, un incident technique laisse les créatures s\'échapper. 
                    Les visiteurs doivent survivre dans un environnement redevenu sauvage. Le film allie suspense, science et effets spéciaux révolutionnaires.',
                'releaseDate' => new \DateTime('1993-06-11'),
                'director' => 'Steven Spielberg',
                'mainActors' => 'Sam Neill, Laura Dern',
                'categories' => ['Science-fiction', 'Action'],
            ],
            [
                'title' => 'The Silence of the Lambs',
                'poster' => 'https://posters.movieposterdb.com/21_02/1991/102926/l_102926_90bd926b.jpg',
                'summary' => 'Clarice Starling, jeune recrue du FBI, est chargée d\'interroger le Dr Hannibal Lecter, brillant psychiatre et tueur cannibale, pour traquer un autre serial killer. 
                    Entre fascination et manipulation, elle plonge dans l\'esprit du mal. 
                    Le film explore les limites de la psychologie criminelle. Un thriller glaçant devenu culte.',
                'releaseDate' => new \DateTime('1991-02-14'),
                'director' => 'Jonathan Demme',
                'mainActors' => 'Jodie Foster, Anthony Hopkins',
                'categories' => ['Thriller', 'Drame'],
            ],
            [
                'title' => 'The Social Network',
                'poster' => 'https://posters.movieposterdb.com/11_06/2010/1285016/l_1285016_6a84335f.jpg',
                'summary' => 'Mark Zuckerberg, étudiant brillant mais introverti, crée Facebook dans sa chambre d\'université. Son ascension fulgurante s\'accompagne de procès et de trahisons. Le film dépeint l\'ambition, la solitude et le prix du succès dans l\'ère numérique. 
                    Un portrait acéré de la naissance d\'un empire technologique.',
                'releaseDate' => new \DateTime('2010-10-01'),
                'director' => 'David Fincher',
                'mainActors' => 'Jesse Eisenberg, Andrew Garfield',
                'categories' => ['Drame'],
            ],
        ];

        $movies = [];
        foreach ($realMovies as $data) {

            $movie = new Movie();
            $movie->setTitle($data['title'])
                ->setPoster($data['poster'])
                ->setSummary($data['summary'])
                ->setReleaseDate($data['releaseDate'])
                ->setDirector($data['director'])
                ->setMainActors($data['mainActors'])
                ->setCreatedAt(new \DateTimeImmutable());


            foreach ($data['categories'] as $categoryName) {
                foreach ($categories as $cat) {
                    if ($cat->getName() === $categoryName) {
                        $movie->addCategory($cat);
                    }
                }
            }

            $manager->persist($movie);
            $movies[] = $movie;
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

        //admin user
        $admin = new User();
        $admin
            ->setEmail("admin@user.com")
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->hasher->hashPassword($user, 'admin'));

        $manager->persist($admin);
        $users[] = $admin;

        // --- REVIEWS ----------------------------------------------------------
        foreach ($movies as $movie) {
            for ($j = 0; $j < rand(2, 5); $j++) {
                $review = new Review();
                $review->setRating(rand(1, 5))
                    ->setContent($faker->realTextBetween(50, 300))
                    ->setCreatedAt(new \DateTimeImmutable())
                    ->setMovie($movie);

                $user = $users[array_rand($users)];
                $review->setAuthor($user);

                $manager->persist($review);
            }
        }

        // $product = new Product();
        // $manager->persist($product);
        $manager->flush();
    }
}
