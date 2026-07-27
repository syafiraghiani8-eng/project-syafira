<?php
include 'koneksi.php';

$tanggal = $_GET['tanggal'];

$data = mysqli_query($conn,
"SELECT * FROM acara
WHERE tanggal='$tanggal'");
?>

<!DOCTYPE html>
<html>
<head>
<title>Detail Acara</title>
</head>
<body>

<h2>Acara Tanggal <?= $tanggal ?></h2>

<?php

while($d = mysqli_fetch_assoc($data)){

echo "<h3>".$d['judul']."</h3>";
echo "<hr>";

}

?>

<a href="index.php">Kembali</a>

</body>
</html>