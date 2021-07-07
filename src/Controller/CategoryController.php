<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/categories", name="categoryList")
     */

    // instanciation de la classe CategoryRepository (qui fait le lien avec la BDD)
    // en utilisant l'autowire : (classe $variableInstanciée)
    public function categoryList(CategoryRepository $categoryRepository)
    {

        // findAll récupère toute la liste des articles
        $categories = $categoryRepository->findAll();

        // affiche la liste d'articles dans la vue twig article_list
        return $this->render('category_list.html.twig',
            [
                'categories' => $categories
            ]);
    }

    /**
     * @Route("/categories/{id}", name="categoryShow")
     */

    // instanciation de la classe CategoryRepository (qui fait le lien avec la BDD)
    // en utilisant l'autowire : (classe $variableInstanciée)
    public function categoryShow($id, CategoryRepository $categoryRepository)
    {

        // affiche une catégorie en fonction de l'id renseigné dans l'url (en wildcard)
        $category = $categoryRepository->find($id);

        // affiche une catégorie en fonction de son ID dans la vue twig categorie_show
        return $this->render('category_show.html.twig',
            [
                'category' => $category
            ]);
    }
}