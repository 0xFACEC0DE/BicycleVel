<?php

namespace Bicycle\Models;

use Bicycle\Lib\App;

/**
 * Class ActiveRecordEntity
 * @package Bicycle\Models
 */
abstract class ActiveRecordEntity
{
    /**
     * @var string Db table name for model
     */
    protected static $table;

    /** @var int */
    public $id;

    public static function findAll(): array
    {
        return App::db()->query('SELECT * FROM `' . static::$table . '`;', [], static::class);
    }

    public static function find($value, string $property = 'id')
    {
        $property = '`'. $property .'`';
        $entities = App::db()->query(
            "SELECT * FROM `" . static::$table . "` WHERE $property = :val;",
            [ ':val' => $value],
            static::class
        );
        return $entities;
    }

    public static function findOne($value, string $property = 'id')
    {
        $entities = self::find($value, $property);
        return !empty($entities) ? $entities[0] : null;
    }

    public static function findOrDie($value, string $property = 'id', string $message = ''): self
    {
        if (!$item = static::findOne($value, $property)) {
            App::abortWithErrorPage($message, 404);
        }
        return $item;
    }

    protected function getProperties()
    {
        $reflector = new \ReflectionObject($this);
        foreach ($reflector->getProperties() as $property) {
            if (!$property->isStatic()) {
                $properties[$property->getName()] = $property->getValue($this);
            }
        }
        return $properties;
    }

    public function save()
    {
        $properties = $this->getProperties();
        return isset($properties['id']) ? $this->update($properties) : $this->insert($properties);
    }

    private function insert($properties)
    {
        $columns = [];
        $paramNames = [];
        $paramBindings = [];
        foreach ($properties as $col => $value) {
            $columns[] = '`'. $col .'`';
            $paramName = ':' . $col;
            $paramNames[] = $paramName;
            $paramBindings[$paramName] = $value;
        }
        $columnsString = implode(', ', $columns);
        $paramsString = implode(', ', $paramNames);
        $tableName = static::$table;

        $sql = "INSERT INTO `$tableName` ( $columnsString ) VALUES ( $paramsString );";

        if ($result = App::db()->exec($sql, $paramBindings)) {
            $this->id = App::db()->getLastInsertId();
        }

        return $result;
    }

    private function update($properties)
    {
        $columnsAndParams = [];
        $paramBindings = [];
        $tableName = static::$table;
        $id = $this->id;

        foreach ($properties as $column => $value) {
            $param = ':' . $column;
            $columnsAndParams[] = "`$column` = $param";
            $paramBindings[$param] = $value;
        }

        $colAndParamString = implode(', ', $columnsAndParams);
        $sql = "UPDATE `$tableName` SET $colAndParamString WHERE `id` = $id ;";

        return App::db()->exec($sql, $paramBindings);
    }

    public function delete()
    {
        $table = static::$table;
        $sql = "DELETE FROM `$table` WHERE id = :id";
        $result = App::db()->exec($sql, [':id' => $this->id]);

        $this->id = null;
        return $result;
    }
}