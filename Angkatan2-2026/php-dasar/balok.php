<?php
if (isset($_POST['tampilkanBalok'])) {
$panjang = floatval($_POST['panjang' ?? 0]);
$lebar = floatval($_POST['lebar' ?? 0]);
$tinggi = floatval($_POST['tinggi' ?? 0]);

$vBalok = $panjang * $lebar * $tinggi;
$lpBalok = 2 * ($panjang*$lebar) + ($panjang*$tinggi) + ($lebar*$tinggi) ;

}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BALOK</title>
</head>
<body>
    <h4>BALOK</h4>
    <form action="" method="post">
    <label for="">Panjang</label><br>
    <input type="text" name="panjang"><br>
    <label for="">Lebar</label><br>
    <input type="text" name="lebar"><br>
    <label for="">Tinggi</label><br>
    <input type="text" name="tinggi"><br>
    <button type= "submit" name="tampilkanBalok" >Hitung Hasilnya</button>
    </form>
<?php
if (isset($_POST['tampilkanBalok'])) {
echo "<br>";
echo " Hasil Perhitungan Volume Balok " . $vBalok;
echo " Hasil Perhitungan Luas Permukaan Balok " .$lpBalok;

}


?>
</body>
</html>