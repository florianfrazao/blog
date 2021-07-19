<?php

namespace App\Controller\admin;

use App\Controller\ArticleController;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminPageController extends AbstractController
{
    /**
     * @Route("/admin", name="Admin")
     */

    // affiche la liste des derniers articles
    public function home(ArticleRepository $articleRepository, CategoryRepository $categoryRepository, TagRepository $tagRepository
    )
    {
        // Méthode findBy qui permet de récupérer les données avec des critères de filtre et de tri
        $lastArticles = $articleRepository->findBy([], ['id' => 'DESC'], 5);
        $lastCategories = $categoryRepository->findBy([], ['id' => 'DESC'], 5);
        $lastTags = $tagRepository->findBy([], ['id' => 'DESC'], 5);


        // je retourne une réponse HTTP valide en utilisant la classe Response du composant HTTPFoundation
        return $this->render('admin/admin.html.twig',
        [
            'articles' => $lastArticles,
            'categories' => $lastCategories,
            'tags' => $lastTags
        ]);

    }
}