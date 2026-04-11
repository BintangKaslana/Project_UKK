<?php
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: ' . BASE_PATH . '/admin/login');
    exit();
}
?>

<div class="max-w-md mx-auto">
    <h1 class="text-2xl font-bold text-[#4455DD] mb-6">Tambah Admin Baru</h1>
    <div class="bg-white rounded-xl shadow p-6">
        <form action="<?= BASE_PATH ?>/admin/save_admin" method="post" class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Username</label>
                <input type="text" name="username" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#4455DD]">
            </div>
            <p class="text-xs text-gray-500">Password default: <strong>12345</strong></p>
            <div class="flex gap-3">
                <button type="submit" class="bg-[#4455DD] text-white px-6 py-2 rounded-lg font-semibold hover:opacity-90 transition">
                    Simpan
                </button>
                <a href="<?= BASE_PATH ?>/admin/manage_admin" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-semibold hover:opacity-90 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>