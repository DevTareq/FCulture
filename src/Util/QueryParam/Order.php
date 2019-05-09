<?php

namespace App\Util\QueryParam;

/**
 * Order
 */
class Order
{

    const ASC  = 'ASC';
    const DESC = 'DESC';

    private $reference = null;
    private $order     = null;

    public function __construct($reference, $order = null)
    {
        $this->reference = $reference;

        if ($order === null) {
            $order = '';
        } else {
            $order = strtoupper(trim($order));
        }

        switch ($order) {
            case self::DESC :
                $this->order = self::DESC;
                break;
            case self::ASC :
            default:
                $this->order = self::ASC;
        }
    }

    public function getReference()
    {
        return $this->reference;
    }

    public function getOrder()
    {
        return $this->order;
    }

}
