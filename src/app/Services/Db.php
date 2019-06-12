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

    public function query(string $sql, $params = []): ?array
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if (false === $result) {
            return null;
        }

        return $sth->fetchAll();
    }
}
