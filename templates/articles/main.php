<div class="center">
    <?php foreach ($articles as $article): ?>
        <h2><a href="/articles/<?= $article->id ?>"><?= '#' . $article->id . ' ' . $article->name ?></a></h2>
        <p><?= $article->text ?></p>
        <hr>
    <?php endforeach; ?>
</div>>