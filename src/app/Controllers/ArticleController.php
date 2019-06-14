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
        $this->view = App::view();
        $this->db = App::db();
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

    public function update($articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            App::view()->renderHtml('errors/404.php', [], 404);
            return;
        }

        $article->name = 'arn';
        $article->text = 'sdfjhojfoihs';
        $article->save();

        App::view()->renderHtml('articles/single', ['article' => $article]);
    }

    public function create($name)
    {
        $author = User::getById(1);

        $article = new Article();
        $article->author_id = $author->id;
        $article->name = $name;
        $article->text = 'some text ' . $name;
        $article->save();

        $article = Article::getById($article->id);
        App::view()->renderHtml('articles/single', ['article' => $article]);
    }
}