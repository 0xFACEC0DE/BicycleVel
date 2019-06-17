<?php

namespace Bicycle\Controllers;

use Bicycle\Services\App;
use Bicycle\Models\Article;
use Bicycle\Models\User;

class ArticleController
{

    public function view(int $articleId)
    {
        $article = Article::findOrDie($articleId);

        return App::view()->html('articles/single', compact('article'));
    }

    public function update($articleId)
    {
        $article = Article::findOrDie($articleId);

        $article->name = 'arn';
        $article->text = 'sdfjhojfoihs';
        $article->save();

        return App::view()->html('articles/single', compact('article'));
    }

    public function create($name)
    {
        $author = User::find(1);

        $article = new Article();
        $article->author_id = $author->id;
        $article->name = $name;
        $article->text = 'some text ' . $name;
        $article->save();

        $article = Article::findOrDie($article->id);
        return App::view()->html('articles/single', compact('article'));
    }

    public function delete($articleId)
    {
        $res = Article::findOrDie($articleId)->delete();
        return App::view()->html('articles/deleted', compact('res'));
    }
}