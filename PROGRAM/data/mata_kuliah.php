<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../config/db.php';

/* Ambil data mata kuliah */
$data = mysqli_query($conn, "SELECT * FROM mata_kuliah ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Mata Kuliah</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<!-- HEADER -->
<div class="header-main">
    <h1>Data Mata Kuliah</h1>
    <p>Input dan Manajemen Mata Kuliah</p>
</div>

<!-- CONTENT -->
<div class="container">

    <!-- FORM INPUT -->
    <h3>Tambah Mata Kuliah</h3>
    <form method="post" action="../process/input_mk.php">
        <input type="text" name="nama_mk" placeholder="Nama Mata Kuliah" required>
        <input type="text" name="dosen" placeholder="Nama Dosen" required>
        <button type="submit">Simpan</button>
    </form>

    <hr>

    <!-- TABEL DATA -->
    <h3>Daftar Mata Kuliah</h3>

    <?php if (mysqli_num_rows($data) == 0): ?>
        <div class="info-box warning">
            <span>⚠️ Belum ada data mata kuliah</span>
        </div>
    <?php else: ?>
        <table>
            <tr>
                <th>No</th>
                <th>Mata Kuliah</th>
                <th>Dosen</th>
                <th style="width:140px;">Aksi</th>
            </tr>

            <?php $no = 1; while ($d = mysqli_fetch_assoc($data)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($d['nama_mk']) ?></td>
                <td><?= htmlspecialchars($d['dosen']) ?></td>
                <td>
                    <a href="../process/edit_mk.php?id=<?= $d['id'] ?>" class="btn-primary" style="padding:6px 10px;font-size:12px;">
                        Edit
                    </a>
                    <a href="../process/hapus_mk.php?id=<?= $d['id'] ?>"
                       class="btn-danger"
                       style="padding:6px 10px;font-size:12px;"
                       onclick="return confirm('Yakin ingin menghapus mata kuliah ini?')">
                        Hapus
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>

    <br>
    <div style="text-align:center;">
        <a href="../dashboard.php" class="btn-primary">← Kembali ke Beranda</a>
    </div>

</div>

</body>
</html>
