<?php

namespace NotificationBundle\Repository\Nodes;

use DateTime,
    Doctrine\ORM\EntityRepository;

/**
 * Notification
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Notification extends EntityRepository
{
    public function findAll()
    {
        $query = $this->_em->createQueryBuilder();
        $resultSet = $query->select('n')
            ->from('NotificationBundle\Entity\Nodes\Notification', 'n')
            ->orderBy('n.creationTime', 'DESC')
            ->getQuery()
            ->getResult();

        return $resultSet;
    }

    public function findAllActive()
    {
        $now = new DateTime();

        $query = $this->_em->createQueryBuilder();
        $resultSet = $query->select('n')
            ->from('NotificationBundle\Entity\Nodes\Notification', 'n')
            ->where(
                $query->expr()->andx(
                    $query->expr()->lte('n.startDate', ':now'),
                    $query->expr()->gte('n.endDate', ':now'),
                    $query->expr()->eq('n.active', 'true')
                )
            )
            ->setParameter('now', $now)
            ->orderBy('n.creationTime', 'DESC')
            ->getQuery()
            ->getResult();

        return $resultSet;
    }
}