<?php   
$stmt   = $conn->query("SELECT id, category_name FROM kategori ORDER BY id");
$result = $stmt->fetchAll();

// Filter by NIS
$filterNis = isset($_GET['nis']) ? trim($_GET['nis']) : '';
$isFiltered = $filterNis !== '';

if ($isFiltered) {
    $sql = "SELECT ia.id, s.nis, s.full_name, s.class, k.category_name, ia.location, ia.description, a.status, a.feedback
            FROM input_aspirasi ia
            JOIN siswa s ON ia.nis = s.nis
            JOIN kategori k ON ia.category_id = k.id
            JOIN aspirasi a ON ia.id = a.aspiration_id
            WHERE s.nis = ?
            ORDER BY ia.id DESC";
    $stmt2 = $conn->prepare($sql);
    $stmt2->execute([$filterNis]);
} else {
    $sql = "SELECT ia.id, s.nis, s.full_name, s.class, k.category_name, ia.location, ia.description, a.status, a.feedback
            FROM input_aspirasi ia
            JOIN siswa s ON ia.nis = s.nis
            JOIN kategori k ON ia.category_id = k.id
            JOIN aspirasi a ON ia.id = a.aspiration_id
            ORDER BY ia.id DESC
            LIMIT 10";
    $stmt2 = $conn->query($sql);
}
$rows = $stmt2->fetchAll();
?>

<h1>Aplikasi Pengaduan Sarana Sekolah</h1>

<?php if (isset($_GET['message']) && $_GET['message'] === 'success') { ?>
    <div style="color:green; margin-bottom:10px;">Pengaduan berhasil dikirim!</div>
<?php } ?>

<form action="<?= BASE_PATH ?>/save_aspirasi" method="post">
    <label for="nis">NIS</label>
    <input type="text" name="nis"><br>
    <label for="full_name">Nama Lengkap</label>
    <input type="text" name="full_name"><br>
    <label for="class">Kelas</label>
    <input type="text" name="class"><br>
    <label for="category">Kategori</label>
    <select name="category" id="category">
        <?php foreach ($result as $row) { ?>
        <option value="<?php echo $row['id']; ?>">
            <?php echo $row['category_name']; ?>
        </option>
        <?php } ?>
    </select><br>
    <label for="location">Lokasi</label>
    <input type="text" name="location"><br>
    <label for="description">Deskripsi</label>
    <textarea name="description" id="description" cols="30" rows="10"></textarea><br>
    <input type="submit" value="submit">
</form>

<hr>

<h2>Cek Histori Pengaduan</h2>
<form action="" method="get">
    <label for="nis_filter">Masukkan NIS kamu:</label>
    <input type="text" name="nis" id="nis_filter" value="<?= htmlspecialchars($filterNis) ?>" placeholder="Contoh: 5757524">
    <button type="submit">Cari</button>
    <?php if ($isFiltered) { ?>
        <a href="<?= BASE_PATH ?>/">Tampilkan Semua</a>
    <?php } ?>
</form>

<br>

<?php if ($isFiltered && count($rows) === 0) { ?>
    <p>Tidak ada pengaduan ditemukan untuk NIS <strong><?= htmlspecialchars($filterNis) ?></strong>.</p>
<?php } else { ?>
    <p>
        <?php if ($isFiltered) { ?>
            Menampilkan semua pengaduan untuk NIS <strong><?= htmlspecialchars($filterNis) ?></strong>
        <?php } else { ?>
            Menampilkan <strong>10 pengaduan terbaru</strong>. Masukkan NIS untuk melihat histori milikmu.
        <?php } ?>
    </p>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
        <tr>
            <th>NIS</th>
            <th>Nama Lengkap</th>
            <th>Kelas</th>
            <th>Kategori</th>
            <th>Lokasi</th>
            <th>Deskripsi</th>
            <th>Status</th>
            <th>Feedback</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $row) { ?>
            <tr>
                <td><?= htmlspecialchars($row['nis']) ?></td>
                <td><?= htmlspecialchars($row['full_name']) ?></td>
                <td><?= htmlspecialchars($row['class']) ?></td>
                <td><?= htmlspecialchars($row['category_name']) ?></td>
                <td><?= htmlspecialchars($row['location']) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td><?= htmlspecialchars($row['status']) ?></td>
                <td><?= htmlspecialchars($row['feedback'] ?? '-') ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } ?>
