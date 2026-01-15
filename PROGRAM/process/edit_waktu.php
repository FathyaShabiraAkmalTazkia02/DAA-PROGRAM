<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: /penyusunan_ujian/auth/login.php");
    exit;
}

require_once __DIR__ . '/../config/db.php';

/* Validasi ID */
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: /penyusunan_ujian/data/waktu.php");
    exit;
}

$id = (int) $_GET['id'];

/* Ambil data */
$stmt = $conn->prepare(
    "SELECT * FROM waktu_ujian WHERE id = ?"
);
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    header("Location: /penyusunan_ujian/data/waktu.php");
    exit;
}

/* Proses update */
if (isset($_POST['update'])) {
    $tanggal     = $_POST['tanggal'];
    $jam_mulai   = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];

    $upd = $conn->prepare(
        "UPDATE waktu_ujian 
         SET tanggal = ?, jam_mulai = ?, jam_selesai = ?
         WHERE id = ?"
    );
    $upd->bind_param("sssi", $tanggal, $jam_mulai, $jam_selesai, $id);
    $upd->execute();

    header("Location: /penyusunan_ujian/data/waktu.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Waktu Ujian</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="header-main">
    <h1>Edit Waktu Ujian</h1>
    <p>Perbarui jadwal ujian</p>
</div>

<div class="container">

<form method="post">
    <label>Tanggal Ujian</label>
    <input type="date" name="tanggal"
           value="<?= htmlspecialchars($data['tanggal']) ?>" required>

    <label>Jam Mulai</label>
    <input type="time" name="jam_mulai"
           value="<?= htmlspecialchars($data['jam_mulai']) ?>" required>

    <label>Jam Selesai</label>
    <input type="time" name="jam_selesai"
           value="<?= htmlspecialchars($data['jam_selesai']) ?>" required>

    <div class="action-buttons">
        <button type="submit" form="form-edit" class="btn-primary">
            💾 Update
        </button>

        <a href="/penyusunan_ujian/data/waktu.php" class="btn-primary">
            ← Kembali
        </a>
    </div>
    
</form>

<br>
</div>
</body>
</html>
