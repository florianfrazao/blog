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

    // AJOUTER UN ARTICLE

    /**
     * @Route("articles/add", name="articleAdd")
     */

    public function addArticle(
        EntityManagerInterface $entityManager,
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository
    )
    {
        // On utilise l'entité Article, pour créer un nouvel article en bdd
        // Une instance de l'entité Article = un enregistrement d'article en bdd
        $article = new Article();

        // On utilise les setters de l'entité Article pour alimenter les valeurs des colonnes
        $article->setTitle('Nouveau Titre');
        $article->setDescription('Nouvelle description');
        $article->setIsPublished(true);
        $article->setCreatedAt(new \DateTime('NOW'));
        $article->setContent('Nouveau contenu');

        // On récupère la catégorie dont l'id est 1 en bdd
        // doctrine créé une instance de l'entité category avec les infos de la catégorie de la bdd
        $category = $categoryRepository->find(1);

        // On associe l'instance de l'entité categorie récupérée, à l'instance de l'entité article
        $article->setCategory($category);

        // On cherche le tag dont le titre est 'info'
        $tag = $tagRepository->findOneBy(['title' => 'newTag']);

        // Si le tag info n'existe pas...
        if (is_null($tag))
        {
            // On crée une instance de l'entité Tag et on utilise les setters pour alimenter cette instance
            $tag = new Tag();
            $tag->setTitle("newTag");
            $tag->setColor("magenta");
        }

        // On associe l'instance de l'entité tag récupéré, à l'instance de l'entité article
        $article->setTag($tag);

        // On prend toutes les entitées qui ont été créées ici et on les "pré-sauvegarde"
        $entityManager->persist($article);
        $entityManager->persist($tag);

        // On récupère tout ce qui a été sauvegardé et on les insère en BDD
        $entityManager->flush();

        // On redirige vers la liste des articles
        return $this->redirectToRoute('articleList');
    }


    // MODIFIER UN ARTICLE

    /**
     * @Route("/articles/update/{id}" , name="articleUpdate")
     */

    public function updateArticle($id,
      ArticleRepository $articleRepository,
      EntityManagerInterface $entityManager)
    {
        // Récupération de l'article en fonction de son id defini dans la wildcard
        $article = $articleRepository->find($id);

        // Ajout de la nouvelle valeur a modifier
        $article->setTitle('titre modifié');

        // Pré-sauvegarde et envoi en bdd
        $entityManager->persist($article);
        $entityManager->flush();

        // Rédirection vers la liste des articles
        return $this->redirectToRoute('articleList');
    }


    // SUPPRIMER UN ARTICLE

    /**
     * @Route("/articles/delete/{id}" , name="articleDelete")
     */

    public function deleteArticle($id,
                                  ArticleRepository $articleRepository,
                                  EntityManagerInterface $entityManager)
    {
        // Récupération de l'article en fonction de son id defini dans la wildcard
        $article = $articleRepository->find($id);

        // Si l'article n'existe pas en BDD, on envoit une erreur 404 grâce à la méthode throw
        if (is_null($article)) {
            throw new NotFoundHttpException();
        }

        // Suppression de l'article concerné
        $entityManager->remove($article);

        // Envoi en bdd
        $entityManager->flush();

        // Rédirection vers la liste des articles
        return $this->redirectToRoute('articleList');
    }

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