<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../config/db.php';

/* Ambil data waktu ujian */
$data = mysqli_query(
    $conn,
    "SELECT * FROM waktu_ujian ORDER BY tanggal, jam_mulai"
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Waktu Ujian</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<!-- HEADER -->
<div class="header-main">
    <h1>Data Waktu Ujian</h1>
    <p>Kelola jadwal tanggal dan waktu ujian</p>
</div>

<!-- CONTAINER -->
<div class="container">

    <!-- FORM INPUT -->
    <form method="post" action="../process/simpan_waktu.php">
        <label>Tanggal Ujian</label>
        <input type="date" name="tanggal" required>

        <label>Jam Mulai</label>
        <input type="time" name="jam_mulai" required>

        <label>Jam Selesai</label>
        <input type="time" name="jam_selesai" required>

        <button type="submit">💾 Simpan</button>
    </form>

    <hr>

    <!-- TABEL DATA -->
    <table>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Jam Mulai</th>
            <th>Jam Selesai</th>
            <th>Aksi</th>
        </tr>

        <?php if (mysqli_num_rows($data) > 0): ?>
            <?php $no = 1; while ($r = mysqli_fetch_assoc($data)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($r['tanggal']) ?></td>
                <td><?= htmlspecialchars($r['jam_mulai']) ?></td>
                <td><?= htmlspecialchars($r['jam_selesai']) ?></td>
                <td>
                    <a class="btn-edit"
                       href="../process/edit_waktu.php?id=<?= $r['id'] ?>">
                        ✏ Edit
                    </a>
                    |
                    <a class="btn-hapus"
                       href="../process/hapus_waktu.php?id=<?= $r['id'] ?>"
                       onclick="return confirm('Hapus waktu ujian ini?')">
                        🗑 Hapus
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" style="text-align:center;color:#777;">
                    Belum ada data waktu ujian
                </td>
            </tr>
        <?php endif; ?>
    </table>

    <br>

    <!-- KEMBALI -->
    <div style="text-align:center;">
        <a href="../dashboard.php" class="btn-primary">
            ← Kembali ke Beranda
        </a>
    </div>

</div>

</body>
</html>
