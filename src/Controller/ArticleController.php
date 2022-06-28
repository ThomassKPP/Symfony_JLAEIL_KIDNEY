<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ArticleType;



class ArticleController extends AbstractController
{
    #[Route('/article', name: 'article_index')]
    public function index(EntityManagerInterface $manager): Response
    {
        $articles = $manager->getRepository(Article::class)->findAll();

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/article/{id}', name: 'article_show', requirements: ['id' => '\d+'])]
    public function show($id, EntityManagerInterface $manager): Response
    {
        $article = $manager->getRepository(Article::class)->find($id);

        if (!$article) {
            throw new $this->createNotFoundException('The article does not exist');
        }

        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/article/create', name: 'article_create')]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($article);
            $manager->flush();
            return $this->redirectToRoute('article_show', [
                'id' => $article->getId()
            ]);
        }

        return $this->render('article/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/article/update/{id}', name: 'article_update')]
    public function update($id, Request $request, EntityManagerInterface $manager): Response
    {
        $article = $manager ->getRepository(Article::class)->find($id);
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($article);
            $manager->flush();
            return $this->redirectToRoute('article_show', [
                'id' => $article->getId()
            ]);
        }

        return $this->render('article/update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/article/delete/{id}', name: 'article_delete')]
    public function delete($id, EntityManagerInterface $manager,Article $article): Response
    {
        $manager->remove($article);
        $manager->flush();

        return $this->redirectToRoute('article_index');
    }
}
