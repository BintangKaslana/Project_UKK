<?php
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: ' . BASE_PATH . '/admin/login');
    exit();
}
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: ' . BASE_PATH . '/admin/manage_admin');
    exit();
}
$stmt = $conn->prepare("SELECT id, username FROM admin WHERE id = ?");
$stmt->execute([$id]);
$admin = $stmt->fetch();
if (!$admin) {
    header('Location: ' . BASE_PATH . '/admin/manage_admin');
    exit();
}
?>
<h1>Edit Admin</h1>
<form action="<?= BASE_PATH ?>/admin/update_admin" method="post">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
    <label>Username:</label><br>
    <input type="text" name="username" value="<?php echo htmlspecialchars($admin['username']); ?>" required><br><br>
    <input type="submit" value="Update Admin">
</form>
