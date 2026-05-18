<?php
if (isset($_POST['tampilkanLimas'])) {
$sisi = floatval($_POST['sisi' ?? 0]);
$tinggi = floatval($_POST['tinggi' ?? 0]);

$lAlas = pow ($sisi, 2);
$vLimas = 1/3 * $lAlas * $tinggi;

}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIMAS</title>
</head>
<body>
    <h4>LIMAS</h4>
    <form action="" method="post">
    <label for="">Sisi</label><br>
    <input type="text" name="sisi"><br>
    <label for="">Tinggi</label><br>
    <input type="text" name="tinggi"><br>
    <button type= "submit" name="tampilkanLimas" >Hitung Hasilnya</button>
    </form>
<?php
if (isset($_POST['tampilkanLimas'])) {

echo "<br>";
echo " Hasil Perhitungan Luas Alas Limas " . $lAlas;
echo " Hasil Perhitungan Volume Limas " . $vLimas;

}


?>
</body>
</html>