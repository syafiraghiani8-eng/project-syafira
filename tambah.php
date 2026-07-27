<?php
include 'koneksi.php';

if(isset($_POST['simpan'])){

    mysqli_query($conn,
    "INSERT INTO acara(judul,tanggal,deskripsi)
    VALUES(
    '$_POST[judul]',
    '$_POST[tanggal]',
    '$_POST[deskripsi]')");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Tambah Acara</title>
</head>
<body>

<h2>Tambah Acara</h2>

<form method="POST">

Judul<br>
<input type="text" name="judul"><br><br>

Tanggal<br>
<input type="date" name="tanggal"><br><br>

Deskripsi<br>
<textarea name="deskripsi"></textarea><br><br>

<button name="simpan">
Simpan
</button>

</form>

<br>
<a href="index.php">Kembali ke Kalender</a>

</body>
</html>