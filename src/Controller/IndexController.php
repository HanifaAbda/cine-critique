<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class IndexController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(
        MovieRepository $movieRepository,
        CategoryRepository $categoryRepository,
        Request $request
                        
    ): Response
    {

        $query = $request->query->get('query');
        

        if($query) {
            $movies = $movieRepository->findByTitle($query);
        } else {
            
            $movies = $movieRepository->findBy([],['createdAt' => 'DESC'] );
        }

        $categories = $categoryRepository->findAll();


        return $this->render('index/home.html.twig', [
            'movies' => $movies,
            'categories' => $categories,
            'searchQuery' => $query,
        ]);
    }



}
