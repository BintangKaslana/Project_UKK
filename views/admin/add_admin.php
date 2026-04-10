<?php
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: ' . BASE_PATH . '/admin/login');
    exit();
}
?>
<h1>Tambah Admin Baru</h1>
<form action="<?= BASE_PATH ?>/admin/save_admin" method="post">
    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>
    <input type="submit" value="Simpan Admin">
</form>
