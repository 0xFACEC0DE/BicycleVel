<div class="center">
    <h1><?= $article->name ?></h1>
    <p><?= $article->text ?></p>
    <p><?= $article->getAuthor()->name ?></p>
    </br>
    <b>
        <a href="/articles/<?= $article->id ?>/delete">Delete this</a>
    </b>
</div>

