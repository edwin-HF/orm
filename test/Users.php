<?php

namespace test;

class Users extends \Edv\Orm\Model
{

    public function config()
    {
        return [
            'database' => 'test'
        ];
    }

}