<?php

namespace Bicycle\Controllers;

use Bicycle\Models\Article;
use Bicycle\Models\User;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::findAll();
        return view()->layoutHtml('articles/main', compact('articles'));
    }

    public function view(int $articleId)
    {
        $article = Article::findOrDie($articleId);
        return view()->layoutHtml('articles/single', compact('article'));
    }

    public function update($articleId)
    {
        $article = Article::findOrDie($articleId);

        $article->name = 'arn';
        $article->text = 'sdfjhojfoihs';
        $article->save();

        return view()->layoutHtml('articles/single', compact('article'));
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
        return view()->layoutHtml('articles/single', compact('article'));
    }

    public function delete($articleId)
    {
        $res = Article::findOrDie($articleId)->delete();
        return view()->layoutHtml('articles/deleted', compact('res'));
    }
}