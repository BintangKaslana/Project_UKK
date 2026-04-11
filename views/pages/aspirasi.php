<?php
$stmt = $conn->query("SELECT id, category_name FROM kategori ORDER BY id");
$result = $stmt->fetchAll();
?>

<div class="max-w-2xl mx-auto px-4 py-10">
    <h2 class="text-3xl font-bold text-[#4455DD] mb-1">Sampaikan Aspirasi</h2>
    <p class="text-gray-500 mb-6">Isi form di bawah ini untuk menyampaikan pengaduanmu.</p>

    <?php if (isset($_GET['message']) && $_GET['message'] === 'success') { ?>
        <div class="bg-[#BBDD22] text-gray-800 px-4 py-3 rounded-lg mb-4">
            ✅ Pengaduan berhasil dikirim!
        </div>
    <?php } ?>

    <div class="bg-white rounded-xl shadow p-6">
        <form action="/ukk_bintang_26/save_aspirasi" method="post" class="space-y-4">
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">NIS</label>
                    <input type="number" name="nis" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#4455DD]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="full_name" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#4455DD]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kelas</label>
                    <input type="text" name="class" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#4455DD]">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                    <select name="category" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#4455DD]">
                        <?php foreach ($result as $row) { ?>
                            <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['category_name']) ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Lokasi</label>
                    <input type="text" name="location" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#4455DD]">
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="5" required
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#4455DD]"></textarea>
            </div>
            <button type="submit"
                    class="bg-[#4455DD] text-white px-6 py-2 rounded-lg font-semibold hover:opacity-90 transition">
                Kirim Pengaduan
            </button>
        </form>
    </div>
</div>