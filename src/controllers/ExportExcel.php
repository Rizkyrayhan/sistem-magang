<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../src/helpers/helper.php';

if (!isAdmin()) die('Unauthorized');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Laporan_Pendaftar_Magang_' . date('d-m-Y') . '.xls"');

echo "<table border='1'>";
echo "<tr style='background:#1d4ed8;color:white;font-weight:bold'>
        <th>No</th><th>Nama</th><th>Email</th><th>NIM</th><th>Universitas</th><th>Jurusan</th>
        <th>No HP</th><th>Bidang Minat</th><th>Status</th><th>Tanggal Daftar</th>
      </tr>";

$no = 1;
$result = $conn->query("SELECT p.*, u.nama, u.email FROM pendaftar p JOIN users u ON p.user_id = u.id ORDER BY p.tanggal_daftar DESC");
while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>$no</td>
            <td>" . htmlspecialchars($row['nama']) . "</td>
            <td>" . $row['email'] . "</td>
            <td>" . ($row['nim'] ?: '-') . "</td>
            <td>" . ($row['universitas'] ?: '-') . "</td>
            <td>" . ($row['jurusan'] ?: '-') . "</td>
            <td>" . ($row['no_hp'] ?: '-') . "</td>
            <td>" . ($row['bidang_minat'] ?: '-') . "</td>
            <td>" . ucfirst($row['status']) . "</td>
            <td>" . date('d/m/Y', strtotime($row['tanggal_daftar'])) . "</td>
          </tr>";
    $no++;
}
echo "</table>";
exit;
?>