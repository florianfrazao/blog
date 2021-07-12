<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    /**
     * @Route("articles/add", name="articleAdd")
     */
    public function addArticle(EntityManagerInterface $entityManager)
    {
        // On crée une nouvelle instance de l'entité (on utilise l'entité Article)
        //
        $article = new Article();

        // On utilise les setters de l'entité Article pour renseigner les valeurs des colonnes
        $article->setTitle('Titre');
        $article->setDescription('Description');
        $article->setIsPublished(true);
        $article->setCreatedAt(new \DateTime('NOW'));
        $article->setContent('lorem ipsum');

        // On prend toutes les entitées qui ont été créées ici et on les "pré-sauvegarde"
        $entityManager->persist($article);

        // On récupère tout ce qui a été sauvegardé et on les insère en BDD
        $entityManager->flush();

        // Redirige vers la liste des articles
        return $this->redirectToRoute('articleList');
    }


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

        // Ceci est une méthode de la classe articleRepository (on le sait grâce à ->)
        // la méthode findAll nous permet d'aller récupérer touts les éléments de la table
        $articles = $articleRepository->findAll();

        // Si l'article n'existe pas en BDD, on envoit une erreur 404 grâce à la méthode throw
        if (is_null($articles)) {
            throw new NotFoundHttpException();
        }

        return $this->render('article_list.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/articles/{id}", name="articleShow")
     */
    // On peut passer plusieurs paramètres, comme dans ce cas on doit récupérer l'ID
    public function articleShow($id, ArticleRepository $articleRepository)
    {
        // Un seul article en fonction de l'ID en wildcard {}
        $article = $articleRepository->find($id);

        // eSi l'article n'existe pas en BDD, on envoit un erreur 404 grâce à la méthode throw
        if (is_null($article)) {
            throw new NotFoundHttpException();
        }

        return $this->render('article_show.html.twig', [
            'article' => $article
        ]);

    }

    // Créer une route qui permet de rechercher du contenu
    // On instancie les classes ArticleRepository et Request afin de se servir de leur fonctionnalités
    /**
     * @Route("/search", name="search")
     */
    public function search(ArticleRepository $articleRepository, Request $request)
    {
        // Résultat de la recherche de l'utilisateur (on récupère ce qu'il y a dans le "result")
        // On récupère ce qu'il y a dans l'URL
        $term = $request->query->get('result');

        // Méthode searchByTerm : récupère le contenu de la recherche, donc le $term
        $articles = $articleRepository->searchByTerm($term);

        // On affiche mles résultats dans un fichier twig
        return $this->render('article_search.html.twig', [
            'articles' => $articles
        ]);
    }
}