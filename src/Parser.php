<?php


namespace Edv\Orm;


class Parser
{

    public static function select($table, $alias, $field, $condition, $offset, $limit, $orderBy, $group, $having){

        $sql = sprintf('SELECT %s FROM %s %s %s ', $field, $table, $alias, $condition);

        if (!empty($offset) && !empty($limit)){
            $sql .= sprintf(' limit %s , %s ', $offset, $limit);
        }elseif (empty($offset) && !empty($limit)){
            $sql .= sprintf(' limit %s ', $limit);
        }

        if (!empty($orderBy)){
            $sql .= sprintf(' ORDER BY %s ', $orderBy);
        }

        if (!empty($group)){
            $sql .= sprintf(' GROUP BY %s ', $group);
        }

        if (!empty($having)){
            $sql .= sprintf(' HAVING %s ', $having);
        }

        return $sql;

    }



}