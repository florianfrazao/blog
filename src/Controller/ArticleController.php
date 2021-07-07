<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
    * @Route("/articles", name="articleList")
    */

    // instanciation de la classe ArticleRepository (qui fait le lien avec la BDD)
    // en utilisant l'autowire : (classe $variableInstanciée)
    public function articleList(ArticleRepository $articleRepository)
    {

        // findAll récupère toute la liste des articles
        $articles = $articleRepository->findAll();

        // affiche la liste d'articles dans la vue twig article_list
        return $this->render('article_list.html.twig',
            [
                'articles' => $articles
            ]);
    }

    /**
    * @Route("/articles/{id}", name="articleShow")
    */

    // instanciation de la classe ArticleRepository (qui fait le lien avec la BDD)
    // en utilisant l'autowire : (classe $variableInstanciée)
    public function articleShow($id, ArticleRepository $articleRepository)
    {

        // affiche un article en fonction de l'id renseigné dans l'url (en wildcard)
        $article = $articleRepository->find($id);

        // affiche un article en fonction de son ID dans la vue twig article_show
        return $this->render('article_show.html.twig',
            [
                'article' => $article
            ]);
    }
}