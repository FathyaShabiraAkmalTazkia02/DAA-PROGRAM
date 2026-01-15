<?php include "config/db.php"; ?>
<h2>Input Waktu Ujian</h2>

<form method="post">
    Tanggal:<br>
    <input type="date" name="tanggal" required><br><br>

    Jam:<br>
    <input type="text" name="jam" placeholder="08:00-10:00" required><br><br>

    <button type="submit" name="simpan">Simpan</button>
</form>

<?php
if (isset($_POST['simpan'])) {
    $tgl = $_POST['tanggal'];
    $jam = $_POST['jam'];
    $conn->query("INSERT INTO waktu_ujian VALUES (NULL,'$tgl','$jam')");
    echo "<p>Waktu ujian berhasil disimpan</p>";
}
?>

<hr>
<h3>Data Waktu Ujian</h3>
<table border="1">
<tr><th>Tanggal</th><th>Jam</th></tr>
<?php
$q = $conn->query("SELECT * FROM waktu_ujian");
while ($d = $q->fetch_assoc()) {
    echo "<tr><td>$d[tanggal]</td><td>$d[jam]</td></tr>";
}
?>
</table>
