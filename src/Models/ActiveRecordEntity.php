<?php

namespace Bicycle\Models;

use Bicycle\Services\App;

abstract class ActiveRecordEntity
{
    /**
     * @var string Db table name for model
     */
    protected static $table;

    /** @var int */
    public $id;


    /**
     * @return mixed
     */
    public static function findAll()
    {
        return App::db()->query('SELECT * FROM `' . static::$table . '`', [], static::class);
    }

    /**
     * @param int $id
     * @return static|null
     */
    public static function getById(int $id): ?self
    {
        $entities = App::db()->query(
            'SELECT * FROM `' . static::$table . '` WHERE id = :id;',
            [':id' => $id],
            static::class
        );
        return $entities ? $entities[0] : null;
    }


    /**
     * Get array of colunm names and not null values from current model
     * @return array|\ReflectionProperty[]
     */
    protected function getProperties()
    {
        $reflector = new \ReflectionObject($this);
        $propertyObjects = $reflector->getProperties();
        $properties = [];

        foreach ($propertyObjects as $property) {
            $name = $property->getName();
            @$value = $this->$name;
            //skip null values
            if (is_null($value)) continue;

            $properties[$name] = $value;
        }
        return $properties;
    }

    /**
     * @return bool Db query result
     */
    public function save()
    {
        $properties = $this->getProperties();
        return isset($properties['id']) ? $this->update($properties) : $this->insert($properties);
    }

    /**
     * @param array $properties
     * @return bool
     */
    private function update($properties)
    {
        unset($properties['id']); // not update autoincremented value
        $columnsAndParams = [];
        $paramBindings = [];

        foreach ($properties as $column => $value) {
            $param = ':' . $column;
            $columnsAndParams[] = "`$column` = $param";
            $paramBindings[$param] = $value;
        }
        $tableName = static::$table;
        $colAndParamString = implode(', ', $columnsAndParams);
        $id = $this->id;

        $sql = "UPDATE `$tableName` SET $colAndParamString WHERE `id` = $id ;";

        return App::db()->exec($sql, $paramBindings);
    }

    /**
     * @param array $properties
     * @return bool
     */
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

        $result = App::db()->exec($sql, $paramBindings);
        $this->id = App::db()->getLastInsertId();
        return $result;
    }

    /**
     * @return bool
     */
    public function delete()
    {
        $table = static::$table;
        $sql = "DELETE FROM `$table` WHERE id = :id";
        $result = App::db()->exec($sql, [':id' => $this->id]);
        $this->id = null;
        return $result;
    }
}