<?php

namespace Bicycle\Controllers;

use Bicycle\Services\App;
use Bicycle\Models\Article;
use Bicycle\Models\User;

class ArticleController
{

    public function view(int $articleId)
    {
        $article = Article::getById($articleId);
        if ($article === null) {
            App::view()->renderHtml('errors/404', [], 404);
            return;
        }

        App::view()->renderHtml('articles/single', compact('article'));
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

        App::view()->renderHtml('articles/single', compact('article'));
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
        App::view()->renderHtml('articles/single', compact('article'));
    }

    public function delete($articleId)
    {
        $article = Article::getById($articleId);
        $res = $article->delete();
        App::view()->renderHtml('articles/deleted', compact('res'));
    }
}