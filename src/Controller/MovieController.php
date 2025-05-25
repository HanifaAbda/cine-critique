<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\CategoryRepository;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MovieController extends AbstractController
{
    #[Route('/movies', name: 'movies_list')]
    public function list(MovieRepository $movieRepository): Response
    {
        //récupère tous les films
        $movies = $movieRepository->findAll();
        
        //affiche tous les films
        return $this->render('movies/list.html.twig', [
            'movies' => $movies,
        ]);
    }

    #[Route('/movies/search', name: 'movies_search')]
    public function search(
        Request $request,
        MovieRepository $movieRepository,
        CategoryRepository $categoryRepository
    ): Response {
        $query = $request->query->get('query');
        $categoryId = $request->query->get('category');

        $movies = $movieRepository->findByTitleAndCategory($query, $categoryId);
        $categories = $categoryRepository->findAll();

        return $this->render('movies/list.html.twig', [
            'movies' => $movies,
            'categories' => $categories,
            'selectedCategory' => $categoryId,
            'searchQuery' => $query,
        ]);
    }
    

    #[Route('/movies/{id}', name:'movies_item')]

    public function item(Movie $movie): Response
    {
        //affiche un film correspondant à l'ID
        return $this->render('movies/item.html.twig',['movie'=> $movie]);
    }
}
