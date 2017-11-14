<?php
// src/OC/PlatformBundle/Entity/AdvertRepository.php

namespace OC\PlateformBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class AdvertRepository extends EntityRepository
{
    public function myFindAll()
    {
        // Méthode 1 : en passant par l'EntityManager
        $queryBuilder = $this->_em->createQueryBuilder()
            ->select('a')
            ->from($this->_entityName, 'a')
        ;
        // Dans un repository, $this->_entityName est le namespace de l'entité gérée
        // Ici, il vaut donc OC\PlatformBundle\Entity\Advert

        // Méthode 2 : en passant par le raccourci (je recommande)
        $queryBuilder = $this->createQueryBuilder('a');

        // On n'ajoute pas de critère ou tri particulier, la construction
        // de notre requête est finie

        // On récupère la Query à partir du QueryBuilder
        $query = $queryBuilder->getQuery();

        // On récupère les résultats à partir de la Query
        $results = $query->getResult();

        // On retourne ces résultats
        return $results;
    }

    public function getAdvertWithCategories(array $categoryNames)
    {
        $qb = $this->createQueryBuilder('a');

        // On fait une jointure avec l'entité Category avec pour alias « c »
        $qb
            ->join('a.categories', 'c')
            ->addSelect('c')
        ;

        // Puis on filtre sur le nom des catégories à l'aide d'un IN
        $qb->where($qb->expr()->in('c.name', $categoryNames));
        // La syntaxe du IN et d'autres expressions se trouve dans la documentation Doctrine

        // Enfin, on retourne le résultat
        return $qb
            ->getQuery()
            ->getResult()
            ;
    }

    public function getAdverts($page, $nbPerPage)
    {
        $query = $this->createQueryBuilder('a')
            // Jointure sur l'attribut image
            ->leftJoin('a.image', 'i')
            ->addSelect('i')
            // Jointure sur l'attribut categories
            ->leftJoin('a.categories', 'c')
            ->addSelect('c')
            ->orderBy('a.date', 'DESC')
            ->getQuery()
        ;

        $query
            // On définit l'annonce à partir de laquelle commencer la liste
            ->setFirstResult(($page-1) * $nbPerPage)
            // Ainsi que le nombre d'annonce à afficher sur une page
            ->setMaxResults($nbPerPage)
        ;

        // Enfin, on retourne l'objet Paginator correspondant à la requête construite
        // (n'oubliez pas le use correspondant en début de fichier)
        return new Paginator($query, true);


        return $query->getResult();
    }


}