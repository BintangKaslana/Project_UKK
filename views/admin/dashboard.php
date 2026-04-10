<?php
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: ' . BASE_PATH . '/admin/login');
    exit();
}

// Filter
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

if ($filterKategori !== '') {
    $sql .= " AND k.id = ?";
    $params[] = $filterKategori;
}

if ($filterNis !== '') {
    $sql .= " AND s.nis = ?";
    $params[] = $filterNis;
}

if ($filterBulan !== '') {
    $sql .= " AND TO_CHAR(ia.created_at, 'YYYY-MM') = ?";
    $params[] = $filterBulan;
}

if ($filterTanggal !== '') {
    $sql .= " AND DATE(ia.created_at) = ?";
    $params[] = $filterTanggal;
}

if ($filterStatus !== '') {
    $sql .= " AND a.status = ?";
    $params[] = $filterStatus;
}

$sql .= " ORDER BY ia.id DESC";
$stmt = $conn->prepare($sql);
$stmt->execute($params);
?>

<?php if (isset($_GET['message']) && $_GET['message'] === 'updated') { ?>
    <div class="alert alert-success">Aspirasi berhasil diperbarui.</div>
<?php } ?>

<h2>Daftar Aspirasi Siswa</h2>

<form method="get" class="mb-3 row g-2 align-items-center">
    <div class="col-auto">
        <select name="kategori" class="form-select">
            <option value="">Semua Kategori</option>
            <?php
            $kStmt = $conn->query("SELECT id, category_name FROM kategori ORDER BY id");
            foreach ($kStmt->fetchAll() as $k) {
                $selected = $filterKategori == $k['id'] ? 'selected' : '';
                echo "<option value='{$k['id']}' $selected>{$k['category_name']}</option>";
            }
            ?>
        </select>
    </div>
    <div class="col-auto">
        <input type="text" name="nis" class="form-control" placeholder="Filter NIS..." value="<?= htmlspecialchars($filterNis) ?>">
    </div>
    <div class="col-auto">
        <select name="status" class="form-select">
            <option value="">Semua Status</option>
            <option value="menunggu" <?= $filterStatus === 'menunggu' ? 'selected' : '' ?>>Menunggu</option>
            <option value="proses"   <?= $filterStatus === 'proses'   ? 'selected' : '' ?>>Proses</option>
            <option value="selesai"  <?= $filterStatus === 'selesai'  ? 'selected' : '' ?>>Selesai</option>
        </select>
    </div>
    <div class="col-auto">
        <input type="month" name="bulan" class="form-control" value="<?= htmlspecialchars($filterBulan) ?>">
    </div>
    <div class="col-auto">
        <input type="date" name="tanggal" class="form-control" value="<?= htmlspecialchars($filterTanggal) ?>">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="<?= BASE_PATH ?>/admin" class="btn btn-secondary">Reset</a>
    </div>
</form>

<table class="table table-bordered table-striped">
    <thead>
    <tr class="text-nowrap">
        <th>No</th>
        <th>NIS</th>
        <th>Nama Lengkap</th>
        <th>Kelas</th>
        <th>Kategori</th>
        <th>Lokasi</th>
        <th>Deskripsi</th>
        <th>Status</th>
        <th>Feedback</th>
        <th>Tanggal</th>
        <th>Aksi</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $no = 1;
    while ($row = $stmt->fetch()) {
        echo "<tr>";
        echo "<td>" . $no++ . "</td>";
        echo "<td>" . $row['nis'] . "</td>";
        echo "<td>" . $row['full_name'] . "</td>";
        echo "<td>" . $row['class'] . "</td>";
        echo "<td>" . $row['category_name'] . "</td>";
        echo "<td>" . $row['location'] . "</td>";
        echo "<td>" . $row['description'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "<td>" . $row['feedback'] . "</td>";
        echo "<td>" . date('d-m-Y H:i', strtotime($row['created_at'])) . "</td>";
        echo "<td>
                <a href='" . BASE_PATH . "/admin/edit_aspirasi?aspiration_id=" . $row['aspiration_id'] . "' class='btn btn-sm btn-warning'>Edit</a>
              </td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>