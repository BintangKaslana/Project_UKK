<?php
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: ' . BASE_PATH . '/admin/login');
    exit();
}
// Hanya Head Admin
if (($_SESSION['admin_role'] ?? '') !== 'head_admin') {
    header('Location: ' . BASE_PATH . '/admin?error=akses');
    exit();
}

$stmt = $conn->query("SELECT id, category_name FROM kategori ORDER BY id ASC");
$kategoriList = $stmt->fetchAll();
?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-[#4455DD]">Kelola Kategori</h1>
        <p class="text-gray-500 text-sm mt-0.5">Tambah, ubah, atau hapus kategori laporan aspirasi.</p>
    </div>
</div>

<?php if (isset($_GET['message']) && $_GET['message'] === 'saved'): ?>
    <div class="bg-[#BBDD22] text-gray-800 px-4 py-3 rounded-lg mb-4 text-sm font-semibold">✅ Kategori berhasil ditambahkan.</div>
<?php endif; ?>
<?php if (isset($_GET['message']) && $_GET['message'] === 'updated'): ?>
    <div class="bg-[#33AAEE] text-white px-4 py-3 rounded-lg mb-4 text-sm font-semibold">✅ Kategori berhasil diperbarui.</div>
<?php endif; ?>
<?php if (isset($_GET['message']) && $_GET['message'] === 'deleted'): ?>
    <div class="bg-[#EE6666] text-white px-4 py-3 rounded-lg mb-4 text-sm font-semibold">🗑️ Kategori berhasil dihapus.</div>
<?php endif; ?>
<?php if (isset($_GET['error']) && $_GET['error'] === 'used'): ?>
    <div class="bg-[#FFDD44] text-gray-800 px-4 py-3 rounded-lg mb-4 text-sm font-semibold">⚠️ Kategori tidak bisa dihapus karena masih digunakan oleh aspirasi.</div>
<?php endif; ?>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Form Tambah Kategori -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-base font-bold text-[#4455DD] mb-4">+ Tambah Kategori Baru</h2>
        <form action="<?= BASE_PATH ?>/admin/save_kategori" method="post" class="flex gap-3">
            <input type="text" name="category_name" required placeholder="Nama kategori baru..."
                   class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#4455DD]">
            <button type="submit"
                    class="bg-[#4455DD] text-white px-4 py-2 rounded-lg text-sm font-semibold hover:opacity-90 transition whitespace-nowrap">
                Simpan
            </button>
        </form>
    </div>

    <!-- Daftar Kategori -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-base font-bold text-[#4455DD] mb-4">Daftar Kategori (<?= count($kategoriList) ?>)</h2>
        <?php if (count($kategoriList) === 0): ?>
            <p class="text-gray-400 text-sm">Belum ada kategori.</p>
        <?php else: ?>
        <ul class="divide-y divide-gray-100">
            <?php foreach ($kategoriList as $k): ?>
            <li class="flex items-center justify-between py-2 gap-2">
                <span class="text-sm text-gray-800 font-medium"><?= htmlspecialchars($k['category_name']) ?></span>
                <div class="flex gap-2 shrink-0">
                    <a href="<?= BASE_PATH ?>/admin/edit_kategori?id=<?= $k['id'] ?>"
                       class="bg-[#FFDD44] text-gray-800 px-3 py-1 rounded text-xs font-semibold hover:opacity-90 transition">Edit</a>
                    <a href="<?= BASE_PATH ?>/admin/delete_kategori?id=<?= $k['id'] ?>"
                       onclick="return confirm('Hapus kategori ini? Tidak bisa dihapus jika masih ada aspirasi yang menggunakannya.')"
                       class="bg-[#EE6666] text-white px-3 py-1 rounded text-xs font-semibold hover:opacity-90 transition">Hapus</a>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>
</div>
