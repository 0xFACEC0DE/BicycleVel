<?php

namespace Bicycle\Services;

class Db
{
    private $pdo;

    public function __construct($dbConfig)
    {
        $dsn = 'mysql:host=' . $dbConfig['host'] . ';port=' . $dbConfig['port'] . ';dbname=' . $dbConfig['dbname'];
        $this->pdo = new \PDO($dsn, $dbConfig['user'], $dbConfig['password']);

        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec("SET NAMES 'utf8'");
        $this->pdo->exec("SET CHARACTER SET utf8");
        $this->pdo->exec("SET CHARACTER_SET_CONNECTION=utf8");
    }

    public function query(string $sql, array $params = [], string $className = null)
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if (false === $result) {
            return null;
        }

        return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
    }

    public function exec(string $sql, array $params = [])
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);
        $affectedRows = $sth->rowCount();
        return $result && ($affectedRows > 0);
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

    public function getLastInsertId(): int
    {
        return (int) $this->pdo->lastInsertId();
    }
}
