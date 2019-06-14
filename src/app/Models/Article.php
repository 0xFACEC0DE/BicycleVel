<?php

namespace App\Models;

/**
 * Class Article
 * @package App\Models
 */
class Article extends ActiveRecordEntity
{
    protected static $table = 'articles';

    /** @var string */
    public $name;

    /** @var string */
    public $text;

    /** @var string */
    public $authorId;

    /** @var string */
    public $createdAt;

    public function getAuthor()
    {
        return User::getById($this->authorId);
    }
}