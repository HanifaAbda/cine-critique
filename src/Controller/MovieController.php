<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route('/movie/{id}', name:'movies_show')]

    public function show(Movie $movie): Response
    {
        //affiche un film correspondant à l'ID
        return $this->render('movies/show.html.twig',['movie'=> $movie]);
    }
}
