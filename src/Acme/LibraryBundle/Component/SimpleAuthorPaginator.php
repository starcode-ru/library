<?php
namespace Acme\LibraryBundle\Component;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class SimpleAuthorPaginator {

    const DEFAULT_PAGE_SIZE = 20;

    private $count;
    private $currentPage;
    private $fullPages;

    public function paginate(NativeQuery $query, $page, $pageSize)
    {
        $this->currentPage = $page;
        $query->getEntityManager();

        $this->count = $this->getTotalCount($query->getEntityManager());

        $query->setSQL($query->getSQL() . ' limit ' . (($page - 1) * $pageSize) . ', ' . $pageSize);

        $this->fullPages = ceil($this->count / $pageSize);

        return $query->getResult();
    }

    /**
     * @param EntityManager $em
     * @return int
     */
    private function getTotalCount(EntityManager $em)
    {
        $rsm = new ResultSetMappingBuilder($em);
        $rsm->addScalarResult('count', 'count');

        $queryCount = $em->createNativeQuery('select count(*) as count from Author a', $rsm);

        return (int) $queryCount->getSingleScalarResult();
    }

}