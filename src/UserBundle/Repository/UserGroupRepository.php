<?php

namespace UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use UserBundle\Service\PaginatorService;

class UserGroupRepository extends EntityRepository
{
    /**
     * Get list by pagination
     *
     * @param integer $page
     * @param integer $limit
     * @param string $orderBy Order By Field
     * @param string $orderDir Order Direction
     * @param string $keyword Keyword for search
     * @return PaginatorService
     */
    public function getListPagination($page=1, $limit=15, $orderBy='createdAt', $orderDir='DESC', $keyword='')
    {
        $query = $this->createQueryBuilder('ug')
            ->orderBy('ug.'.$orderBy, $orderDir);

        if($keyword !== '') {
            $query->andWhere('ug.title LIKE :keyword')
                ->setParameter('keyword', '%'.$keyword.'%');
        }

        $dql = $query->getQuery();

        return new PaginatorService($dql, $page, $limit);
    }
}
