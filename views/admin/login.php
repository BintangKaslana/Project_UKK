<h1>Halaman Login</h1>
<form action="<?= BASE_PATH ?>/admin/authenticate" method="post">
    <label for="">Username</label>
    <input type="text" name="username" required>
    <br>
    <label for="">Password</label>
    <input type="password" name="password" required>
    <br>
    <input type="submit" value="Login">
</form>