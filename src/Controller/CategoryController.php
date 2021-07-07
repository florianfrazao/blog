<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    private $categories = [
        1 => [
            "id" => 1,
            "title" => "Politique",
            "desc" => "Tous les articles liés à Jean Lassalle",
            "content" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam efficitur condimentum nunc, at ullamcorper odio pretium a. Fusce vitae interdum lectus, eu lacinia neque. Quisque ut laoreet magna, quis dictum quam. Curabitur lorem lectus, fermentum ut ante at, tempus fringilla leo. Sed nec facilisis velit, ultricies interdum nibh. Curabitur neque arcu, pulvinar vitae libero sed, congue dignissim erat. Interdum et malesuada fames ac ante ipsum primis in faucibus.",
            "published" => true,
        ],
        2 => [
            "id" => 2,
            "title" => "Economie",
            "desc" => "Les meilleurs tuyaux pour avoir DU FRIC",
            "content" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam efficitur condimentum nunc, at ullamcorper odio pretium a. Fusce vitae interdum lectus, eu lacinia neque. Quisque ut laoreet magna, quis dictum quam. Curabitur lorem lectus, fermentum ut ante at, tempus fringilla leo. Sed nec facilisis velit, ultricies interdum nibh. Curabitur neque arcu, pulvinar vitae libero sed, congue dignissim erat. Interdum et malesuada fames ac ante ipsum primis in faucibus.",
            "published" => true
        ],
        3 => [
            "id" => 3,
            "title" => "Securité",
            "desc" => "Attention les étrangers sont très méchants",
            "content" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam efficitur condimentum nunc, at ullamcorper odio pretium a. Fusce vitae interdum lectus, eu lacinia neque. Quisque ut laoreet magna, quis dictum quam. Curabitur lorem lectus, fermentum ut ante at, tempus fringilla leo. Sed nec facilisis velit, ultricies interdum nibh. Curabitur neque arcu, pulvinar vitae libero sed, congue dignissim erat. Interdum et malesuada fames ac ante ipsum primis in faucibus.",
            "published" => true
        ],
        4 => [
            "id" => 4,
            "title" => "Ecologie",
            "desc" => "Hummer <3",
            "content" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam efficitur condimentum nunc, at ullamcorper odio pretium a. Fusce vitae interdum lectus, eu lacinia neque. Quisque ut laoreet magna, quis dictum quam. Curabitur lorem lectus, fermentum ut ante at, tempus fringilla leo. Sed nec facilisis velit, ultricies interdum nibh. Curabitur neque arcu, pulvinar vitae libero sed, congue dignissim erat. Interdum et malesuada fames ac ante ipsum primis in faucibus.",
            "published" => true
        ]
    ];

    /**
     * @Route("/categories", name="categoryList")
     */
    public function categoryList()
    {
        $categories = $this->categories;
        return $this->render('category_list.html.twig', ['categories' => $categories]);

    }

    /**
     * @Route("category/{id}", name="categoryShow")
     */
    public function categoryShow($id)
    {
        $category = $this->categories{$id};
        return $this->render('category_show.html.twig', ['category' => $category]);

    }

}