<?php
session_start();
require_once '../config/db.php';

// Validasi session & POST
if (!isset($_SESSION['nim']) || !isset($_POST['id_ruangan'])) {
    header("Location: /penyusunan_ujian/data/ruangan.php");
    exit;
}

$nim = mysqli_real_escape_string($conn, $_SESSION['nim']);
$id  = mysqli_real_escape_string($conn, $_POST['id_ruangan']);

// Hapus pilihan lama
mysqli_query($conn, "DELETE FROM pilihan_ruangan WHERE nim='$nim'");

// Simpan pilihan baru
mysqli_query($conn, "INSERT INTO pilihan_ruangan (nim, id_ruangan) VALUES ('$nim', '$id')");

// Redirect kembali
header("Location: /penyusunan_ujian/data/ruangan.php");
exit;
