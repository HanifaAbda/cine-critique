<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityLoaderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ReviewController extends AbstractController
{
    #[Route('/review', name: 'review_new')]
    #[IsGranted('ROLE_USER')]
    public function new(Movie $movie, Request $request, EntityManagerInterface $em): Response
    {
        $review = new Review();
        $review->setMovie($movie);
        $review->setUser($this->getUser());

        $form = $this->createForm(ReviewType::class, $review);

        return $this->render('review/index.html.twig', [
            'controller_name' => 'ReviewController',
        ]);
    }
}
