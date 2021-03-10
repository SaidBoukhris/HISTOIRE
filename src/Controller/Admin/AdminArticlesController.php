<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * @Route("/admin/articles", name="admin_articles_")
 */
class AdminArticlesController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function indexArticles(ArticleRepository $articlesRepos): Response
    {
        return $this->render('admin/articles/indexArticles.html.twig', [
            'articles' => $articlesRepos->findAll(),
            'controller_name' => 'Gérer les articles',
        ]);
    }

    /**
     * @Route("/ajouter", name="add", methods={"GET","POST"})
     * @Route("/{slug}/editer", name="edit", methods={"GET","POST"})
     */
    public function formArticles(Request $request, Article $articles=null): Response
    {
        if(!$articles){
            $articles = new Article();
        }

        $form = $this->createForm(ArticleType::class,$articles);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($articles);
            $entityManager->flush();
            $this->addFlash('success', 'Votre article a bien été ajouté');
            return $this->redirectToRoute('admin_articles_accueil');
        }
        return $this->render('admin/articles/formArticles.html.twig', [
            'form' => $form->createView(),
            'editMode' => $articles->getId(),
            'edit' => 'Édition de '.$articles->getTitle(),
            'create' => 'Création d\'un article',
            'controller_name' => 'Formulaire Admin Articles'
        ]);
    }
}
