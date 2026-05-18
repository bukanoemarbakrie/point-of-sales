<?php
if (isset($_POST['tampilBola'])) {
    $jariJari = floatval($_POST['jarijari' ?? 0]);

    $lpBola = 4 * M_PI * pow($jariJari, 2);
    $vBola = 4 / 3 * M_PI * pow($jariJari, 3);

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perhitungan Balok</title>
</head>

<body>
  
  <h2>Bola</h2>
  <form action="" method="POST">
    <label for="">Jari-Jari</label><br>
    <input type="text" name="jarijari"><br>
    <button name="tampilBola">Hitung Hasilnya</button>
  </form>
  <?php


  if (isset($_POST['tampilBola'])) {

  echo "<br>";
  echo "Hasil Luas Alas Bola adalah $lpBola <br>";
  echo "Hasil Volume Bola adalah $vBola";
  }

  
  ?>
</body>

</html>