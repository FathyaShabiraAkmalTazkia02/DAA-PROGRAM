<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../config/db.php';

/* Validasi ID */
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../data/waktu.php");
    exit;
}

$id = (int) $_GET['id'];

/* Hapus data waktu ujian */
$stmt = $conn->prepare("DELETE FROM waktu_ujian WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

/* Kembali ke halaman waktu */
header("Location: ../data/waktu.php");
exit;
