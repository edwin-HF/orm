<?php


namespace Edv\Orm;


use Edv\Orm\traits\mysql\ObjectStrategy;
use Edv\Orm\traits\mysql\StaticStrategy;
use mysql_xdevapi\Statement;

/**
 * Class Model
 * @package Edv\Orm
 */
class Model extends DB
{

    public function config(){
        return [];
    }

    /**
     * @return static
     */
    public static function instance(){
        return new static();
    }


}