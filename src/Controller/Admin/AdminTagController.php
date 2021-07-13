<?php

namespace App\Controller\admin;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminTagController extends AbstractController
{

    // AJOUTER UNE CATEGORIE

    /**
     * @Route("/admin/tags/add", name="AdminTagAdd")
     */

    public function addTag(
        EntityManagerInterface $entityManager,
        TagRepository $tagRepository
    )
    {
        // On utilise l'entité tag, pour créer une nouvelle catégorie en bdd
        // Une instance de l'entité tag = un enregistrement de catégorie en bdd
        $tag = new tag();

        // On utilise les setters de l'entité tag pour alimenter les valeurs des colonnes
        $tag->setTitle('Nouveau Titre');
        $tag->setColor('blue');

        // On prend toutes les entitées qui ont été créées ici et on les "pré-sauvegarde"
        $entityManager->persist($tag);

        // On récupère tout ce qui a été sauvegardé et on les insère en BDD
        $entityManager->flush();

        // On redirige vers la liste des articles
        return $this->redirectToRoute('AdminTagList');
    }


    // MODIFIER UNE CATEGORIE

    /**
     * @Route("/admin/tags/update/{id}" , name="AdminTagUpdate")
     */

    public function updateTag($id,
                                  tagRepository $tagRepository,
                                  EntityManagerInterface $entityManager)
    {
        // Récupération de la catégorie en fonction de son id defini dans la wildcard
        $tag = $tagRepository->find($id);

        // Ajout de la nouvelle valeur a modifier
        $tag->setTitle('tag modifié');

        // Pré-sauvegarde et envoi en bdd
        $entityManager->persist($tag);
        $entityManager->flush();

        // Redirection vers la liste des catégories
        return $this->redirectToRoute('AdminTagList');
    }


    // SUPPRIMER UNE CATEGORIE

    /**
     * @Route("admin/tags/delete/{id}" , name="AdminTagDelete")
     */

    public function deleteTag($id,
                                  tagRepository $tagRepository,
                                  EntityManagerInterface $entityManager)
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