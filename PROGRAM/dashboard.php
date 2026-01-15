<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: auth/login.php");
    exit;
}

require_once 'config/db.php';

/* HITUNG DATA DARI DATABASE */
$jumlah_mk = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM mata_kuliah")
)['total'];

$jumlah_ruangan = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM ruangan")
)['total'];

$jumlah_waktu = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM waktu_ujian")
)['total'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Penjadwalan Ujian</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- HEADER -->
<div class="header-main">
    <h1>Dashboard Penjadwalan Ujian</h1>
    <p>Aplikasi Penyusunan Jadwal Ujian Otomatis</p>
</div>

<div class="container">
    <h2>Selamat Datang</h2>
    <p><b><?= $_SESSION['nama']; ?></b></p>
    <p>NIM: <?= $_SESSION['nim']; ?></p>
    <p>Prodi: <?= $_SESSION['prodi']; ?></p>

    <hr>

    <!-- MENU INPUT -->
    <div class="action-menu">
        <a href="data/mata_kuliah.php" class="nav-btn">
            📘 Input Mata Kuliah <br>
            <small><?= $jumlah_mk ?> data</small>
        </a>

        <a href="data/ruangan.php" class="nav-btn">
            🏫 Input Ruangan <br>
            <small><?= $jumlah_ruangan ?> data</small>
        </a>

        <a href="data/waktu.php" class="nav-btn">
            ⏰ Input Waktu <br>
            <small><?= $jumlah_waktu ?> data</small>
        </a>
    </div>

    <!-- GENERATE -->
    <div class="action-card">
        <?php if ($jumlah_mk > 0 && $jumlah_ruangan > 0 && $jumlah_waktu > 0): ?>
            <form action="process/generate_jadwal.php" method="post">
                <button class="generate-btn">⚙️ Generate Jadwal Ujian</button>
            </form>
        <?php else: ?>
            <p style="color:red; font-weight:bold;">
                ⚠️ Lengkapi data Mata Kuliah, Ruangan, dan Waktu terlebih dahulu
            </p>
        <?php endif; ?>

        <br><br>

        <a href="auth/logout.php" class="btn-logout">🚪 Logout</a>
    </div>
</div>

<div class="footer">
    <p>© 2026 | Aplikasi Penjadwalan Ujian Otomatis</p>
    <p>
        Nama: <?= $_SESSION['nama']; ?> |
        NIM: <?= $_SESSION['nim']; ?> |
        Prodi: <?= $_SESSION['prodi']; ?>
    </p>
</div>

</body>
</html>
