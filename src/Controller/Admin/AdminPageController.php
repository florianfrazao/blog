<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminPageController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
        // je retourne une réponse HTTP valide en utilisant
        // la classe Response du composant HTTPFoundation
        return $this->render('admin/admin.html.twig');
    }
}