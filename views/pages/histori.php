<div class="max-w-4xl mx-auto px-4 py-10">
    <h2 class="text-3xl font-bold text-[#4455DD] mb-1">Histori Aspirasi</h2>
    <p class="text-gray-500 mb-6">Masukkan NIS kamu untuk melihat histori pengaduanmu.</p>

    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <form method="get" class="flex gap-3 items-end">
            <div class="flex-1">
                <label class="block text-sm font-semibold text-gray-700 mb-1">NIS</label>
                <input type="text" name="nis" placeholder="Contoh: 57575249"
                       value="<?= htmlspecialchars($_GET['nis'] ?? '') ?>"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#4455DD]">
            </div>
            <button type="submit"
                    class="bg-[#4455DD] text-white px-6 py-2 rounded-lg font-semibold hover:opacity-90 transition">
                Cari
            </button>
            <?php if (!empty($_GET['nis'])) { ?>
                <a href="/ukk_bintang_26/histori"
                   class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-semibold hover:opacity-90 transition">
                    Reset
                </a>
            <?php } ?>
        </form>
    </div>

    <?php
    $filterNis = trim($_GET['nis'] ?? '');
    if ($filterNis !== '') {
        $sql = "SELECT ia.id, s.nis, s.full_name, s.class, k.category_name, ia.location,
                       ia.description, a.status, a.feedback, ia.created_at
                FROM input_aspirasi ia
                JOIN siswa s ON ia.nis = s.nis
                JOIN kategori k ON ia.category_id = k.id
                JOIN aspirasi a ON ia.id = a.aspiration_id
                WHERE s.nis = ?
                ORDER BY ia.id DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$filterNis]);
        $rows = $stmt->fetchAll();

        if (count($rows) === 0) {
            echo "<div class='bg-[#FFDD44] text-gray-800 px-4 py-3 rounded-lg'>
                    Tidak ada pengaduan untuk NIS <strong>$filterNis</strong>.
                  </div>";
        } else {
            echo "<p class='text-gray-500 mb-3'>Menampilkan <strong>" . count($rows) . " pengaduan</strong> untuk NIS <strong>" . htmlspecialchars($filterNis) . "</strong></p>";
            echo "<div class='overflow-x-auto'>";
            echo "<table class='w-full bg-white rounded-xl shadow text-sm'>";
            echo "<thead><tr class='bg-[#4455DD] text-white'>
                    <th class='px-4 py-3 text-left rounded-tl-xl'>No</th>
                    <th class='px-4 py-3 text-left'>Kategori</th>
                    <th class='px-4 py-3 text-left'>Lokasi</th>
                    <th class='px-4 py-3 text-left'>Deskripsi</th>
                    <th class='px-4 py-3 text-left'>Status</th>
                    <th class='px-4 py-3 text-left'>Feedback</th>
                    <th class='px-4 py-3 text-left rounded-tr-xl'>Tanggal</th>
                  </tr></thead><tbody>";
            $no = 1;
            foreach ($rows as $row) {
                $statusClass = match($row['status']) {
                    'menunggu' => 'bg-[#FFDD44] text-gray-800',
                    'proses'   => 'bg-[#33AAEE] text-white',
                    'selesai'  => 'bg-[#BBDD22] text-gray-800',
                    default    => 'bg-gray-200 text-gray-800'
                };
                echo "<tr class='border-t border-gray-100 hover:bg-gray-50'>";
                echo "<td class='px-4 py-3'>" . $no++ . "</td>";
                echo "<td class='px-4 py-3'>" . htmlspecialchars($row['category_name']) . "</td>";
                echo "<td class='px-4 py-3'>" . htmlspecialchars($row['location']) . "</td>";
                echo "<td class='px-4 py-3'>" . htmlspecialchars($row['description']) . "</td>";
                echo "<td class='px-4 py-3'><span class='px-2 py-1 rounded-full text-xs font-semibold $statusClass'>" . ucfirst($row['status']) . "</span></td>";
                echo "<td class='px-4 py-3'>" . htmlspecialchars($row['feedback'] ?? '-') . "</td>";
                echo "<td class='px-4 py-3'>" . date('d-m-Y', strtotime($row['created_at'])) . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table></div>";
        }
    } else {
        echo "<div class='border-l-4 border-[#4455DD] bg-blue-50 px-4 py-3 rounded text-gray-700'>
                Masukkan NIS kamu di atas untuk melihat histori pengaduan.
              </div>";
    }
    ?>
</div>