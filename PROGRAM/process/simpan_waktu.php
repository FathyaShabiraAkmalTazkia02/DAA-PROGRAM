<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../config/db.php';

/* Validasi POST */
if (
    !isset($_POST['tanggal']) ||
    !isset($_POST['jam_mulai']) ||
    !isset($_POST['jam_selesai'])
) {
    header("Location: ../data/waktu.php");
    exit;
}

$tanggal     = $_POST['tanggal'];
$jam_mulai   = $_POST['jam_mulai'];
$jam_selesai = $_POST['jam_selesai'];

/* Simpan ke database */
$stmt = $conn->prepare(
    "INSERT INTO waktu_ujian (tanggal, jam_mulai, jam_selesai)
     VALUES (?, ?, ?)"
);
$stmt->bind_param("sss", $tanggal, $jam_mulai, $jam_selesai);
$stmt->execute();

/* Kembali ke halaman waktu */
header("Location: ../data/waktu.php");
exit;
