<?php
require_once dirname(__DIR__, 2) . '/app/bootstrap.php';

$sql = "SELECT ia.id, s.nis, s.full_name, s.class, k.category_name, ia.location, ia.description, a.aspiration_id, a.status, a.feedback
        FROM input_aspirasi ia
        JOIN siswa s ON ia.nis = s.nis
        JOIN kategori k ON ia.category_id = k.id
        JOIN aspirasi a ON ia.id = a.aspiration_id
        WHERE a.aspiration_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([intval($_GET['aspiration_id'])]);
$row = $stmt->fetch();
?>

<label>NIS</label>
<p><?php echo $row['nis']; ?></p>
<label>Nama Lengkap</label>
<p><?php echo $row['full_name']; ?></p>
<label>Kelas</label>
<p><?php echo $row['class']; ?></p>
<label>Kategori</label>
<p><?php echo $row['category_name']; ?></p>
<label>Lokasi</label>
<p><?php echo $row['location']; ?></p>
<label>Deskripsi</label>
<p><?php echo $row['description']; ?></p>

<form action="<?= BASE_PATH ?>/admin/update_aspirasi" method="post">
    <input type="hidden" name="aspiration_id" value="<?php echo $row['aspiration_id']; ?>">
    <label>Status</label>
    <select name="status" class="form-select mb-2">
        <option value="menunggu" <?php if ($row['status'] == 'menunggu') echo 'selected'; ?>>Menunggu</option>
        <option value="proses"   <?php if ($row['status'] == 'proses')   echo 'selected'; ?>>Proses</option>
        <option value="selesai"  <?php if ($row['status'] == 'selesai')  echo 'selected'; ?>>Selesai</option>
    </select>
    <label>Feedback</label>
    <textarea name="feedback" class="form-control mb-2" rows="5"><?php echo $row['feedback']; ?></textarea>
    <input type="submit" value="Update" class="btn btn-primary">
</form>
