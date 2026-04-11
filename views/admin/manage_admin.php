<?php
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: ' . BASE_PATH . '/admin/login');
    exit();
}
?>

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-[#4455DD]">Kelola Admin</h1>
    <a href="<?= BASE_PATH ?>/admin/add_admin"
       class="bg-[#4455DD] text-white px-4 py-2 rounded-lg text-sm font-semibold hover:opacity-90 transition">
        + Tambah Admin
    </a>
</div>

<div class="overflow-x-auto">
    <table class="w-full bg-white rounded-xl shadow text-sm">
        <thead>
            <tr class="bg-[#4455DD] text-white">
                <th class="px-4 py-3 text-left">No</th>
                <th class="px-4 py-3 text-left">Username</th>
                <th class="px-4 py-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $stmt = $conn->query("SELECT id, username FROM admin ORDER BY id ASC");
        $no = 1;
        while ($row = $stmt->fetch()) {
            echo "<tr class='border-t border-gray-100 hover:bg-gray-50'>";
            echo "<td class='px-4 py-3'>" . $no++ . "</td>";
            echo "<td class='px-4 py-3'>" . htmlspecialchars($row['username']) . "</td>";
            echo "<td class='px-4 py-3 flex gap-2'>
                    <a href='" . BASE_PATH . "/admin/edit_admin?id=" . $row['id'] . "'
                       class='bg-[#FFDD44] text-gray-800 px-3 py-1 rounded text-xs font-semibold hover:opacity-90 transition'>Edit</a>
                    <a href='" . BASE_PATH . "/admin/delete_admin?id=" . $row['id'] . "'
                       onclick=\"return confirm('Yakin hapus admin ini?')\"
                       class='bg-[#EE6666] text-white px-3 py-1 rounded text-xs font-semibold hover:opacity-90 transition'>Hapus</a>
                  </td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>