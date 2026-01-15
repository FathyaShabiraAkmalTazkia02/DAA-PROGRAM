<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../config/db.php';
$nim = $_SESSION['nim'];

/* Ambil semua ruangan */
$ruangan = mysqli_query($conn, "SELECT * FROM ruangan");

/* Cek ruangan yang sudah dipilih */
$cek = mysqli_query($conn, "
    SELECT r.nama_ruangan 
    FROM pilihan_ruangan p
    JOIN ruangan r ON p.id_ruangan = r.id
    WHERE p.nim = '$nim'
");
$pilih = mysqli_fetch_assoc($cek);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pilih Ruangan Ujian</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="header-main">
    <h1>Pilih Ruangan Ujian</h1>
    <p>Silakan pilih ruangan ujian yang tersedia</p>
</div>

<div class="container">

    <table>
        <tr>
            <th>No</th>
            <th>Ruangan</th>
            <th>Aksi</th>
        </tr>

        <?php $no = 1; while ($r = mysqli_fetch_assoc($ruangan)): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $r['nama_ruangan'] ?></td>
            <td>
                <form method="post" action="../data/pilih_ruangan.php">
                    <input type="hidden" name="id_ruangan" value="<?= $r['id'] ?>">
                    <button type="submit">Pilih</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <?php if ($pilih): ?>
        <div class="info-box success">
            ✅ Ruangan terpilih: <b><?= $pilih['nama_ruangan'] ?></b>
            <a href="../data/hapus_ruangan.php" class="btn-danger">Batal</a>
        </div>
    <?php else: ?>
        <div class="info-box warning">
            ⚠️ Anda belum memilih ruangan
        </div>
    <?php endif; ?>

    <br>
    <a href="../dashboard.php" class="btn-primary">← Kembali ke Beranda</a>
</div>

</body>
</html>
