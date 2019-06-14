<?php

namespace App\Controllers;

use App\Services\App;
use App\Models\Article;

class MainController
{
    private $view;
    private $db;

    public function __construct()
    {
        $this->view = App::get('View');
        $this->db = App::get('Db');
    }

    public function main()
    {
        $articles = Article::findAll();
        $this->view->renderHtml('articles/main', ['articles' => $articles]);
    }

}