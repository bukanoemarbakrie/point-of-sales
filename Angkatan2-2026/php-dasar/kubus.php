<?php
if (isset($_POST['tampilkanKubus'])) {
$sisi = floatval($_POST['sisi' ?? 0]);

$vKubus = $sisi * $sisi * $sisi;
$lpKubus = 6 * $sisi * $sisi;

}


?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUBUS</title>
</head>
<body>
    <h4>Kubus</h4>
    <form action="" method="post">
    <label for="">Sisi</label><br>
    <input type="text" name="sisi">
    <button type= "submit" name="tampilkanKubus" >Hitung Hasilnya</button>
    </form>
<?php
if (isset($_POST['tampilkanKubus'])) {
echo "<br>";
echo " Hasil Perhitungan Volume Kubus " .$vKubus;
echo " Hasil Perhitungan Luas Permukaan Kubus " .$lpKubus;
}


?>

</body>
</html>