<?php

// if ($_SERVER['REQUEST_METHOD']== "POST") {
if (isset($_POST['tampil'])) {
    $name = $_POST['name'];
    $nim = $_POST['nim'];
    $alamat = $_POST['alamat'];
    $angka1 = floatval($_POST['angka1' ?? 0]);
    $angka2 = floatval($_POST['angka2' ?? 0]);
    $operasi = $_POST['operasi'] ?? null;

    // $hasil = $angka1 * $angka2;
    // }

    function hasilPerhitungan($angka1, $angka2, $operasi)
    {
        switch ($operasi) {
            case '+':
                return $angka1 + $angka2;
            case '-':
                return $angka1 - $angka2;
            case '*':
                return $angka1 * $angka2;
            case '/':
                return $angka2 != 0 ? $angka1 / $angka2 : 'Tidak bisa dibagi nol';
            default:
                return 'Operasi tidak valid';
        }
    }

    $hasilPerhitungan = hasilPerhitungan($angka1, $angka2, $operasi);
}

// default agar tidak undefined saat halaman dibuka tanpa submit
$hasilPerhitungan = $hasilPerhitungan ?? null;
$name = $name ?? null;
$nim = $nim ?? null;
$alamat = $alamat ?? null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=form, initial-scale=1.0">
    <title>DAFTAR MAHASISWA</title>
</head>

<body>
    <form action="" method="post" ;>
        <label for="">Nama Mahasiswa</label><br>
        <input type="text" name="name"><br>
        <label for="">NIM</label><br>
        <input type="number" name="nim"><br>
        <label for="">Alamat</label><br>
        <textarea name="alamat" cols="30" rows="5">
        </textarea><br>
        <label for="">Number 1</label><br>
        <input type="number" name="angka1"><br>
        <label for="">Number 2</label><br>
        <input type="number" name="angka2"><br>
        <br>
        <label for="operasi">Operasi</label>
        <br>
        <select name="operasi" id="">
            <option value="+">+</option>
            <option value="-">-</option>
            <option value="*">*</option>
            <option value="/">/</option>
        </select>
<br>

        <button type="submit" name="tampil">Tampilkan Data</button>
    </form>

    <?php
    if (isset($_POST['tampil'])) {

        echo " <br>Nama Saya Adalah " . $name . " <br>NIM Saya " . $nim .  " <br>Alamatnya di " . $alamat . " <br>Hasilnya Adalah " . $hasilPerhitungan;
    }
    ?>
</body>

</html>