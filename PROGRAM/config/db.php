<?php
$conn = new mysqli("localhost", "root", "", "db_penyusunan_jadwal");
if ($conn->connect_error) {
    die("Koneksi database gagal");
}
?>
