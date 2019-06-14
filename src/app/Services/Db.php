<?php

namespace App\Services;

class Db
{
    private $pdo;

    public function __construct()
    {
        $dbConfig = (require __DIR__ . '/../../config.php')['db'];
        $dsn = 'mysql:host=' . $dbConfig['host'] . ';port=' . $dbConfig['port'] . ';dbname=' . $dbConfig['dbname'] . ';charset=UTF8';

        $this->pdo = new \PDO($dsn, $dbConfig['user'], $dbConfig['password']);
        $this->pdo->exec('SET NAMES UTF8');
    }

    public function query(string $sql, array $params = [], string $className = 'stdClass')
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
        $callback();
        $this->pdo->commit();
    }

    public function getLastInsertId(): int
    {
        return (int) $this->pdo->lastInsertId();
    }
}
