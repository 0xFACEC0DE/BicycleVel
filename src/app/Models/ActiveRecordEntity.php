<?php

namespace App\Models;

use App\Services\App;

abstract class ActiveRecordEntity
{
    protected static $table;

    /** @var int */
    public $id;

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    /**
     * @param string $source
     * @return string
     */
    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    public static function findAll()
    {
        return App::get('Db')->query('SELECT * FROM `' . static::$table . '`', [], static::class);
    }

    /**
     * @param int $id
     * @return static|null
     */
    public static function getById(int $id): ?self
    {
        $entities = App::get('Db')->query(
            'SELECT * FROM `' . static::$table . '` WHERE id = :id;',
            [':id' => $id],
            static::class
        );
        return $entities ? $entities[0] : null;
    }
}