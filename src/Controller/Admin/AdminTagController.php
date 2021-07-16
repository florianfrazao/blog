<?php

namespace App\Controller\admin;

use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminTagController extends AbstractController
{

    // AJOUTER UNE CATEGORIE

    /**
     * @Route("/admin/tags/add", name="AdminTagAdd")
     */

    public function addTag(
        EntityManagerInterface $entityManager,
        Request $request
    )
    {
        // On utilise l'entité tag, pour créer un nouveau tag en bdd
        // Une instance de l'entité tag = un enregistrement de catégorie en bdd
        $tag = new tag();

        // on génère le formulaire en utilisant le gabarit + une instance de l'entité Tag
        $tagForm = $this->createForm(TagType::class, $tag);

        // on lie le formulaire aux données de POST (aux données envoyées en POST)
        $tagForm->handleRequest($request);

        // si le formulaire a été posté et qu'il est valide,
        // on enregistre l'article créé en bdd
        if ($tagForm->isSubmitted() && $tagForm->isValid()) {

            // On prend toutes les entitées qui ont été créées ici et on les "pré-sauvegarde"
            $entityManager->persist($tag);

            // On récupère tout ce qui a été sauvegardé et on les insère en BDD
            $entityManager->flush();

            // Redirection vers la liste des tags
            return $this->redirectToRoute('AdminTagList');

        }

        // Création de la vue du formulaire
        return $this->render('admin/admin_tag_add.html.twig', [
            'tagForm' => $tagForm->createView()
        ]);
    }


    // MODIFIER UNE CATEGORIE

    /**
     * @Route("/admin/tags/update/{id}" , name="AdminTagUpdate")
     */

    public function updateTag(
        $id,
        tagRepository $tagRepository,
        EntityManagerInterface $entityManager,
        Request $request
    )
    {
        // Récupération de la catégorie en fonction de son id defini dans la wildcard
        $tag = $tagRepository->find($id);

        // on génère le formulaire en utilisant le gabarit + une instance de l'entité Tag
        $tagForm = $this->createForm(TagType::class, $tag);

        // on lie le formulaire aux données de POST (aux données envoyées en POST)
        $tagForm->handleRequest($request);

        // si le formulaire a été posté et qu'il est valide,
        // on enregistre l'article créé en bdd
        if ($tagForm->isSubmitted() && $tagForm->isValid()) {

            // Pré-sauvegarde et envoi en bdd
            $entityManager->persist($tag);
            $entityManager->flush();

            // Redirection vers la liste des catégories
            return $this->redirectToRoute('AdminTagList');

        }

        // Création de la vue du formulaire
        return $this->render('admin/admin_tag_update.html.twig', [
            'tagForm' => $tagForm->createView()
        ]);
    }


    // SUPPRIMER UNE CATEGORIE

    /**
     * @Route("admin/tags/delete/{id}" , name="AdminTagDelete")
     */

    public function deleteTag(
        $id,
        tagRepository $tagRepository,
        EntityManagerInterface $entityManager
    )
    {
        // Récupération de la catégorie en fonction de son id defini dans la wildcard
        $tag = $tagRepository->find($id);

        // Suppression de la catégorie
        $entityManager->remove($tag);

        // Envoi en bdd
        $entityManager->flush();

        // Rédirection vers la liste des catégories
        return $this->redirectToRoute('AdminTagList');
    }

    // LISTER LES tags

    /**
     * @Route("admin/tags", name="AdminTagList")
     */

    // Sert à faire une requête SQL SELECT en BDD, sur la table Catégorie
    // tagRepository : classe qui nous permet de faire ces requêtes
    // On doit donc instancier cette classe (grâce à l'autowire)
    // On place la classe tagRepository en argument du controller, suivi de la
    //  variable dans laquelle on veut instancier la classe $tagRepository
    public function tagList(tagRepository $tagRepository)
    {

        // La méthode findAll nous permet d'aller récupérer touts les éléments de la table
        $tags = $tagRepository->findAll();

        return $this->render('admin/admin_tag.html.twig',
            [
                'tags' => $tags
            ]);
    }

}