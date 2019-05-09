<?php

namespace App\Repository;

use App\Entity\FieldProcessing;
use App\Util\QueryParam\QueryParamFieldProcessing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FieldProcessing|null find($id, $lockMode = null, $lockVersion = null)
 * @method FieldProcessing|null findOneBy(array $criteria, array $orderBy = null)
 * @method FieldProcessing[]    findAll()
 * @method FieldProcessing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FieldProcessingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FieldProcessing::class);
    }

    /**
     * reportByQueryParam
     *
     * @param QueryParamFieldProcessing $qp
     *
     * @return array
     */
    public function findByQueryParam(QueryParamFieldProcessing $qp)
    {

        $query = "SELECT fp
                  FROM App:FieldProcessing fp
                  LEFT JOIN fp.field f
                  LEFT JOIN fp.tractor t
                  LEFT JOIN fp.crop c
                  WHERE 1 = 1";

        $filters = [];

        if ($qp->field_id != null) {
            $query .= ' AND f.id = :field_id ';
            $filters['field_id'] = $qp->field_id;
        }
        if ($qp->tractor_id != null) {
            $query .= ' AND t.id = :tractor_id ';
            $filters['tractor_id'] = $qp->tractor_id;
        }
        if ($qp->crop_id != null) {
            $query .= ' AND c.id = :crop_id ';
            $filters['crop_id'] = $qp->crop_id;
        }
        if (!empty($qp->date_from)) {
            $query .= ' AND fp.date > :date_from ';
            $filters['date_from'] = $qp->date_from;
        }
        if (!empty($qp->date_to)) {
            $query .= ' AND fp.date < :date_to ';
            $filters['date_to'] = $qp->date_to;
        }

        $qry = $this->getEntityManager()->createQuery($query);

        if (count($filters) > 0) {
            $qry->setParameters($filters);
        }

        if ($qp->getLimit() > 0) {
            $qry = $qry->setMaxResults($qp->getLimit())->setFirstResult($qp->getStart());
        }

        return $qry->getResult();
    }

    /**
     * sumAreaByQueryParam
     *
     * @param QueryParamFieldProcessing $qp
     *
     * @return int
     */
    public function sumAreaByQueryParam(QueryParamFieldProcessing $qp)
    {

        $query = "SELECT SUM(fp.area)
                  FROM App:FieldProcessing fp
                  LEFT JOIN fp.field f
                  LEFT JOIN fp.tractor t
                  LEFT JOIN fp.crop c
                  WHERE 1 = 1";

        $filters = [];

        if ($qp->field_id != null) {
            $query .= ' AND f.id = :field_id ';
            $filters['field_id'] = $qp->field_id;
        }
        if ($qp->tractor_id != null) {
            $query .= ' AND t.id = :tractor_id ';
            $filters['tractor_id'] = $qp->tractor_id;
        }
        if ($qp->crop_id != null) {
            $query .= ' AND c.id = :crop_id ';
            $filters['crop_id'] = $qp->crop_id;
        }
        if (!empty($qp->date_from)) {
            $query .= ' AND fp.date > :date_from ';
            $filters['date_from'] = $qp->date_from;
        }
        if (!empty($qp->date_to)) {
            $query .= ' AND fp.date < :date_to ';
            $filters['date_to'] = $qp->date_to;
        }

        $qry = $this->getEntityManager()->createQuery($query);

        if (count($filters) > 0) {
            $qry->setParameters($filters);
        }

        return $qry->getSingleScalarResult();
    }
}
