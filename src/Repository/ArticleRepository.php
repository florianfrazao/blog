<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    // création d'une fonction de recherche
    public function searchByTerm($term){
        // utilisation de la classe QueryBuilder pour faire une recherche dans la classe Article
        $queryBuilder = $this->createQueryBuilder('article');
        $query = $queryBuilder
            // sélectionner la table article
            ->select('article')
            // filtrer avec les données saisies par l'utilisateur (:term)
            ->where('article.content LIKE :term')
            // sécuriser les données saisies par l'utilisateur par la méthode setParameters
            ->setParameter('term', '%' .$term. '%')
            // exécuter la requête
            ->getQuery();
        // retourner le résultat
        return $query->getResult();
    }
}
