<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\CategoriesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/articles", name="app_articles_")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(ArticleRepository $articles,CategoriesRepository $categories): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articles->findBy([],['createdAt'=> 'DESC']),
            'controller_name' => 'Les Articles',
            'categories' => $categories->findAll()
        ]);
    }

    /**
     * @Route("/{slug}", name="show", methods={"GET"})
     */
    public function show(Article $article=null,CategoriesRepository $categories): Response
    {
        return $this->render('article/show.html.twig', [
        'controller_name' => $article->getTitle(),
            'article' => $article,
            'categories' => $categories->findAll()
        ]);
    }

}
