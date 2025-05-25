<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Review;
use App\Form\ReviewTypeForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ReviewController extends AbstractController
{
    #[Route('/review/{movieId}', name: 'app_review')]
    #[IsGranted('ROLE_USER')]
    public function leaveReview(int $movieId, Request $request, EntityManagerInterface $em): Response
    {

        $movie = $em->getRepository(Movie::class)->find($movieId);

        if (!$movie) {
            throw $this->createNotFoundException('Le film demandé n\'existe pas');
        }

        $review = new Review();
        $review->setMovie($movie);
        $review->setAuthor($this->getUser());

        $form = $this->createForm(ReviewTypeForm::class, $review);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            if($review->getCreatedAt() === null){
                $review->setCreatedAt(new \DateTimeImmutable());
            }
            

            $em->persist($review);
            $em->flush();

             return $this->redirectToRoute('movies_item', ['id' => $movie->getId()]);

        }

        return $this->render('review/index.html.twig', [
            'form' =>$form->createView(),
            'movie' =>$movie
        ]);
    }
}
