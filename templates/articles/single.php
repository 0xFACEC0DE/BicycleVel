<td>
    <h1><?= $article->name ?></h1>
    <p><?= $article->text ?></p>
    <p><?= $article->getAuthor()->nickname ?></p>
    </br>
    <b>
        <a href="/articles/<?= $article->id ?>/delete">Delete this</a>
    </b>
</td>

