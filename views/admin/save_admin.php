<?php
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: ' . BASE_PATH . '/admin/login');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_PATH . '/admin/add_admin');
    exit();
}
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
if ($username === '') {
    header('Location: ' . BASE_PATH . '/admin/add_admin');
    exit();
}
$defaultPassword = '12345';
$hash = password_hash($defaultPassword, PASSWORD_BCRYPT);

$stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
$stmt->execute([$username, $hash]);

header('Location: ' . BASE_PATH . '/admin/manage_admin');
exit();
