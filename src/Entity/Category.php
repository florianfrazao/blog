<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
     * @Assert\Length(
     *     min=5,
     *     minMessage="Merci de renseigner un titre de plus de 5 caractères",
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Merci de saisir une description")
     * @Assert\Length(
     *     min=10,
     *     minMessage="Merci de renseigner une description de plus de 10 caractères",
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished;


    // Jointure avec la table articles en utilisant Doctrine

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="category")
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIsPublished()
    {
        return $this->isPublished;
    }

    public function setIsPublished($isPublished): void
    {
        $this->isPublished = $isPublished;
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