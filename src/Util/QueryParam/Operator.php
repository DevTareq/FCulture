<?php

namespace App\Util\QueryParam;

/**
 * Operator
 */
class Operator
{

    const NONE                  = 'NONE';
    const IS_NULL               = 'IS_NULL';
    const IS_NOT_NULL           = 'IS_NOT_NULL';
    const IN                    = 'IN';
    const NOT_IN                = 'NOT_IN';
    const LIKE                  = 'LIKE';
    const NOT_LIKE              = 'NOT_LIKE';
    const EQUAL                 = 'EQUAL';
    const NOT_EQUAL             = 'NOT_EQUAL';
    const LESS_THAN_OR_EQUAL    = 'LESS_THAN_OR_EQUAL';
    const LESS_THAN             = 'LESS_THAN';
    const GREATER_THAN_OR_EQUAL = 'GREATER_THAN_OR_EQUAL';
    const GREATER_THAN          = 'GREATER_THAN';

}
