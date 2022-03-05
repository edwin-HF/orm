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
    private $_relate  = false;

    public function relate($relate)
    {
        $this->_relate = $relate;
        return $this;
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
     * @param string|array $conditions
     * @param string $op
     * @return $this
     */
    public function where($conditions, $op = 'AND')
    {

        $cond = '';
        if (!$this->_condition){
            $cond = ' WHERE ( ';
        }

        if (is_string($conditions)){
            $cond .= empty($this->_condition) ? sprintf(' %s ', $conditions)  : sprintf(' %s ( %s ) ', $op, $conditions);
        }elseif(is_array($conditions)){
            $cond .= empty($this->_condition) ? ' ' : sprintf(' %s ( ', $op);
            $index = 0;
            foreach ($conditions as $condition){
                $bindField = str_replace('.','_',$condition[0]);
                $cond .= sprintf('%s %s %s :%s ',($index++ == 0 ? '' : $condition[3] ?? ' AND '), $condition[0], $condition[1], $bindField);
                $this->_bindParams[':'. $bindField] = $condition[2];
            }
        }

        $cond .= ')';

        $this->_condition = $this->_condition . $cond;

        return $this;
    }

    public function orderBy($order)
    {
        $this->_orderBy = $order;
        return $this;
    }

    public function getTableName(){

        if (!empty($this->_table))
            return $this->_table;

        $this->table();

        return $this->_table;
    }

    public function select()
    {

        $sql = Parser::select($this->getTableName(), $this->_alias, $this->_field, $this->_condition, $this->_offset, $this->_limit, $this->_orderBy, $this->_group, $this->_having, $this->_relate);

        var_dump($sql);
        $stmt = (new DB())->connection()->prepare($sql);

        if (!empty($this->_bindParams)){
            foreach ($this->_bindParams as $key => $val){
                $stmt->bindValue($key, $val);
            }
        }

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function get()
    {
        $sql = Parser::select($this->getTableName(), $this->_alias, $this->_field, $this->_condition, false, false, $this->_orderBy, $this->_group, $this->_having, $this->_relate);

        $stmt = (new DB())->connection()->prepare($sql);

        if (!empty($this->_bindParams)){
            foreach ($this->_bindParams as $key => $val){
                $stmt->bindValue($key, $val);
            }
        }

        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {

        $sql = Parser::insert($this->getTableName(),$data);

        $stmt = (new DB())->connection()->prepare($sql);

        if (!empty($this->_bindParams)){
            foreach ($this->_bindParams as $key => $val){
                $stmt->bindValue($key, $val);
            }
        }

        return $stmt->execute();

    }

    public function update($data)
    {
        $sql = Parser::update($this->getTableName(),$this->_condition, $data);

        $stmt = (new DB())->connection()->prepare($sql);

        if (!empty($this->_bindParams)){
            foreach ($this->_bindParams as $key => $val){
                $stmt->bindValue($key, $val);
            }
        }

        return $stmt->execute();
    }

    public function delete()
    {
        $sql = Parser::delete($this->getTableName(), $this->_condition);

        $stmt = (new DB())->connection()->prepare($sql);

        if (!empty($this->_bindParams)){
            foreach ($this->_bindParams as $key => $val){
                $stmt->bindValue($key, $val);
            }
        }

        return $stmt->execute();
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

    /**
     * @param $sql
     * @param array $bindParams
     * @return bool|\PDOStatement
     */
    public function exec($sql, $bindParams = [])
    {

        $stmt = (new DB())->connection()->prepare($sql);

        if (!empty($bindParams)){
            foreach ($bindParams as $key => $val){
                $stmt->bindValue($key, $val);
            }
        }

        $stmt->execute();

        return $stmt;

    }

    public function forPage($page, $pageSize)
    {
        $this->_offset = ($page - 1) * $pageSize;
        $this->_limit  = $pageSize;
        return $this;
    }


}