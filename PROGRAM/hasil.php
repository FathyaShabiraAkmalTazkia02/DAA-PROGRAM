<?php
session_start();
if (!isset($_SESSION['jadwal'])) {
    header("Location: dashboard.php");
    exit;
}

$jadwal = $_SESSION['jadwal'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hasil Jadwal Ujian</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Hasil Jadwal Ujian</h2>

    <table>
        <tr>
            <th>Mata Kuliah</th>
            <th>Dosen</th>
            <th>Waktu</th>
            <th>Ruangan</th>
        </tr>

        <?php foreach ($jadwal as $j): ?>
        <tr>
            <td><?= $j['mk'] ?></td>
            <td><?= $j['dosen'] ?></td>
            <td><?= $j['waktu'] ?></td>
            <td><?= $j['ruangan'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- TOMBOL KEMBALI DI TENGAH -->
    <div style="text-align:center; margin-top:30px;">
        <a href="dashboard.php" class="nav-btn">
            ⬅ Kembali ke Beranda
        </a>
    </div>
</div>

</body>
</html>
