<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class IndexController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findAll();

        return $this->render('index/home.html.twig', ['movies' => $movies]);
    }



}
