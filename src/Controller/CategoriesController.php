<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * @Route("/categories", name="app_categories_")
 */
class CategoriesController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function indexCategories(CategoriesRepository $categoriesRepos): Response
    {
        return $this->render('categories/indexCategories.html.twig', [
            'categories' => $categoriesRepos->findAll(),
            'controller_name' => 'Nos categories',
        ]);
    }

    /**
     * @Route("/{slug}", name="show", methods={"GET"})
     */
    public function show(Categories $categories): Response
    {
        return $this->render('categories/show.html.twig', [
            'controller_name' => $categories->getName(),
            'categories' => $categories
        ]);
    }
    
}
