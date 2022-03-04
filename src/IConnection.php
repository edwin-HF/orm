<?php


namespace Edv\Orm;


use mysql_xdevapi\Statement;

interface IConnection
{

    /**
     * @param array $conn["host","port","password","db","persistent"]
     * @return IBuilder
     */
    public function connection(array $conn = []);

    /**
     * @param string $host
     * @return $this
     */
    public function setHost(string $host) ;

    /**
     * @param string $port
     * @return $this
     */
    public function setPort(string $port) ;

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password) ;

    /**
     * @param string $db
     * @return $this
     */
    public function setDb(string $db) ;

    /**
     * @param string $persistent
     * @return $this
     */
    public function setPersistent(string $persistent) ;

}