<?php

namespace Bicycle\Lib;

class Db
{
    private $pdo;

    public function __construct($dbConfig)
    {
        $dsn = 'mysql:host=' . $dbConfig['host'] . ';port=' . $dbConfig['port'] . ';dbname=' . $dbConfig['dbname'];
        $this->pdo = new \PDO($dsn, $dbConfig['user'], $dbConfig['password']);

        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec("SET NAMES 'utf8'; SET CHARACTER SET utf8; SET CHARACTER_SET_CONNECTION=utf8");
    }

    public function query(string $sql, array $params = [], string $className = null)
    {
        $sth = $this->pdo->prepare($sql);
        try {
            if (!$result = $sth->execute($params)) {
                return false;
            }
        } catch (\PDOException $e) {
            error_log($e->getMessage(), 0);
            return false;
        }

        $array = $sth->fetchAll(\PDO::FETCH_CLASS, $className);
        return empty($array) ? false : $array;
    }

    public function exec(string $sql, array $params = [])
    {
        $sth = $this->pdo->prepare($sql);
        try {
            $result = $sth->execute($params);
            $affectedRows = $sth->rowCount();
        } catch (\PDOException $e) {
            error_log($e->getMessage(), 0);
            return false;
        }
        return $result && ($affectedRows > 0);
    }

    public function getLastInsertId()
    {
        return (int) $this->pdo->lastInsertId();
    }

    public function transaction(callable $callback)
    {
        $this->pdo->beginTransaction();
        try {
            $callback();
            $this->pdo->commit();
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}
