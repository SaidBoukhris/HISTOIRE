<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * @Route("/admin/categories", name="admin_categories_")
 */
class AdminCategoriesController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function indexCategories(CategoriesRepository $categoriesRepos): Response
    {
        return $this->render('admin/categories/indexCategories.html.twig', [
            'categories' => $categoriesRepos->findAll(),
            'controller_name' => 'Gérer les categories',
        ]);
    }

    /**
     * @Route("/{id<[0-9]+>}", name="show", methods={"GET"})
     */
    public function show(Categories $categories): Response
    {
        return $this->render('admin/categories/show.html.twig', [
            'controller_name' => $categories->getName(),
            'categories' => $categories
        ]);
    }
    
    /**
     * @Route("/ajouter", name="add", methods={"GET","POST"})
     * @Route("/editer/{id<[0-9]+>}", name="edit", methods={"GET","POST"})
     */
    public function formCategories(Request $request, Categories $categorie=null): Response
    {
        if(!$categorie){
            $categorie = new Categories();
        }

        $form = $this->createForm(CategoriesType::class,$categorie);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorie);
            $entityManager->flush();
            $this->addFlash('success', 'La catégorie a bien été enregistré');
            return $this->redirectToRoute('admin_categories_accueil');
        }
        return $this->render('admin/categories/formCategories.html.twig', [
            'form' => $form->createView(),
            'editMode' => $categorie->getId(),
            'edit' => 'Édition de '.$categorie->getName(),
            'create' => 'Création d\'une catégorie',
            'controller_name' => 'Formulaire Admin Categories'
        ]);
    }
}
