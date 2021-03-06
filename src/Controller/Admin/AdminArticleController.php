<?php

namespace App\Controller\admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminArticleController extends AbstractController
{

    // AJOUTER UN ARTICLE

    /**
     * @Route("/admin/articles/add", name="AdminArticleAdd")
     */

    public function addArticle(Request $request, EntityManagerInterface $entityManager)
    {
        $article = new Article();

        // on génère le formulaire en utilisant le gabarit + une instance de l'entité Article
        $articleForm = $this->createForm(ArticleType::class, $article);

        // on lie le formulaire aux données de POST (aux données envoyées en POST)
        $articleForm->handleRequest($request);

        // si le formulaire a été posté et qu'il est valide
        if ($articleForm->isSubmitted() && $articleForm->isValid()) {

            // permet de stocker en session une notification, dans le but de l'afficher sur la page suivante
            $this->addFlash(
                'success',
                'l\'article '. $article->getTitle().' a bien été créé !'
            );

            // on enregistre l'article créé en bdd et on le pousse
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('AdminArticleList');
        }

        if ($articleForm->isSubmitted() && !($articleForm->isValid())) {
            // si erreur, afficher un message d'erreur :
            $this->addFlash(
                'warning',
                'Une erreur est survenue lors l\'ajout de l\'article'
            );
        }

        // création de la vue du formulaire
        return $this->render('admin/admin_article_add.html.twig', [
            'articleForm' => $articleForm->createView()
        ]);
    }


    // MODIFIER UN ARTICLE

    /**
     * @Route("/admin/articles/update/{id}" , name="AdminArticleUpdate")
     */

    public function updateArticle(
        $id,
        ArticleRepository $articleRepository,
        EntityManagerInterface $entityManager,
        Request $request
    )
    {
        // on récupère l'article en fonction de son id defini dans la wildcard
        $article = $articleRepository->find($id);

        // on génère le formulaire en utilisant le gabarit + une instance de l'entité Article
        $articleForm = $this->createForm(ArticleType::class, $article);

        // on lie le formulaire aux données de POST (aux données envoyées en POST)
        $articleForm->handleRequest($request);

        // si le formulaire a été posté et qu'il est valide
        if ($articleForm->isSubmitted() && $articleForm->isValid()) {

            // permet de stocker en session une notification, dans le but de l'afficher sur la page suivante
            $this->addFlash(
                'success',
                'L\'article '. $article->getTitle().' a bien été modifié !'
            );

            // on enregistre l'article créé en bdd et on le pousse
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('AdminArticleList');
        }

        if ($articleForm->isSubmitted() && !($articleForm->isValid())) {
            // si erreur, afficher un message d'erreur :
            $this->addFlash(
                'warning',
                'Une erreur est survenue lors de la modification de l\'article'
            );
        }

        return $this->render('admin/admin_article_update.html.twig', [
            'articleForm' => $articleForm->createView()
        ]);
    }

    // SUPPRIMER UN ARTICLE

    /**
     * @Route("admin/articles/delete/{id}" , name="AdminArticleDelete")
     */

    public function deleteArticle($id,
                                  ArticleRepository $articleRepository,
                                  EntityManagerInterface $entityManager)
    {
        // Récupération de l'article en fonction de son id defini dans la wildcard
        $article = $articleRepository->find($id);

        // Suppression de l'article concerné
        $entityManager->remove($article);

        // Envoi en bdd
        $entityManager->flush();

        // permet de stocker en session une notification, dans le but de l'afficher sur la page suivante
        $this->addFlash(
            'success',
            'L\'article '. $article->getTitle().' a bien été supprimé !'
        );

        // Rédirection vers la liste des articles
        return $this->redirectToRoute('AdminArticleList');
    }

    // LISTER LES ARTICLES

    /**
     * @Route("admin/articles", name="AdminArticleList")
     */

    // Sert à faire une requête SQL SELECT en BDD, sur la table Article
    // ArticleRepository : classe qui nous permet de faire ces requêtes
    // On doit donc instancier cette classe (grâce à l'autowire)
    // On place la classe ArticleRepository en argument du controller, suivi de la
    //  variable dans laquelle on veut instancier la classe $articleRepository
    public function articleList(ArticleRepository $articleRepository)
    {

        // La méthode findAll nous permet d'aller récupérer touts les éléments de la table
        $articles = $articleRepository->findAll();

        return $this->render('admin/admin_article.html.twig',
        [
            'articles' => $articles
        ]);
    }

}