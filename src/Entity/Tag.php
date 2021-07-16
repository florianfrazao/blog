<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
class Tag
{

    // Entités de la table category

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Merci de saisir un titre")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Merci de saisir un code couleur")
     */
    private $colorCode;


    // Jointure avec la table articles en utilisant Doctrine

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="tag")
     */
    private $articles;


    // Getters and Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getColorCode()
    {
        return $this->colorCode;
    }

    public function setColorCode($colorCode): void
    {
        $this->colorCode = $colorCode;
    }


    public function getArticles()
    {
        return $this->articles;
    }

    public function setArticles($articles): void
    {
        $this->articles = $articles;
    }


}
