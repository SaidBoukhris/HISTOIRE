<?php

namespace App\Controller\Users;

use App\Entity\Users;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Form\FormAccountType;
use App\Repository\UsersRepository;
use App\Repository\ArticleRepository;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * @Route("/users/account", name="users_account_")
 */
class UsersController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(UsersRepository $usersRepos,ArticleRepository $articles,CategoriesRepository $categoriesRepos): Response
    {
        return $this->render('users/account/usersAccount.html.twig', [
            'articles' => $articles->findBy([],['createdAt'=> 'DESC']),
            'categories' => $categoriesRepos->findAll(),
            'users' => $usersRepos->findAll(),
            'controller_name' => ' '
        ]);
    }
    
    /**
     * @Route("/{name}/editer", name="edit")
     */
    public function formAccount(Request $request, EntityManagerInterface $em): Response
    {
        $user=$this->getUser();
        $form = $this->createForm(FormAccountType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Votre compte a bien été mis à jour');
            return $this->redirectToRoute('users_account_accueil');
        }

        return $this->render('users/account/formAccount.html.twig', [
            'formAccount' => $form->createView(),
            'controller_name' => 'Édition de '.$user->getEmail()
        ]);
    }
}
