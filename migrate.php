<?php
require_once __DIR__ . '/public/connection.php';

$migrations = [
    // Kolom admin: full_name & role
    "ALTER TABLE admin ADD COLUMN IF NOT EXISTS full_name VARCHAR(100) DEFAULT NULL",
    "ALTER TABLE admin ADD COLUMN IF NOT EXISTS role VARCHAR(20) NOT NULL DEFAULT 'admin' CHECK (role IN ('admin','head_admin'))",
    // Kolom aspirasi: review_status, is_anonim, feedback_by
    "ALTER TABLE aspirasi ADD COLUMN IF NOT EXISTS review_status VARCHAR(10) NOT NULL DEFAULT 'pending' CHECK (review_status IN ('pending','approved','rejected'))",
    "ALTER TABLE aspirasi ADD COLUMN IF NOT EXISTS is_anonim BOOLEAN NOT NULL DEFAULT FALSE",
    "ALTER TABLE aspirasi ADD COLUMN IF NOT EXISTS feedback_by INTEGER DEFAULT NULL REFERENCES admin(id) ON DELETE SET NULL",
    // Kolom input_aspirasi: bukti_foto
    "ALTER TABLE input_aspirasi ADD COLUMN IF NOT EXISTS bukti_foto VARCHAR(255) DEFAULT NULL",
    // Set admin pertama jadi head_admin jika belum ada head_admin
    "UPDATE admin SET role = 'head_admin' WHERE id = (SELECT id FROM admin ORDER BY id ASC LIMIT 1) AND NOT EXISTS (SELECT 1 FROM admin WHERE role = 'head_admin')",
];

$success = [];
$errors  = [];

foreach ($migrations as $sql) {
    try {
        $conn->exec($sql);
        $success[] = $sql;
    } catch (PDOException $e) {
        $errors[] = ['sql' => $sql, 'error' => $e->getMessage()];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><title>Migration</title>
<style>
  body { font-family: monospace; padding: 2rem; background: #f8f8f8; }
  h2   { color: #4455DD; }
  .ok  { background: #d4edda; border-left: 4px solid #28a745; padding: .5rem 1rem; margin: .4rem 0; border-radius: 4px; font-size:.85rem; }
  .err { background: #f8d7da; border-left: 4px solid #dc3545; padding: .5rem 1rem; margin: .4rem 0; border-radius: 4px; font-size:.85rem; }
  .note{ background: #fff3cd; border-left: 4px solid #ffc107; padding: .5rem 1rem; margin-top: 1.5rem; border-radius: 4px; }
</style>
</head>
<body>
<h2>🛠️ Database Migration</h2>
<?php foreach ($success as $sql): ?>
  <div class="ok">✅ <?= htmlspecialchars($sql) ?></div>
<?php endforeach; ?>
<?php foreach ($errors as $e): ?>
  <div class="err">❌ <?= htmlspecialchars($e['sql']) ?><br><small><?= htmlspecialchars($e['error']) ?></small></div>
<?php endforeach; ?>
<?php if (empty($errors)): ?>
  <div class="ok" style="margin-top:1rem"><strong>Semua migration berhasil!</strong></div>
<?php endif; ?>
<div class="note">⚠️ <strong>Hapus file ini setelah selesai:</strong> <code>migrate.php</code></div>
</body>
</html>
