<?php


namespace Edv\Orm;

class DB extends Builder
{

    private static $connMap;
    private \PDO $curConn;

    public function __construct()
    {
        //$this->conn = $this->connection($this->config());
    }

    public function config(){
        throw new \Exception('please implement config method');
    }

    public function getConnection(){
        return $this->curConn;
    }

    /**
     * @param array $con
     * @return \PDO
     */
    public function connection($con = []){

        try {
            //$connection = array_merge(\config('database',[]), $con);
        }catch (\Exception $exception){
            $connection = [];
        }

        $defaultOptions = [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ];

        $dsn = sprintf('%s:host=%s;dbname=%s;port=%s;charset=%s',$connection['type'] ?? 'mysql', $connection['host'] ?? '127.0.0.1', $connection['database'] ?? 'test', $connection['port'] ?? 3306, $connection['charset'] ?? 'utf8mb4');

        if (!isset(self::$connMap[$dsn]) || empty(self::$connMap[$dsn])){
        }
            $this->curConn = self::$connMap[$dsn] = new \PDO($dsn, $connection['username'] ?? 'root', $connection['password']?? 'root', array_merge($defaultOptions,$connection['options'] ?? []));

        return $this->curConn;

    }

    public function startTransaction()
    {
        return $this->curConn->beginTransaction();
    }

    public function commit()
    {
        return $this->curConn->commit();
    }

    public function rollback()
    {
        return $this->curConn->rollBack();
    }

}