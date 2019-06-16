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

        if (is_null($article)) {
            App::response()->setResponseCode(404);
            return App::view()->html('errors/404');
        }
        return App::view()->html('articles/single', compact('article'));
    }

    public function update($articleId)
    {
        $article = Article::getById($articleId);

        if (is_null($article)) {
            App::response()->setResponseCode(404);
            return App::view()->html('errors/404');
        }

        $article->name = 'arn';
        $article->text = 'sdfjhojfoihs';
        $article->save();

        return App::view()->html('articles/single', compact('article'));
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
        return App::view()->html('articles/single', compact('article'));
    }

    public function delete($articleId)
    {
        $article = Article::getById($articleId);

        if (is_null($article)) {
            App::response()->setResponseCode(404);
            return App::view()->html('errors/404');
        }

        $res = $article->delete();
        return App::view()->html('articles/deleted', compact('res'));
    }
}