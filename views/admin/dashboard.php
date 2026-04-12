<?php
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: ' . BASE_PATH . '/admin/login');
    exit();
}

$filterKategori = isset($_GET['kategori']) ? trim($_GET['kategori']) : '';
$filterNis      = isset($_GET['nis']) ? trim($_GET['nis']) : '';
$filterBulan    = isset($_GET['bulan']) ? trim($_GET['bulan']) : '';
$filterTanggal  = isset($_GET['tanggal']) ? trim($_GET['tanggal']) : '';
$filterStatus   = isset($_GET['status']) ? trim($_GET['status']) : '';

$sql = "SELECT ia.id, s.nis, s.full_name, s.class, k.category_name, ia.location, ia.description, a.aspiration_id, a.status, a.feedback, ia.created_at
    FROM input_aspirasi ia
    JOIN siswa s ON ia.nis = s.nis
    JOIN kategori k ON ia.category_id = k.id
    JOIN aspirasi a ON ia.id = a.aspiration_id
    WHERE 1=1";

$params = [];
if ($filterKategori !== '') { $sql .= " AND k.id = ?";                              $params[] = $filterKategori; }
if ($filterNis !== '')      { $sql .= " AND s.nis = ?";                              $params[] = $filterNis; }
if ($filterBulan !== '')    { $sql .= " AND TO_CHAR(ia.created_at, 'YYYY-MM') = ?"; $params[] = $filterBulan; }
if ($filterTanggal !== '')  { $sql .= " AND DATE(ia.created_at) = ?";               $params[] = $filterTanggal; }
if ($filterStatus !== '')   { $sql .= " AND a.status = ?";                           $params[] = $filterStatus; }
$sql .= " ORDER BY ia.id DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
?>

<?php if (isset($_GET['message']) && $_GET['message'] === 'updated') { ?>
    <div class="bg-[#BBDD22] text-gray-800 px-4 py-3 rounded-lg mb-4">Aspirasi berhasil diperbarui.</div>
<?php } ?>

<h2 class="text-2xl font-bold text-[#4455DD] mb-4">Daftar Aspirasi Siswa</h2>

<form method="get" class="bg-white rounded-xl shadow p-4 mb-6 flex flex-wrap gap-3 items-end">
    <div>
        <label class="block text-xs font-semibold text-gray-600 mb-1">Kategori</label>
        <select name="kategori" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#4455DD]">
            <option value="">PILIH KATEGORI</option>
            <?php
            $kStmt = $conn->query("SELECT id, category_name FROM kategori ORDER BY id");
            foreach ($kStmt->fetchAll() as $k) {
                $selected = $filterKategori == $k['id'] ? 'selected' : '';
                echo "<option value='" . htmlspecialchars($k['id']) . "' $selected>" . htmlspecialchars($k['category_name']) . "</option>";
            }
            ?>
        </select>
    </div>
    <div>
        <label class="block text-xs font-semibold text-gray-600 mb-1">NIS</label>
        <input type="text" name="nis" placeholder="Filter NIS..." value="<?= htmlspecialchars($filterNis) ?>"
               class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#4455DD]">
    </div>
    <div>
        <label class="block text-xs font-semibold text-gray-600 mb-1">Status</label>
        <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#4455DD]">
            <option value=""></option>
            <option value="menunggu" <?= $filterStatus === 'menunggu' ? 'selected' : '' ?>>MENUNGGU</option>
            <option value="proses"   <?= $filterStatus === 'proses'   ? 'selected' : '' ?>>PROSES</option>
            <option value="selesai"  <?= $filterStatus === 'selesai'  ? 'selected' : '' ?>>SELESAI</option>
        </select>
    </div>
    <div>
        <label class="block text-xs font-semibold text-gray-600 mb-1">Bulan</label>
        <input type="month" name="bulan" value="<?= htmlspecialchars($filterBulan) ?>"
               class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#4455DD]">
    </div>
    <div>
        <label class="block text-xs font-semibold text-gray-600 mb-1">Tanggal</label>
        <input type="date" name="tanggal" value="<?= htmlspecialchars($filterTanggal) ?>"
               class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#4455DD]">
    </div>
    <button type="submit" class="bg-[#4455DD] text-white px-4 py-2 rounded-lg text-sm font-semibold hover:opacity-90 transition">Filter</button>
    <a href="<?= BASE_PATH ?>/admin" class="bg-[#EE6666] text-white px-4 py-2 rounded-lg text-sm font-semibold hover:opacity-90 transition">Reset</a>
</form>

<div class="overflow-x-auto">
    <table class="w-full bg-white rounded-xl shadow text-sm">
        <thead>
            <tr class="bg-[#4455DD] text-white">
                <th class="px-4 py-3 text-left">NO</th>
                <th class="px-4 py-3 text-left">NIS</th>
                <th class="px-4 py-3 text-left">NAMA</th>
                <th class="px-4 py-3 text-left">KELAS</th>
                <th class="px-4 py-3 text-left">KATEGORI</th>
                <th class="px-4 py-3 text-left">LOKASI</th>
                <th class="px-4 py-3 text-left">DESKRIPSI</th>
                <th class="px-4 py-3 text-left">STATUS</th>
                <th class="px-4 py-3 text-left">FEEDBACK</th>
                <th class="px-4 py-3 text-left">TANGGAL</th>
                <th class="px-4 py-3 text-left">TINDAKAN</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        while ($row = $stmt->fetch()) {
            $statusClass = match($row['status']) {
                'menunggu' => 'bg-[#FFDD44] text-gray-800',
                'proses'   => 'bg-[#33AAEE] text-white',
                'selesai'  => 'bg-[#BBDD22] text-gray-800',
                default    => 'bg-gray-200 text-gray-800'
            };
            echo "<tr class='border-t border-yellow-green-100 hover:bg-gray-50'>";
            echo "<td class='px-4 py-3'>" . $no++ . "</td>";
            echo "<td class='px-4 py-3'>" . htmlspecialchars($row['nis']) . "</td>";
            echo "<td class='px-4 py-3'>" . htmlspecialchars($row['full_name']) . "</td>";
            echo "<td class='px-4 py-3'>" . htmlspecialchars($row['class']) . "</td>";
            echo "<td class='px-4 py-3'>" . htmlspecialchars($row['category_name']) . "</td>";
            echo "<td class='px-4 py-3'>" . htmlspecialchars($row['location']) . "</td>";
            echo "<td class='px-4 py-3'>" . htmlspecialchars($row['description']) . "</td>";
            echo "<td class='px-4 py-3'><span class='px-2 py-1 rounded-full text-xs font-semibold $statusClass'>" . ucfirst(htmlspecialchars($row['status'])) . "</span></td>";
            echo "<td class='px-4 py-3'>" . htmlspecialchars($row['feedback'] ?: '-') . "</td>";
            echo "<td class='px-4 py-3'>" . date('d-m-Y', strtotime($row['created_at'])) . "</td>";
            echo "<td class='px-4 py-3'>
                    <a href='" . BASE_PATH . "/admin/edit_aspirasi?aspiration_id=" . intval($row['aspiration_id']) . "'
                       class='bg-[#FFDD44] text-gray-800 px-3 py-1 rounded text-xs font-semibold hover:opacity-90 transition'>Edit</a>
                  </td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>
