<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoriesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="app_accueil")
     */
    public function index(ArticleRepository $articles,CategoriesRepository $categoriesRepos): Response
    {
        return $this->render('accueil/index.html.twig', [
            'articles' => $articles->findBy([],['createdAt'=> 'DESC']),
            'categories' => $categoriesRepos->findAll(),
            'controller_name' => 'Accueil',
        ]);
    }
}
