<div class="center">
    <h1>Authorization</h1>
    <form action="/user/login" method="post">
        <div>
            <label>Email</label>
            <input type="email" name="email" value="<?= $previous['email'] ?? '' ?>" required>
        </div>
        <br>
        <div>
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <br>
        <input type="submit" value="SIGN IN">
    </form>
</div>