<?php


namespace Edv\Orm\traits\mysql;

/**
 * Trait StaticStrategy
 * @package Edv\Orm\traits\mysql
 */
trait StaticStrategy
{

    public $handle;

    public function alias($aliasName){

        if (empty($this->handle)){
            $this->handle = new static();
        }

        return $this->handle;

    }

    public function getList($condition , $field = '*' , $relate = [] , $sort = '' , $limit = 0 , $group = '' , $having = ''){

    }

    public function getListPaginate(){

    }

    public function getInfo(){
        var_dump(1212);
    }

    public function update(){

    }

    public function insert(){

    }

    public static function __callStatic($name, $arguments)
    {
        call_user_func_array([(new static()),$name],[$arguments]);
    }

}