<?php


namespace Edv\Orm\traits;


use Edv\Orm\IBuilder;

trait Connection
{

    protected $host        = 'localhost';
    protected $password    = 'root';
    protected $database    = '';
    protected $port        = '3306';
    protected $persistent  = 1;

    public function setHost(string $host): Connection
    {
        $this->host = $host;
        return $this;
    }

    public function setPort(string $port): Connection
    {
        $this->port = $port;
        return $this;
    }

    public function setPassword(string $password): Connection
    {
        $this->password = $password;
        return $this;
    }

    public function setDb(string $db): Connection
    {
        $this->database = $db;
        return $this;
    }

    public function setPersistent(string $persistent): Connection
    {
        $this->persistent = $persistent;
        return $this;
    }
}