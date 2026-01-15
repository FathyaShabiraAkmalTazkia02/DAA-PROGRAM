<?php
// ===============================
// SESSION (AMAN, TIDAK DOUBLE)
// ===============================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../config/db.php";

// ===============================
// AMBIL DATA DARI DATABASE
// ===============================

// Mata Kuliah
$q_mk = mysqli_query($conn, "SELECT * FROM mata_kuliah");
$mataKuliah = [];
while ($row = mysqli_fetch_assoc($q_mk)) {
    $mataKuliah[] = $row;
}

// Ruangan
$q_ruang = mysqli_query($conn, "SELECT * FROM ruangan");
$ruangan = [];
while ($row = mysqli_fetch_assoc($q_ruang)) {
    $ruangan[] = $row;
}

// Waktu Ujian
$q_waktu = mysqli_query($conn, "SELECT * FROM waktu_ujian");
$waktuUjian = [];
while ($row = mysqli_fetch_assoc($q_waktu)) {
    $waktuUjian[] = $row;
}

// ===============================
// VALIDASI DATA
// ===============================
if (count($mataKuliah) == 0 || count($ruangan) == 0 || count($waktuUjian) == 0) {
    die("❌ Data mata kuliah / ruangan / waktu belum lengkap");
}

// ===============================
// HAPUS JADWAL LAMA
// ===============================
mysqli_query($conn, "DELETE FROM jadwal_ujian");

// ===============================
// FUNGSI CEK KEAMANAN JADWAL
// ===============================
function aman($mk, $w, $r, $jadwal) {
    foreach ($jadwal as $j) {
        // Ruangan bentrok di waktu yang sama
        if ($j['id_waktu'] == $w['id'] && $j['id_ruangan'] == $r['id']) {
            return false;
        }

        // Dosen bentrok di waktu yang sama
        if ($j['id_waktu'] == $w['id'] && $j['dosen'] == $mk['dosen']) {
            return false;
        }
    }
    return true;
}

// ===============================
// BACKTRACKING
// ===============================
function backtracking($i, $mataKuliah, $waktuUjian, $ruangan, &$jadwal) {
    if ($i >= count($mataKuliah)) {
        return true;
    }

    foreach ($waktuUjian as $w) {
        foreach ($ruangan as $r) {
            if (aman($mataKuliah[$i], $w, $r, $jadwal)) {

                $jadwal[] = [
                    'id_mk'      => $mataKuliah[$i]['id'],
                    'mk'         => $mataKuliah[$i]['nama_mk'],
                    'dosen'      => $mataKuliah[$i]['dosen'],
                    'id_waktu'   => $w['id'],
                    'waktu'      => $w['tanggal'].' '.$w['jam_mulai'].' - '.$w['jam_selesai'],
                    'id_ruangan' => $r['id'],
                    'ruangan'    => $r['nama_ruangan']
                ];


                if (backtracking($i + 1, $mataKuliah, $waktuUjian, $ruangan, $jadwal)) {
                    return true;
                }

                array_pop($jadwal);
            }
        }
    }
    return false;
}

// ===============================
// JALANKAN GENERATE
// ===============================
$jadwal = [];
backtracking(0, $mataKuliah, $waktuUjian, $ruangan, $jadwal);

// ===============================
// SIMPAN KE DATABASE
// ===============================
foreach ($jadwal as $j) {
    mysqli_query($conn, "
        INSERT INTO jadwal_ujian (id_mk, id_ruangan, id_waktu)
        VALUES (
            '{$j['id_mk']}',
            '{$j['id_ruangan']}',
            '{$j['id_waktu']}'
        )
    ");
}

// ===============================
// SIMPAN KE SESSION & REDIRECT
// ===============================
$_SESSION['jadwal'] = $jadwal;
header("Location: ../hasil.php");
exit;
