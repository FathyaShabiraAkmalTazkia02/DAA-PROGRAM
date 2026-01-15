<?php
session_start();
include '../config/db.php';

$nim = $_POST['nim'];
$password = $_POST['password'];

// ambil user berdasarkan NIM saja
$query = mysqli_query($conn, 
    "SELECT * FROM users WHERE nim='$nim'"
);

if (mysqli_num_rows($query) == 1) {
    $data = mysqli_fetch_assoc($query);

    // cek password hash
    if (password_verify($password, $data['password'])) {

        $_SESSION['login'] = true;
        $_SESSION['nim']   = $data['nim'];
        $_SESSION['nama']  = $data['nama'];
        $_SESSION['prodi'] = $data['prodi'];

        header("Location: ../index.php");
        exit;
    } else {
        echo "Password salah!";
    }

} else {
    echo "NIM tidak ditemukan!";
}
