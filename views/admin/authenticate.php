<?php
session_start();
require_once dirname(__DIR__, 2) . '/app/bootstrap.php';

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

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
