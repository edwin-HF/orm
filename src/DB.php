<?php


namespace Edv\Orm;

class DB extends Builder
{

    private static $connMap;
    private \PDO $curConn;

    /**
     * @param array $config
     * @return \PDO
     */
    public function getConnection($config = []):\PDO
    {
        return $this->connection($config);
    }

    public function config(){
        throw new \Exception('config must be implement');
    }

    /**
     * @return static
     */
    public static function query(){
        return new static();
    }

    /**
     * @param array $config
     * @return \PDO
     */
    public function connection($config = []){

        try {
            $connection = array_merge($this->config(), $config);
        }catch (\Exception $exception){
            $connection = [];
        }

        $defaultOptions = [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ];

        $dsn = sprintf('%s:host=%s;dbname=%s;port=%s;charset=%s',$connection['type'] ?? 'mysql', $connection['host'] ?? '127.0.0.1', $connection['database'] ?? 'test', $connection['port'] ?? 3306, $connection['charset'] ?? 'utf8mb4');

        if (!isset(self::$connMap[$dsn]) || empty(self::$connMap[$dsn])){
            $this->curConn = self::$connMap[$dsn] = new \PDO($dsn, $connection['username'] ?? 'root', $connection['password']?? 'root', array_merge($defaultOptions,$connection['options'] ?? []));
        }else{
            $this->curConn = self::$connMap[$dsn];
        }

        $this->curConn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

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