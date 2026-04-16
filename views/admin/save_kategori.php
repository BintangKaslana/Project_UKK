<?php
require_once dirname(__DIR__, 2) . '/app/bootstrap.php';
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: ' . BASE_PATH . '/admin/login'); exit();
}
if (($_SESSION['admin_role'] ?? '') !== 'head_admin') {
    header('Location: ' . BASE_PATH . '/admin?error=akses'); exit();
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_PATH . '/admin/manage_kategori'); exit();
}

$name = trim($_POST['category_name'] ?? '');
if ($name === '') {
    header('Location: ' . BASE_PATH . '/admin/manage_kategori'); exit();
}

$stmt = $conn->prepare("INSERT INTO kategori (category_name) VALUES (?)");
$stmt->execute([$name]);
header('Location: ' . BASE_PATH . '/admin/manage_kategori?message=saved');
exit();
