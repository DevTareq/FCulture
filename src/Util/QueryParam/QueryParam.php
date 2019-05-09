<?php

namespace App\Util\QueryParam;

/**
 * QueryParam
 */
class QueryParam
{

    /**
     * Variable de recherche globale
     *
     * @var string
     */
    private $query = '';

    /**
     * Liste des filtres par champs
     *
     * @var type
     */
    private $filters = [];

    /**
     * Liste des tris par champs
     *
     * @var type
     */
    private $orders = [];

    /**
     * Paramètre start de la requête
     *
     * @var int
     */
    private $start = 0;

    /**
     * Paramètre start de la requête
     *
     * @var int
     */
    private $limit = 0;

    /**
     * Set query
     *
     * @param string $query
     *
     * @return QueryParameters
     */
    public function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Get query
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Set start
     *
     * @param integer $start
     *
     * @return QueryParameters
     */
    public function setStart($start)
    {
        $this->start = (int)$start;

        return $this;
    }

    public function initLimit($pageNumber, $pageSize)
    {
        if ((int)$pageNumber <= 0) {
            $pageNumber = 1;
        }

        $this->start = ((int)$pageNumber - 1) * (int)$pageSize;
        $this->limit = (int)$pageSize;
    }

    public function getPagesNumber($total)
    {

        if ((int)$this->limit > 0 && (int)$total > (int)$this->limit) {
            return (int)ceil((int)$total / (int)$this->limit);
        }

        return 1;
    }

    /**
     * Get start
     *
     * @return integer
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set limit
     *
     * @param integer $limit
     *
     * @return QueryParameters
     */
    public function setLimit($limit)
    {
        $this->limit = (int)$limit;

        return $this;
    }

    /**
     * Get limit
     *
     * @return integer
     */
    public function getLimit()
    {
        return $this->limit;
    }

    public function addFilter($reference, $operator, $values)
    {
        $this->filters[] = new Filter($reference, $operator, $values);

        return $this;
    }

    public function getFilters()
    {
        return $this->filters;
    }

    public function getFilterByReference($reference)
    {
        foreach ($this->filters as $filter) {
            if ($filter->getReference() === $reference) {
                return $filter;
            }
        }

        return false;
    }

    public function addOrder($reference, $order)
    {
        $this->orders[] = new Order($reference, $order);

        return $this;
    }

    public function getOrders()
    {
        return $this->orders;
    }

    public function getQueryOrder($default = '')
    {
        $o = '';

        foreach ($this->orders as $order) {

            $sep = ', ';

            if (trim($o) === '') {
                $sep = 'ORDER BY ';
            }

            if ($order->getOrder() === Order::DESC) {
                $o .= $sep . $order->getReference() . ' DESC';
            } else {
                $o .= $sep . $order->getReference() . ' ASC';
            }
        }

        if (trim($o) === '' && trim($default) !== '') {
            return $default;
        }

        return $o;
    }

}
