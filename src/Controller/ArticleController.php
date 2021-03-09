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
 * @Route("/articles")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_article_index")
     */
    public function index(ArticleRepository $articles): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articles->findBy([],['createdAt'=> 'DESC']),
            'controller_name' => 'Les Articles'
        ]);
    }

    /**
     * @Route("/ajouter", name="app_article_new", methods={"GET","POST"})
     * @Route("/{id<[0-9]+>}/editer", name="app_article_edit", methods={"GET","POST"})
     */
    public function new(Article $article=null,Request $request): Response
    {
        if(!$article){
            $article = new Article();
            $article->setCreatedAt(new \DateTime());
        }
        
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if($article->getModifiedAt() == null) {
                $article->setModifiedAt(new \DateTime());
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('app_article_show',['id'=>$article->getId()]);
        }

        return $this->render('article/formArticle.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
            'editMode' => $article->getId(),
            'edit' => 'Édition de '.$article->getTitle(),
            'create' => 'Création d\'un article',
            'controller_name' => 'Formulaire'
        ]);
    }

    /**
     * @Route("/{id<[0-9]+>}", name="app_article_show", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'controller_name' => $article->getTitle(),
            'article' => $article
        ]);
    }

    /**
     * @Route("/{id<[0-9]+>}", name="app_article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_article_index');
    }
}
