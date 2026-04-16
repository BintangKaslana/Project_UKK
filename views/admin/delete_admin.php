<?php
require_once dirname(__DIR__, 2) . '/app/bootstrap.php';

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: ' . BASE_PATH . '/admin/login');
    exit();
}

// Hanya Head Admin yang bisa hapus admin
if (($_SESSION['admin_role'] ?? '') !== 'head_admin') {
    header('Location: ' . BASE_PATH . '/admin?error=akses');
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: ' . BASE_PATH . '/admin/manage_admin');
    exit();
}

// Tidak bisa hapus diri sendiri
if ($id === (int)$_SESSION['admin_id']) {
    header('Location: ' . BASE_PATH . '/admin/manage_admin?error=self');
    exit();
}

// Tidak bisa hapus jika target adalah satu-satunya head_admin tersisa
$stmtCek = $conn->prepare("SELECT role FROM admin WHERE id = ?");
$stmtCek->execute([$id]);
$target = $stmtCek->fetch();

if ($target && $target['role'] === 'head_admin') {
    $stmtCount = $conn->query("SELECT COUNT(*) AS total FROM admin WHERE role = 'head_admin'");
    $countHead = (int)$stmtCount->fetch()['total'];
    if ($countHead <= 1) {
        header('Location: ' . BASE_PATH . '/admin/manage_admin?error=last_head');
        exit();
    }
}

$stmt = $conn->prepare("DELETE FROM admin WHERE id = ?");
$stmt->execute([$id]);

header('Location: ' . BASE_PATH . '/admin/manage_admin?message=deleted');
exit();
