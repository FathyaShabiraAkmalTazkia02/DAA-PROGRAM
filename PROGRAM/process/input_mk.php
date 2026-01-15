<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$nama_mk = $_POST['nama_mk'] ?? '';
$dosen   = $_POST['dosen'] ?? '';

if ($nama_mk && $dosen) {
    mysqli_query($conn, "
        INSERT INTO mata_kuliah (nama_mk, dosen)
        VALUES ('$nama_mk', '$dosen')
    ");
}

header("Location: ../data/mata_kuliah.php");
exit;
