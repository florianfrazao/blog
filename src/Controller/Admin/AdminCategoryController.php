<?php

namespace App\Controller\admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{

    // AJOUTER UNE CATEGORIE

    /**
     * @Route("/admin/categories/add", name="AdminCategoryAdd")
     */

    public function addCategory(
        EntityManagerInterface $entityManager,
        Request $request
    )
    {
        // On utilise l'entité Category, pour créer une nouvelle catégorie en bdd
        // Une instance de l'entité Category = un enregistrement de catégorie en bdd
        $category = new Category();

        // on génère le formulaire en utilisant le gabarit + une instance de l'entité Category
        $categoryForm = $this->createForm(CategoryType::class, $category);

        // on lie le formulaire aux données de POST (aux données envoyées en POST)
        $categoryForm->handleRequest($request);

        // si le formulaire a été posté et qu'il est valide,
        // on enregistre l'article créé en bdd
        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {

            // On prend toutes les entitées qui ont été créées ici et on les "pré-sauvegarde"
            $entityManager->persist($category);

            // On récupère tout ce qui a été sauvegardé et on les insère en BDD
            $entityManager->flush();

            // Redirection vers la liste des catégories
            return $this->redirectToRoute('AdminCategoryList');
        }

        // Création de la vue du formulaire
        return $this->render('admin/admin_category_add.html.twig', [
            'categoryForm' => $categoryForm->createView()
        ]);
    }


    // MODIFIER UNE CATEGORIE

    /**
     * @Route("/admin/categories/update/{id}" , name="AdminCategoryUpdate")
     */

    public function updateCategory(
        $id,
        CategoryRepository $categoryRepository,
        EntityManagerInterface $entityManager,
        Request $request
    )
    {
        // Récupération de la catégorie en fonction de son id defini dans la wildcard
        $category = $categoryRepository->find($id);

        // on génère le formulaire en utilisant le gabarit + une instance de l'entité Article
        $categoryForm = $this->createForm(CategoryType::class, $category);

        // on lie le formulaire aux données de POST (aux données envoyées en POST)
        $categoryForm->handleRequest($request);

        // si le formulaire a été posté et qu'il est valide,
        // on enregistre l'article créé en bdd
        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {

            // Pré-sauvegarde et envoi en bdd
            $entityManager->persist($category);
            $entityManager->flush();

            // Redirection vers la liste des catégories
            return $this->redirectToRoute('AdminCategoryList');
        }

        // création de la vue du formulaire
        return $this->render('admin/admin_category_update.html.twig', [
        'categoryForm' => $categoryForm->createView()
        ]);
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