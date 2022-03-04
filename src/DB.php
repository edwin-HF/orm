<?php


namespace Edv\Orm;


abstract class DB extends Builder
{

    private \PDO $conn;

    public function __construct()
    {
        //$this->conn = $this->connection($this->config());
    }

    public function config(){
        throw new \Exception('please implement config method');
    }

    public function getConnection(){
        return $this->conn;
    }

    public function connection($connection){

        $dsn = sprintf('%s:host=%s;dbname=%s;port=%s;charset=%s',$connection['type'] ?? 'mysql', $connection['host'] ?? 'localhost', $connection['database'] ?? '', $connection['port'] ?? 3306, $connection['charset'] ?? 'utf8mb4');

        static $pdo = null;

        if (!$pdo){
            $pdo = new \PDO($dsn, $connection['username'] ?? '', $connection['password']?? '', $connection['options'] ?? null);
        }

        return $pdo;

    }

    public function startTransaction()
    {
        return $this->conn->beginTransaction();
    }

    public function commit()
    {
        return $this->conn->commit();
    }

    public function rollback()
    {
        return $this->conn->rollBack();
    }

}