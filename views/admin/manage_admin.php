<?php
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: ' . BASE_PATH . '/admin/login');
    exit();
}
?>
<h1>Kelola Admin</h1>
<a href="<?= BASE_PATH ?>/admin/add_admin">Tambah Admin Baru</a>
<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>Username</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $stmt = $conn->query("SELECT id, username FROM admin ORDER BY id ASC");
        while ($row = $stmt->fetch()) {
            echo "<tr>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>
                    <a href='" . BASE_PATH . "/admin/edit_admin?id=" . urlencode($row['id']) . "'>Edit</a> |
                    <a href='" . BASE_PATH . "/admin/delete_admin?id=" . urlencode($row['id']) . "'>Delete</a>
                  </td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
