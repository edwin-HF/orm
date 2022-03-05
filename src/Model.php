<?php


namespace Edv\Orm;


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
    public static function query(){
        return new static();
    }

    public function getInfo($condition, $field = '*', $relate = [], $sort = '', $group = '', $having = '')
    {
        $query = $this->field($field)->where($condition);

        if (!empty($relate)){
            $query->alias($relate['alias'])->relate($relate['relate']);
        }

        if (!empty($sort))
            $query->orderBy($sort);

        if (!empty($group))
            $query->group($group);

        if (!empty($having))
            $query->having($having);

        return $query->get();

    }

    public function getList($condition, $field = '*', $relate = [], $sort = '', $limit = '', $group = '', $having = '')
    {

        $query = $this->field($field)->where($condition);

        if (!empty($relate)){
            $query->alias($relate['alias'])->relate($relate['relate']);
        }

        if (!empty($sort))
            $query->orderBy($sort);

        if (!empty($limit))
            $query->limit($limit);

        if (!empty($group))
            $query->group($group);

        if (!empty($having))
            $query->having($having);

        return $query->select();

    }

    public function getListForPage($condition, $field = '*', $relate = [], $sort = '', $page = null, $pageSize = null, $group = '', $having = '')
    {

        $query = $this->field($field)->where($condition);

        if (!empty($relate)){
            $query->alias($relate['alias'])->relate($relate['relate']);
        }

        if (!empty($sort))
            $query->orderBy($sort);

        if (!is_null($page) && !is_null($pageSize) && $page > 0 && $pageSize > 0)
            $query->forPage($page, $pageSize);

        if (!empty($group))
            $query->group($group);

        if (!empty($having))
            $query->having($having);

        return $query->select();

    }


}