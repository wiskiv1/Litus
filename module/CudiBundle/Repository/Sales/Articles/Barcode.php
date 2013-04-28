<?php

namespace CudiBundle\Repository\Sales\Articles;

use CudiBundle\Entity\Sales\Article,
    Doctrine\ORM\EntityRepository;

/**
 * Barcode
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Barcode extends EntityRepository
{
    public function findOneByBarcode($barcode)
    {
        $query = $this->_em->createQueryBuilder();
        $resultSet = $query->select('b')
            ->from('CudiBundle\Entity\Sales\Articles\Barcode', 'b')
            ->innerJoin('b.article', 'a')
            ->innerJoin('a.mainArticle', 'm')
            ->where(
                $query->expr()->andX(
                    $query->expr()->eq('b.barcode', ':barcode'),
                    $query->expr()->eq('a.isHistory', 'false'),
                    $query->expr()->eq('m.isHistory', 'false'),
                    $query->expr()->eq('m.isProf', 'false')
                )
            )
            ->setParameter('barcode', $barcode)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

        if (isset($resultSet[0]))
            return $resultSet[0];

        return null;
    }

    public function findAllByArticle(Article $article)
    {
        $query = $this->_em->createQueryBuilder();
        $resultSet = $query->select('b')
            ->from('CudiBundle\Entity\Sales\Articles\Barcode', 'b')
            ->innerJoin('b.article', 'a')
            ->innerJoin('a.mainArticle', 'm')
            ->where(
                $query->expr()->andX(
                    $query->expr()->eq('b.article', ':article'),
                    $query->expr()->eq('a.isHistory', 'false'),
                    $query->expr()->eq('m.isHistory', 'false'),
                    $query->expr()->eq('m.isProf', 'false')
                )
            )
            ->setParameter('article', $article)
            ->getQuery()
            ->getResult();

        return $resultSet;
    }
}