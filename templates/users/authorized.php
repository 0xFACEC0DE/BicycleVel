<div class="center">
    <h1>Authorized successfully</h1>
    <p>your email: <b><?= $user->email ?? ''; ?></b> </p>
    <p>your name: <b><?= $user->name ?? ''; ?></b> </p>
    <a href="/user/logout"> <b>LOGOUT</b> </a>
</div>
