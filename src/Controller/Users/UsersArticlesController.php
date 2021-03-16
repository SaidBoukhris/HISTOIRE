<?php

namespace App\Controller\Users;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * @Route("/users/articles", name="users_articles_")
 */
class UsersArticlesController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function indexArticles(ArticleRepository $articlesRepos): Response
    {
        return $this->render('users/article/indexArticle.html.twig', [
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
            $articles->setUsers($this->getUser());
            $articles->setActive(false);
            $entityManager->persist($articles);
            $entityManager->flush();
            $this->addFlash('success', 'Votre article a bien été enregistré');
            return $this->redirectToRoute('users_articles_accueil');
        }
        return $this->render('users/article/formArticle.html.twig', [
            'form' => $form->createView(),
            'editMode' => $articles->getId(),
            'articles' => $articles,
            'edit' => 'Édition de '.$articles->getTitle(),
            'create' => 'Création d\'un article',
            'controller_name' => 'Formulaire users Articles'
        ]);
    }

    /**
     * @Route("/{slug}", name="show", methods={"GET"})
     */
    public function show(Article $article,CategoriesRepository $categories): Response
    {
        return $this->render('article/show.html.twig', [
        'controller_name' => $article->getTitle(),
            'article' => $article,
            'categories' => $categories->findAll()
        ]);
    }
}
