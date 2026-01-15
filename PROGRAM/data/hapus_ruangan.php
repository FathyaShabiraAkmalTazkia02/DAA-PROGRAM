<?php
session_start();
require_once '../config/db.php';

// Validasi session
if (!isset($_SESSION['nim'])) {
    header("Location: /penyusunan_ujian/data/ruangan.php");
    exit;
}

$nim = mysqli_real_escape_string($conn, $_SESSION['nim']);

// Hapus pilihan ruangan user
mysqli_query($conn, "DELETE FROM pilihan_ruangan WHERE nim='$nim'");

// Kembali ke halaman ruangan
header("Location: /penyusunan_ujian/data/ruangan.php");
exit;
