<?php

namespace App\Controller\admin;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{

    // AJOUTER UNE CATEGORIE

    /**
     * @Route("/admin/categories/add", name="AdminCategoryAdd")
     */

    public function addCategory(
        EntityManagerInterface $entityManager,
        CategoryRepository $categoryRepository
    )
    {
        // On utilise l'entité Category, pour créer une nouvelle catégorie en bdd
        // Une instance de l'entité Category = un enregistrement de catégorie en bdd
        $category = new Category();

        // On utilise les setters de l'entité Category pour alimenter les valeurs des colonnes
        $category->setTitle('Nouveau Titre');
        $category->setDescription('Nouvelle description');
        $category->setIsPublished(true);

        // On prend toutes les entitées qui ont été créées ici et on les "pré-sauvegarde"
        $entityManager->persist($category);

        // On récupère tout ce qui a été sauvegardé et on les insère en BDD
        $entityManager->flush();

        // On redirige vers la liste des articles
        return $this->redirectToRoute('AdminCategoryList');
    }


    // MODIFIER UNE CATEGORIE

    /**
     * @Route("/admin/categories/update/{id}" , name="AdminCategoryUpdate")
     */

    public function updateCategory($id,
                                  CategoryRepository $categoryRepository,
                                  EntityManagerInterface $entityManager)
    {
        // Récupération de la catégorie en fonction de son id defini dans la wildcard
        $category = $categoryRepository->find($id);

        // Ajout de la nouvelle valeur a modifier
        $category->setTitle('titre modifié');

        // Pré-sauvegarde et envoi en bdd
        $entityManager->persist($category);
        $entityManager->flush();

        // Redirection vers la liste des catégories
        return $this->redirectToRoute('AdminCategoryList');
    }


    // SUPPRIMER UNE CATEGORIE

    /**
     * @Route("admin/categories/delete/{id}" , name="AdminCategoryDelete")
     */

    public function deleteCategory($id,
                                  CategoryRepository $categoryRepository,
                                  EntityManagerInterface $entityManager)
    {
        // Récupération de la catégorie en fonction de son id defini dans la wildcard
        $category = $categoryRepository->find($id);

        // Suppression de la catégorie
        $entityManager->remove($category);

        // Envoi en bdd
        $entityManager->flush();

        // Rédirection vers la liste des catégories
        return $this->redirectToRoute('AdminCategoryList');
    }

    // LISTER LES CATEGORIES

    /**
     * @Route("admin/categories", name="AdminCategoryList")
     */

    // Sert à faire une requête SQL SELECT en BDD, sur la table Catégorie
    // CategoryRepository : classe qui nous permet de faire ces requêtes
    // On doit donc instancier cette classe (grâce à l'autowire)
    // On place la classe CategoryRepository en argument du controller, suivi de la
    //  variable dans laquelle on veut instancier la classe $categoryRepository
    public function categoryList(CategoryRepository $categoryRepository)
    {

        // La méthode findAll nous permet d'aller récupérer touts les éléments de la table
        $categories = $categoryRepository->findAll();

        return $this->render('admin/admin_category.html.twig',
            [
                'categories' => $categories
            ]);
    }

}