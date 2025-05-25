# Cine Critique

## Présentation du projet
CineCritique est une application web développée avec Symfony qui permet de consulter une liste de films, de les filtrer par titre et catégorie, et de consulter les détails de chaque film.


### Fonctionnalités
- Affichage de la liste des film
- Recherche de films par titre
- Notation des films et affichage des notes moyennes
- Consultation des détails d’un film
- Gestion des avis par les utilisateurs connectés
- Système d'authentification (inscription, connexion, déconnexion)
- Gestion des utilisateurs (EasyAdmin)


### Installation et configuration
- Création du nouveau projet Symfony :

        symfony new cine_critique --version=6.4 --webapp

- Configuration de la base de données :

     DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306app?serverVersion=8&charset=utf8mb4"

- Création de la base de données :

        php bin/console doctrine:database:create

- Installation de Twig, Doctrine, et autres bundles nécessaires (via composer)

        composer install

### Développement des fonctionnalités principales
- Affichage de la liste des films
    
    Création d’un contrôleur IndexController avec une méthode index() affichant tous les films.

    Utilisation de Twig pour créer la vue index/home.html.twig affichant les films.

- Barre de recherche dans la navigation
    
    Ajout d’une barre de recherche dans la barre de navigation (nav.html.twig).

    Le formulaire envoie la requête query en méthode GET à la page d’accueil.

    Dans le contrôleur, récupération du paramètre query pour filtrer les films.

- Recherche par titre (et par catégorie - optionnel)
    Ajout dans MovieRepository d’une méthode findByTitle() ou findByTitleAndCategory() pour filtrer les films selon les critères de recherche.

    Mise à jour du contrôleur pour appeler cette méthode selon la présence des paramètres.

- Tentative d'affichage des catégories
    
    Récupération des catégories dans le contrôleur pour les afficher dans un <select>.


- Affichage de la fiche détail d’un film
    
    Création d’une route avec un paramètre id pour afficher les détails d’un film dans MovieContoller.

- Création de la vue movies/ avec toutes les informations détaillées.

### Technologies utilisées
- PHP 8.3.14

- Symfony 6.4

- Doctrine ORM

- Twig (template engine)

- Tailwind CSS pour le style ainsi que Flowbite

### Améliorations possibles

Ajout du filtre de films par catégories 

Ajout d’une pagination sur la liste des films

Ajout d’une gestion des utilisateurs et authentification complète

Intégration d’une API externe pour récupérer les données des films