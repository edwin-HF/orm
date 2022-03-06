<?php


namespace Edv\Orm;


interface IQuery
{

    public function where($condition);

    public function relate($relate);

    public function select();

    public function get();

    public function insert($data);

    public function update($data);

    public function delete();

    public function limit($limit);

    public function offset($offset);

    public function group($group);

    public function having($having);

    public function field($columns);

    public function alias($tableName);

    public function orderBy($order);

    public function count();

    public function exec($sql);

    public function forPage($page, $pageSize);


}