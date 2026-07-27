<?php
include 'koneksi.php';

if(isset($_POST['simpan'])){

    mysqli_query($conn,"
    INSERT INTO acara(judul,tanggal,deskripsi)
    VALUES(
    '$_POST[judul]',
    '$_POST[tanggal]',
    '$_POST[deskripsi]'
    )");

}

$tahun = 2026;

$namaBulan = [
1=>"Januari",
2=>"Februari",
3=>"Maret",
4=>"April",
5=>"Mei",
6=>"Juni",
7=>"Juli",
8=>"Agustus",
9=>"September",
10=>"Oktober",
11=>"November",
12=>"Desember"
];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Kalender 2026</title>

<style>

body{
    font-family: 'Poppins', Arial, sans-serif;
    background:#fff0f5;
    margin:20px;
}

h1{
    text-align:center;
    color:#d81b60;
    margin-bottom:25px;
}

.form{
    background:#fffafd;
    padding:20px;
    border-radius:15px;
    margin-bottom:30px;
    box-shadow:0 3px 10px rgba(255,105,180,0.2);
}

.form h3{
    color:#e91e63;
}

input, textarea{
    width:100%;
    padding:10px;
    margin-top:5px;
    margin-bottom:10px;
    border:1px solid #f8bbd0;
    border-radius:8px;
    box-sizing:border-box;
}

button{
    background:#ec407a;
    color:white;
    border:none;
    padding:10px 15px;
    border-radius:8px;
    cursor:pointer;
}

button:hover{
    background:#d81b60;
}

.bungkus-kalender{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
}

.bulan{
    background:#fffafd;
    border-radius:15px;
    padding:10px;
    box-shadow:0 3px 10px rgba(255,105,180,0.15);
}

.bulan h3{
    text-align:center;
    color:#e91e63;
    margin:10px 0;
}

table{
    width:100%;
    border-collapse:collapse;
}

th{
    background:#f48fb1;
    color:white;
    padding:6px;
    font-size:12px;
}

th.minggu{
    background:#ec407a;
}

td{
    width:14.28%;
    height:75px;
    border:1px solid #fce4ec;
    vertical-align:top;
    padding:4px;
    font-size:11px;
    background:white;
}

td.minggu{
    background:#fff5f8;
    color:#e91e63;
}

td.libur{
    background:#ffe4ec;
}

.tanggal{
    font-weight:bold;
}

.keterangan{
    font-size:8px;
    color:#c2185b;
    margin-top:2px;
}

.acara{
    background:#f8bbd0;
    color:#880e4f;
    border-radius:5px;
    padding:2px;
    margin-top:3px;
    font-size:9px;
}

</style>

</head>
<body>

<h1>Kalender Tahun 2026 </h1>

<div class="form">

<h3>Tambah Acara</h3>

<form method="POST">

<label>Judul Acara</label>
<input type="text" name="judul" required>

<label>Tanggal</label>
<input type="date" name="tanggal" required>

<label>Deskripsi</label>
<textarea name="deskripsi" rows="3"></textarea>

<button type="submit" name="simpan">
Simpan Acara
</button>

</form>

</div>

<div class="bungkus-kalender">

<?php

for($bulan=1;$bulan<=12;$bulan++){

echo "<div class='bulan'>";

echo "<h3>".$namaBulan[$bulan]."</h3>";

$jumlahHari = cal_days_in_month(
CAL_GREGORIAN,
$bulan,
$tahun
);

$hariPertama = date(
'w',
strtotime("$tahun-$bulan-01")
);

echo "
<table>
<tr>
<th class='minggu'>Min</th>
<th>Sen</th>
<th>Sel</th>
<th>Rab</th>
<th>Kam</th>
<th>Jum</th>
<th>Sab</th>
</tr>
<tr>
";

for($kosong=0;$kosong<$hariPertama;$kosong++){
    echo "<td></td>";
}

$kolom = $hariPertama;

for($hari=1;$hari<=$jumlahHari;$hari++){

    $tanggal =
    $tahun."-".
    str_pad($bulan,2,"0",STR_PAD_LEFT).
    "-".
    str_pad($hari,2,"0",STR_PAD_LEFT);

    $hariKe = date(
    'w',
    strtotime($tanggal)
    );

    $class = "";

    if($hariKe == 0){
        $class .= " minggu";
    }

    $qLibur = mysqli_query(
    $conn,
    "SELECT * FROM libur
    WHERE tanggal='$tanggal'"
    );

    $libur = mysqli_fetch_assoc($qLibur);

    if($libur){
        $class .= " libur";
    }

    echo "<td class='$class'>";

    echo "<div class='tanggal'>$hari</div>";

    if($libur){
        echo "<div class='keterangan'>".$libur['keterangan']."</div>";
    }

    $qAcara = mysqli_query(
    $conn,
    "SELECT * FROM acara
    WHERE tanggal='$tanggal'"
    );

    while($a=mysqli_fetch_assoc($qAcara)){
        echo "<div class='acara'><b>".$a['judul']."</b></div>";
    }

    echo "</td>";

    $kolom++;

    if($kolom % 7 == 0){
        echo "</tr><tr>";
    }

}

while($kolom % 7 != 0){
    echo "<td></td>";
    $kolom++;
}

echo "</tr>";
echo "</table>";

echo "</div>";

}

?>

</div>

</body>
</html>