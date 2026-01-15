<?php include "config/db.php"; ?>
<h2>Input Ruangan</h2>

<form method="post">
    Nama Ruangan:<br>
    <input type="text" name="nama_ruangan" required><br><br>
    <button type="submit" name="simpan">Simpan</button>
</form>

<?php
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_ruangan'];
    $conn->query("INSERT INTO ruangan VALUES (NULL,'$nama')");
    echo "<p>Ruangan berhasil disimpan</p>";
}
?>

<hr>
<h3>Data Ruangan</h3>
<table border="1">
<tr><th>Nama Ruangan</th></tr>
<?php
$q = $conn->query("SELECT * FROM ruangan");
while ($d = $q->fetch_assoc()) {
    echo "<tr><td>$d[nama_ruangan]</td></tr>";
}
?>
</table>
