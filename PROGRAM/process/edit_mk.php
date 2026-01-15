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

/* Ambil data */
$stmt = $conn->prepare("SELECT * FROM waktu_ujian WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    header("Location: ../data/waktu.php");
    exit;
}

/* Update */
if (isset($_POST['update'])) {
    $tanggal    = $_POST['tanggal'];
    $jam_mulai  = $_POST['jam_mulai'];
    $jam_selesai= $_POST['jam_selesai'];

    if ($jam_selesai <= $jam_mulai) {
        $error = "Jam selesai harus lebih besar dari jam mulai";
    } else {
        $upd = $conn->prepare(
            "UPDATE waktu_ujian 
             SET tanggal=?, jam_mulai=?, jam_selesai=? 
             WHERE id=?"
        );
        $upd->bind_param("sssi", $tanggal, $jam_mulai, $jam_selesai, $id);
        $upd->execute();

        header("Location: ../data/waktu.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Waktu Ujian</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="header-main">
    <h1>Edit Waktu Ujian</h1>
    <p>Perbarui Jadwal Ujian</p>
</div>

<div class="container">

<?php if (isset($error)): ?>
    <div class="info-box warning"><?= $error ?></div>
<?php endif; ?>

<form method="post">
    <label>Tanggal</label>
    <input type="date" name="tanggal" value="<?= $data['tanggal'] ?>" required>

    <label>Jam Mulai</label>
    <input type="time" name="jam_mulai" value="<?= $data['jam_mulai'] ?>" required>

    <label>Jam Selesai</label>
    <input type="time" name="jam_selesai" value="<?= $data['jam_selesai'] ?>" required>

    <button type="submit" name="update">💾 Update</button>
</form>

<br>
<div style="text-align:center;">
    <a href="../data/waktu.php" class="btn-primary">← Kembali</a>
</div>

</div>
</body>
</html>
