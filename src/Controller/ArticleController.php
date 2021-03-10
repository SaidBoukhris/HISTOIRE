<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/articles", name="app_articles_")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(ArticleRepository $articles): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articles->findBy([],['createdAt'=> 'DESC']),
            'controller_name' => 'Les Articles'
        ]);
    }

    /**
     * @Route("/{slug}", name="show", methods={"GET"})
     */
    public function show(Article $article=null): Response
    {
        return $this->render('article/show.html.twig', [
            'controller_name' => $article->getTitle(),
            'article' => $article
        ]);
    }

}
