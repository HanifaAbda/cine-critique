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
        $movies = $movieRepository->findAll();
        $query = $request->query->get('query');
        $categoryId = $request->query->get('category');

        if($query || $categoryId) {
            $movies = $movieRepository->findByTitleAndCategory($query, $categoryId);
        } else {
            
            $movies = $movieRepository->findBy([],['createdAt' => 'DESC'] );
        }

        $categories = $categoryRepository->findAll();


        return $this->render('index/home.html.twig', [
            'movies' => $movies,
            'categories' => $categories,
            'selectedCategory' => $categoryId,
            'searchQuery' => $query,
        ]);
    }



}
