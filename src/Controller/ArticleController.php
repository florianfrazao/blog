<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Tag;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    // LISTER LES ARTICLES

    /**
     * @Route("/articles", name="articleList")
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

        // Si l'article n'existe pas en BDD, on envoit une erreur 404 grâce à la méthode throw
        if (is_null($articles)) {
            throw new NotFoundHttpException();
        }

        return $this->render('article_list.html.twig',
        [
            'articles' => $articles
        ]);
    }

    // AFFICHER UN ARTICLE EN FONCTION DE SON ID

    /**
     * @Route("/articles/{id}", name="articleShow")
     */

    // On peut passer plusieurs paramètres, comme dans ce cas on doit récupérer l'ID
    public function articleShow($id, ArticleRepository $articleRepository)
    {
        // Récupération de l'article en fonction de son id defini dans la wildcard
        $article = $articleRepository->find($id);

        // Si l'article n'existe pas en BDD, on envoit un erreur 404 grâce à la méthode throw
        if (is_null($article)) {
            throw new NotFoundHttpException();
        }

        // On affiche les résultats dans un fichier twig
        return $this->render('article_show.html.twig',
        [
            'article' => $article
        ]);

    }

    // RECHERCHER UN ARTICLE

    /**
     * @Route("/search", name="search")
     */

    // On instancie les classes ArticleRepository et Request afin de se servir de leur fonctionnalités
    public function search(ArticleRepository $articleRepository, Request $result)
    {
        // Résultat de la recherche de l'utilisateur (on récupère ce qu'il y a dans le "result")
        // On récupère ce qu'il y a dans l'URL
        $term = $result->query->get('result');

        // Méthode searchByTerm : récupère le contenu de la recherche, donc le $term
        $articles = $articleRepository->searchByTerm($term);

        // On affiche les résultats dans un fichier twig
        return $this->render('article_search.html.twig',
        [
            'articles' => $articles,
            'term' => $term
        ]);
    }
}