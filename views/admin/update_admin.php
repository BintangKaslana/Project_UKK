<?php
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: ' . BASE_PATH . '/admin/login');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_PATH . '/admin/manage_admin');
    exit();
}
$id       = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
if ($id <= 0 || $username === '') {
    header('Location: ' . BASE_PATH . '/admin/edit_admin?id=' . $id);
    exit();
}
$defaultPassword = '12345';
$hash = password_hash($defaultPassword, PASSWORD_BCRYPT);

$stmt = $conn->prepare("UPDATE admin SET username = ?, password = ? WHERE id = ?");
$stmt->execute([$username, $hash, $id]);

header('Location: ' . BASE_PATH . '/admin/manage_admin');
exit();
