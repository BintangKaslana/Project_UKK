<?php
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: ' . BASE_PATH . '/admin/login'); exit();
}
if (($_SESSION['admin_role'] ?? '') !== 'head_admin') {
    header('Location: ' . BASE_PATH . '/admin?error=akses'); exit();
}
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header('Location: ' . BASE_PATH . '/admin/manage_kategori'); exit(); }

$stmt = $conn->prepare("SELECT id, category_name FROM kategori WHERE id = ?");
$stmt->execute([$id]);
$kat = $stmt->fetch();
if (!$kat) { header('Location: ' . BASE_PATH . '/admin/manage_kategori'); exit(); }
?>
<div class="max-w-md mx-auto">
    <h1 class="text-2xl font-bold text-[#4455DD] mb-6">Edit Kategori</h1>
    <div class="bg-white rounded-xl shadow p-6">
        <form action="<?= BASE_PATH ?>/admin/update_kategori" method="post" class="space-y-4">
            <input type="hidden" name="id" value="<?= $kat['id'] ?>">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Kategori</label>
                <input type="text" name="category_name" value="<?= htmlspecialchars($kat['category_name']) ?>" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#4455DD]">
            </div>
            <div class="flex gap-3">
                <button type="submit" class="bg-[#4455DD] text-white px-6 py-2 rounded-lg font-semibold hover:opacity-90 transition">Update</button>
                <a href="<?= BASE_PATH ?>/admin/manage_kategori" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-semibold hover:opacity-90 transition">Batal</a>
            </div>
        </form>
    </div>
</div>
