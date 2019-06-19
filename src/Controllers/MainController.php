<?php

namespace Bicycle\Controllers;

use Bicycle\Lib\App;
use Bicycle\Models\Article;

class MainController
{

    public function index()
    {
        $articles = Article::findAll();
        return App::view()->html('articles/main', compact('articles'));
    }

}