<?php

namespace App\Util\QueryParam;

/**
 * Filter
 */
class Filter
{

    private $reference = null;

    private $values = null;

    private $operator = null;

    public function __construct($reference, $operator, $values)
    {
        $this->reference = $reference;
        $this->operator  = $operator;
        $this->values    = $values;
    }

    public function getReference()
    {
        return $this->reference;
    }

    public function getValues()
    {
        return $this->values;
    }
}