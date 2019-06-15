<?php

namespace Bicycle\Controllers;

use Bicycle\Services\App;
use Bicycle\Models\Article;

class MainController
{

    public function main()
    {
        $articles = Article::findAll();
        App::view()->renderHtml('articles/main', compact('articles'));
    }

}