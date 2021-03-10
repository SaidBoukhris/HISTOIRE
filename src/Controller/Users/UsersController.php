<?php

namespace App\Controller\Users;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * @Route("/users", name="users_")
 */
class UsersController extends AbstractController
{
    /**
     * @Route("/articles", name="accueil")
     */
    public function index(ArticleRepository $articles): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articles->findBy([],['createdAt'=> 'DESC']),
            'controller_name' => 'Les Articles'
        ]);
    }
    
    // /**
    //  * @Route("/articles/{slug}/editer", name="edit", methods={"GET","POST"})
    //  * @Route("/articles/ajouter", name="add", methods={"GET","POST"})
    //  */
    // public function formArticles(Article $articles=null, Request $request, EntityManagerInterface $em): Response
    // {
    //     if(!$articles){
    //         $articles = new Article();
    //     }
    //     $form = $this->createForm(ArticleType::class, $articles);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $articles->setUsers($this->getUser());
    //         $articles->setActive(false);
    //         $em->persist($articles);
    //         $em->flush();

    //         return $this->redirectToRoute('users_articles_show', ['id' => $articles->getId()]);
    //     }

    //     return $this->render('users/article/formArticle.html.twig', [
    //         'article' => $articles,
    //         'form' => $form->createView(),
    //         'editMode' => $articles->getId(),
    //         'edit' => 'Édition de '.$articles->getTitle(),
    //         'create' => 'Création d\'un article',
    //         'controller_name' => 'Formulaire'
    //     ]);
    // }

    // /**
    //  * @Route("/articles/{id<[0-9]+>}", name="show", methods={"GET"})
    //  */
    // public function show(Article $article): Response
    // {
    //     return $this->render('users/article/show.html.twig', [
    //         'controller_name' => $article->getTitle(),
    //         'article' => $article
    //     ]);
    // }

    // /**
    //  * @Route("/articles/{id<[0-9]+>}", name="delete", methods={"DELETE"})
    //  */
    // public function delete(Request $request, Article $article): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->remove($article);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('users_article_index');
    // }
}
