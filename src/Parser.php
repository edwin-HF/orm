<?php


namespace Edv\Orm;


class Parser
{

    public static function select($table, $alias, $field, $condition, $offset, $limit, $orderBy, $group, $having, $relates){

        $sql = sprintf('SELECT %s FROM `%s` %s ', $field, $table, $alias);

        if (!empty($relates)){
            foreach ($relates as $relate){
                $sql .= sprintf(' %s JOIN %s ON %s ', $relate[2]?? ' LEFT ', $relate[0], $relate[1]);
            }
        }

        $sql.=$condition;

        if (!empty($group)){
            $sql .= sprintf(' GROUP BY %s ', $group);
        }

        if (!empty($orderBy)){
            $sql .= sprintf(' ORDER BY %s ', $orderBy);
        }

        if (!empty($offset) && !empty($limit)){
            $sql .= sprintf(' limit %s , %s ', $offset, $limit);
        }elseif (empty($offset) && !empty($limit)){
            $sql .= sprintf(' limit %s ', $limit);
        }

        if (!empty($having)){
            $sql .= sprintf(' HAVING %s ', $having);
        }

        return $sql;

    }

    public static function insert($table, $data){

        $fields = [];
        $values = [];

        if (count($data)==count($data, 1)) {
            $fields  = array_keys($data);

            $values[] = array_map(function ($item){
                return sprintf('"%s"',addslashes($item));
            },$data);

        } else {
            foreach ($data as $item){
                if (empty($fields)){
                    $fields = array_keys($item);
                }

                $values[] = array_map(function ($val){
                    return sprintf('"%s"',addslashes($val));
                },$item);
            }
        }

        $fields = array_map(function ($val){
            return sprintf('`%s`',$val);
        },$fields);

        $sql = sprintf('INSERT INTO `%s` ( ' . implode(',',$fields) . ' ) VALUES ', $table);

        $vDataArr = [];
        foreach ($values as $value){
            $vDataArr[] = sprintf(' ( %s ) ', implode(',', $value));
        }

        if (empty($vDataArr))
            throw new \Exception('data is null');

        $sql .= implode(',', $vDataArr);

        return $sql;

    }

    public static function update($table, $condition, $data){

        if (empty($condition))
            throw new \Exception('condition is null');

        $sql = sprintf('UPDATE `%s` SET ', $table);

        $values = [];
        foreach ($data as $key => $val){
            $values[] = sprintf(' `%s` = "%s" ', $key, addslashes($val));
        }

        $sql .= implode(',', $values);

        return $sql . $condition;

    }


    public static function delete($table, $condition){

        if (empty($condition))
            throw new \Exception('condition is null');

        $sql = sprintf('DELETE FROM `%s` ', $table);


        return $sql . $condition;

    }





}