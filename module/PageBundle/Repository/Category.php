<?php

namespace PageBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Category
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Category extends EntityRepository
{
    public function findAll()
    {
        $query = $this->_em->createQueryBuilder();
        $resultSet = $query->select('c')
            ->from('PageBundle\Entity\Category', 'c')
            ->where(
                $query->expr()->eq('c.active', 'true')
            )
            ->getQuery()
            ->getResult();

        return $resultSet;
    }

    public function findByParent($parent)
    {
        return $this->_em->getRepository('PageBundle\Entity\Category')
            ->findBy(array('parent' => $parent, 'active' => true));
    }
}