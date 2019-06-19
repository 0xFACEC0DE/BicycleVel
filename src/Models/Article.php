<?php

namespace Bicycle\Models;

use Bicycle\Models\Users\User;

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
    public $author_id;

    /** @var string */
    public $created_at;

    public function getAuthor()
    {
        return User::findOrDie($this->author_id);
    }
}