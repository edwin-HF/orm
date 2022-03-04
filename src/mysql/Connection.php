<?php


namespace Edv\Orm\Mysql;


use Edv\Orm\IBuilder;
use Edv\Orm\IConnection;

class Connection implements IConnection
{

    use \Edv\Orm\traits\Connection;

    public function connection(array $conn = []): IBuilder
    {
        // TODO: Implement connection() method.
    }
}