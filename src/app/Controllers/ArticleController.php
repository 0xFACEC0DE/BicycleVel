<?php

namespace App\Controllers;

use App\Services\App;
use App\Models\Article;
use App\Models\User;

class ArticleController
{
    /** @var View */
    private $view;

    /** @var Db */
    private $db;

    public function __construct()
    {
        $this->view = App::get('View');
        $this->db = App::get('Db');
    }

    public function view(int $articleId)
    {
        $article = Article::getById($articleId);
        if ($article === null) {
            $this->view->renderHtml('errors/404', [], 404);
            return;
        }

        $this->view->renderHtml('articles/single', ['article' => $article]);
    }
}