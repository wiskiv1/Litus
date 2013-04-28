<?php

namespace CudiBundle\Repository\Stock\Orders;

use CudiBundle\Entity\Sales\Article,
    CudiBundle\Entity\Stock\Period,
    Doctrine\ORM\EntityRepository;

/**
 * Item
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Item extends EntityRepository
{
    public function findOneOpenByArticle(Article $article)
    {
        $query = $this->_em->createQueryBuilder();
        $resultSet = $query->select('i')
            ->from('CudiBundle\Entity\Stock\Orders\Item', 'i')
            ->innerJoin('i.order', 'o')
            ->where(
                $query->expr()->andX(
                    $query->expr()->eq('i.article', ':article'),
                    $query->expr()->isNull('o.dateCreated')
                )
            )
            ->setParameter('article', $article->getId())
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

        if (isset($resultSet[0]))
            return $resultSet[0];

        return null;
    }

    public function findAllByPeriod(Period $period)
    {
        $query = $this->_em->createQueryBuilder();
        $query->select('i')
            ->from('CudiBundle\Entity\Stock\Orders\Item', 'i')
            ->innerJoin('i.order', 'o')
            ->where(
                $query->expr()->andX(
                    $query->expr()->gt('o.dateCreated', ':startDate'),
                    $period->isOpen() ? '1=1' : $query->expr()->lt('o.dateCreated', ':endDate')
                )
            )
            ->orderBy('o.dateOrdered', 'DESC')
            ->setParameter('startDate', $period->getStartDate());

        if (!$period->isOpen())
            $query->setParameter('endDate', $period->getEndDate());

        $resultSet = $query->getQuery()
            ->getResult();

        return $resultSet;
    }

    public function findAllByTitleAndPeriod($title, Period $period)
    {
        $query = $this->_em->createQueryBuilder();
        $query->select('i')
            ->from('CudiBundle\Entity\Stock\Orders\Item', 'i')
            ->innerJoin('i.order', 'o')
            ->innerJoin('i.article', 'a')
            ->innerJoin('a.mainArticle', 'm')
            ->where(
                $query->expr()->andX(
                    $query->expr()->like($query->expr()->lower('m.title'), ':title'),
                    $query->expr()->gt('o.dateCreated', ':startDate'),
                    $period->isOpen() ? '1=1' : $query->expr()->lt('o.dateCreated', ':endDate')
                )
            )
            ->orderBy('o.dateOrdered', 'DESC')
            ->setParameter('title', '%'.strtolower($title).'%')
            ->setParameter('startDate', $period->getStartDate());

        if (!$period->isOpen())
            $query->setParameter('endDate', $period->getEndDate());

        $resultSet = $query->getQuery()
            ->getResult();

        return $resultSet;
    }

    public function findAllBySupplierStringAndPeriod($supplier, Period $period)
    {
        $query = $this->_em->createQueryBuilder();
        $query->select('i')
            ->from('CudiBundle\Entity\Stock\Orders\Item', 'i')
            ->innerJoin('i.order', 'o')
            ->innerJoin('o.supplier', 's')
            ->where(
                $query->expr()->andX(
                    $query->expr()->like($query->expr()->lower('s.name'), ':supplier'),
                    $query->expr()->gt('o.dateCreated', ':startDate'),
                    $period->isOpen() ? '1=1' : $query->expr()->lt('o.dateCreated', ':endDate')
                )
            )
            ->orderBy('o.dateOrdered', 'DESC')
            ->setParameter('supplier', '%'.strtolower($supplier).'%')
            ->setParameter('startDate', $period->getStartDate());

        if (!$period->isOpen())
            $query->setParameter('endDate', $period->getEndDate());

        $resultSet = $query->getQuery()
            ->getResult();

        return $resultSet;
    }
}