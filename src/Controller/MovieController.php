<?php

namespace App\Controller;

use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\MovieType;

class MovieController extends AbstractController
{
    #[Route('/movie', name: 'movie_index')]
    public function index(EntityManagerInterface $manager): Response
    {
        $movies = $manager->getRepository(Movie::class)->findAll();

        return $this->render('movie/index.html.twig', [
            'movies' => $movies
        ]);
    }
    
    #[Route('/movie/{id}', name: 'movie_show', requirements: ['id' => '\d+'])]
    public function show($id, EntityManagerInterface $manager): Response
    {
        $movie = $manager->getRepository(Movie::class)->find($id);

        if (!$movie) {
            throw new $this->createNotFoundException('The movie does not exist');
        }

        return $this->render('movie/show.html.twig', [
            'movie' => $movie
        ]);
    }

    #[Route('/movie/create', name: 'movie_create')]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($movie);
            $manager->flush();
            return $this->redirectToRoute('movie_show', [
                'id' => $movie->getId()
            ]);
        }

        return $this->render('movie/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/movie/update/{id}', name: 'movie_update')]
    public function update($id, Request $request, EntityManagerInterface $manager): Response
    {
        $movie = $manager ->getRepository(Movie::class)->find($id);
        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            return $this->redirectToRoute('movie_show', [
                'id' => $movie->getId()
            ]);
        }

        return $this->render('movie/update.html.twig', [
            'form' => $form->createView(),
            'movie' => $movie
        ]);
    }
    #[Route('/movie/delete/{id}/{token}', name: 'movie_delete')]
    public function delete($id, EntityManagerInterface $manager,Movie $movie): Response
    {
        if ($this->isCsrfTokenValid('delete' . $movie->getId(), $request->request->get('_token'))) {
        $manager->remove($movie);
        $manager->flush();
        
        return $this->redirectToRoute('movie_index');
        
    }
    
    }
}