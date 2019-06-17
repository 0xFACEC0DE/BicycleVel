<td style="text-align: center;">
    <h1>Регистрация</h1>
    <?php if (!empty($error)): ?>
    <div style="padding: 5px;margin: 15px;color: crimson; font-weight: bold;"><?= $error ?></div>
    <?php endif; ?>
    <form action="/register" method="post">
        <label>Nickname <input type="text" name="nickname" value="<?= $_POST['nickname'] ?? ''?>"></label>
        <br><br>
        <label>Email <input type="email" name="email" value="<?= $_POST['email'] ?? ''?>"></label>
        <br><br>
        <label>Password <input type="password" name="password"></label>
        <br><br>
        <input type="submit" value="Зарегистрироваться">
    </form>
</td>