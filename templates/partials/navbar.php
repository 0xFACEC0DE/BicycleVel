<nav>
    <ul>
        <li><a href="/">Главная</a></li>
        <?php if ($user): ?>
            <li>Привет, <?= $user->name ?></li>
            <li><a href="/user/logout">Выйти</a></li>
        <?php else: ?>
            <li><a href="/user/signin">Войти</a></li>
            <li><a href="/user/signup">Рега</a></li>
        <?php endif; ?>
    </ul>
</nav>

