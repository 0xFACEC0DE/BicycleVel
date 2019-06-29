<div class="center">
    <h1>Registration</h1>
    <form action="/user/register" method="post">
        <label>Email <input type="email" name="email" value="<?= $previous['email'] ?? ''?>" required></label>
        <br>
        <label>Name <input type="text" name="name" value="<?= $previous['name'] ?? ''?>" required></label>
        <br>
        <label>Password <input type="password" name="password" required></label>
        <br>
        <input type="submit" value="SIGN UP">
    </form>
</div>