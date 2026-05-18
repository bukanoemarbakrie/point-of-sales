<?php
if (isset($_POST['tampilTabung'])) {
    $jariJari = floatval($_POST['jarijari' ?? 0]);
    $tinggi = floatval($_POST['tinggi' ?? 0]);

    $lpBalok = 2 * M_PI * $jariJari * ($jariJari + $tinggi);
    $vTabung = M_PI * $jariJari * $tinggi;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perhitungan Tabung</title>
</head>

<body>
  <h2>Tabung</h2>
  <form action="" method="POST">
    <label for="">Jari-jari</label><br>
    <input type="text" name="jarijari"><br>
    <label for="">Tinggi</label><br>
    <input type="text" name="tinggi"><br><br>
    <button name="tampilTabung">Hitung Hasilnya</button>
  </form>
  <?php


  if (isset($_POST['tampilTabung'])) {
    echo "<br>";
  echo "Hasil Luas Permukaan Tabung adalah $lpBalok <br>";
  echo "Hasil Volume Tabung adalah $vTabung";
  }

  
  ?>
</body>

</html>