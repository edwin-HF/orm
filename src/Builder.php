<?php


namespace Edv\Orm;


abstract class Builder implements IQuery
{

    private $_condition  = '';
    private $_bindParams = [];
    private $_table   = '';
    private $_alias   = '';
    private $_field   = '*';
    private $_limit   = false;
    private $_offset  = false;
    private $_having  = false;
    private $_group   = false;
    private $_orderBy = false;

    public function relate($relate)
    {
        // TODO: Implement relate() method.
    }

    public function table($table = ''){

        if (!empty($table)){
            $this->_table = $table;
        }elseif (!empty($this->tableName)){
            $this->_table = $this->tableName;
        }else{
            $this->_table = Helper::unCamelize(basename(str_replace('\\', '/', static::class)));
        }

        return $this;

    }

    /**
     * @param $conditions
     * @param string $op
     * @return $this
     * ['name','=','zhangsan']
     */
    public function where($conditions, $op = 'AND')
    {

        if ($this->_condition){
            $this->_condition .= sprintf(' %s ( ', $op);
        }else{
            $this->_condition = ' WHERE ( ';
        }

        $index = 0;
        foreach ($conditions as $condition){
            $this->_condition .= sprintf('%s %s %s :%s ',($index++ == 0 ? '' : ' AND '), $condition[0], $condition[1], $condition[0]);
            $this->_bindParams[':'.$condition[0]] = $condition[2];
        }

        $this->_condition .= ' ) ';

        return $this;
    }

    public function orderBy($order)
    {
        $this->_orderBy = $order;
        return $this;
    }

    public function test(){
        var_dump($this->table());
        var_dump($this->condition);
        var_dump($this->bindParams);
        var_dump(static::class);
    }

    public function select()
    {

        if (empty($this->_table)){
            $this->table();
        }

        $sql = Parser::select($this->_table, $this->_alias, $this->_field, $this->_condition, $this->_offset, $this->_limit, $this->_orderBy, $this->_group, $this->_having);
        var_dump($sql);

        // TODO: Implement select() method.
    }

    public function get()
    {
        // TODO: Implement get() method.
    }

    public function insert($data)
    {
        // TODO: Implement insert() method.
    }

    public function update($data)
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    public function limit($limit)
    {
        $this->_limit = $limit;
        return $this;
    }

    public function offset($offset)
    {
        $this->_offset = $offset;
        return $this;
    }

    public function group($group)
    {
        $this->_group = $group;
        return $this;
    }

    public function having($having)
    {
        $this->_having = $having;
        return $this;
    }

    public function field($columns)
    {
        $this->_field = is_array($columns) ? implode(',',$columns) : $columns;
        return $this;
    }

    public function alias($tableName)
    {
        $this->_alias = $tableName;
        return $this;
    }

    public function exec($sql)
    {
        // TODO: Implement exec() method.
    }

    public function forPage($page, $pageSize)
    {
        $this->_offset = ($page - 1) * $pageSize;
        $this->_limit  = $pageSize;
        return $this;
    }

    public function getInfo($condition, $field = '*', $relate = [], $sort = '', $limit = 0, $group = '', $having = '')
    {
        // TODO: Implement getInfo() method.
    }

    public function getList()
    {
        // TODO: Implement getList() method.
    }

    public function getListForPage()
    {
        // TODO: Implement getListForPage() method.
    }
}