<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: /penyusunan_ujian/auth/login.php");
    exit;
}

require_once __DIR__ . '/../config/db.php';

/* Validasi ID */
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: /penyusunan_ujian/data/mata_kuliah.php");
    exit;
}

$id = (int) $_GET['id'];

/* Hapus data */
$stmt = $conn->prepare("DELETE FROM mata_kuliah WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

/* Redirect kembali */
header("Location: /penyusunan_ujian/data/mata_kuliah.php");
exit;
