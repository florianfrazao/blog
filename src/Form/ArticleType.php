<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre' // change le nom du label
            ])

            ->add('description', TextType::class, [
                'label' => 'Description'
            ])

            ->add('category', EntityType::class, [
                'label' => 'Catégorie',
                'class' => Category::class, // fait la jonction avec la table Catégorie
                'choice_label' => 'title'
            ])

            ->add('tag', EntityType::class, [
                'label' => 'Tag',
                'class' => Tag::class,
                'choice_label' => 'title'
            ])

            ->add('content', TextareaType::class, [
                'label' => 'Contenu'
            ])

            ->add('createdAt', DateType::class, [
                'widget' => 'single_text', // convertit le champ date en champ date HTML5
                'label' => "Date de création",
                'data' => new \DateTime('NOW') // affiche la date du jour
            ])

            ->add('isPublished', CheckboxType::class, [
                'label' => 'Publié ?',
                'data' => true // autochecked
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
