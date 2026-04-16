<?php
require_once dirname(__DIR__, 2) . '/app/bootstrap.php';
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: ' . BASE_PATH . '/admin/login'); exit();
}
if (($_SESSION['admin_role'] ?? '') !== 'head_admin') {
    header('Location: ' . BASE_PATH . '/admin?error=akses'); exit();
}

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header('Location: ' . BASE_PATH . '/admin/manage_kategori'); exit(); }

// Cek apakah kategori masih dipakai oleh aspirasi
$check = $conn->prepare("SELECT COUNT(*) AS total FROM input_aspirasi WHERE category_id = ?");
$check->execute([$id]);
$used = (int)$check->fetch()['total'];

if ($used > 0) {
    // Tidak bisa hapus karena masih ada aspirasi yang menggunakan kategori ini
    header('Location: ' . BASE_PATH . '/admin/manage_kategori?error=used');
    exit();
}

$stmt = $conn->prepare("DELETE FROM kategori WHERE id = ?");
$stmt->execute([$id]);
header('Location: ' . BASE_PATH . '/admin/manage_kategori?message=deleted');
exit();
