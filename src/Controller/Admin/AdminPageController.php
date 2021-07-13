<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminPageController extends AbstractController
{
    /**
     * @Route("/admin", name="Admin")
     */
    public function admin()
    {
        // je retourne une réponse HTTP valide en utilisant
        // la classe Response du composant HTTPFoundation
        return $this->render('admin/admin.html.twig');
    }
}