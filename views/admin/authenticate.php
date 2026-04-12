<?php
require_once dirname(__DIR__, 2) . '/app/bootstrap.php';

// Hanya boleh diakses via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_PATH . '/admin/login');
    exit();
}

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if (empty($username) || empty($password)) {
    header('Location: ' . BASE_PATH . '/admin/login?error=1');
    exit();
}

$stmt = $conn->prepare("SELECT password FROM admin WHERE username = ? LIMIT 1");
$stmt->execute([$username]);
$row = $stmt->fetch();

if ($row && password_verify($password, $row['password'])) {
    $_SESSION['admin_logged_in'] = true;
    header('Location: ' . BASE_PATH . '/admin');
    exit();
}

header('Location: ' . BASE_PATH . '/admin/login?error=1');
exit();
