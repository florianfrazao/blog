<?php

namespace App\Controller;

use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends AbstractController
{
    /**
    * @Route("/tags", name="tagList")
    */

    // instanciation de la classe TagRepository (qui fait le lien avec la BDD)
    // en utilisant l'autowire : (classe $variableInstanciée)
    public function tagList(TagRepository $tagRepository)
    {

        // findAll récupère toute la liste des tags
        $tags = $tagRepository->findAll();

        // affiche la liste d'tags dans la vue twig tag_list
        return $this->render('tag_list.html.twig',
            [
                'tags' => $tags
            ]);
    }

    /**
    * @Route("/tags/{id}", name="tagShow")
    */

    // instanciation de la classe TagRepository (qui fait le lien avec la BDD)
    // en utilisant l'autowire : (classe $variableInstanciée)
    public function tagShow($id, TagRepository $tagRepository)
    {

        // affiche un tag en fonction de l'id renseigné dans l'url (en wildcard)
        $tag = $tagRepository->find($id);

        // affiche un tag en fonction de son ID dans la vue twig tag_show
        return $this->render('tag_show.html.twig',
            [
                'tag' => $tag
            ]);
    }
}