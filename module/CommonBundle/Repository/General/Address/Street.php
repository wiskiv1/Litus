<?php

namespace CommonBundle\Repository\General\Address;

use CommonBundle\Entity\General\Address\City as CityEntity,
    Doctrine\ORM\EntityRepository;

/**
 * Street
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Street extends EntityRepository
{
    public function findOneByCityAndName(CityEntity $city, $name)
    {
        $query = $this->_em->createQueryBuilder();
        $resultSet = $query->select('s')
            ->from('CommonBundle\Entity\General\Address\Street', 's')
            ->where(
                $query->expr()->andX(
                    $query->expr()->eq('s.city', ':city'),
                    $query->expr()->eq('s.name', ':name')
                )
            )
            ->setParameter('city', $city->getId())
            ->setParameter('name', $name)
            ->getQuery()
            ->getResult();

        if (isset($resultSet[0]))
            return $resultSet[0];

        return null;
    }
}