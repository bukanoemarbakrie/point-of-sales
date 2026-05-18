<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <label for="nama">Nama</label>
        <input type="text" name="nama" required>
        <br>
        <br>
        <label for="usia">Usia</label>
        <input type="text" name="usia" required>
        <br>
        <br>
        <label for="alamat">Alamat</label>
        <input type="text" name="alamat" required>
        <br>
        <label for="jenis_kelamin">Jenis Kelamin</label>
        <input type="radio" name="jenis_kelamin" value="Laki-laki" required> Laki-laki
        <input type="radio" name="jenis_kelamin" value="Perempuan" required> Perempuan
        <input type="radio" name="jenis_kelamin" value="Non-Biner" required> Non-Biner
        <br>
        <br>
        <label for="hobi">Hobi</label>
        <input type="checkbox" name="hobi[]" value="Membaca" > Membaca
        <input type="checkbox" name="hobi[]" value="Menulis" > Menulis
        <input type="checkbox" name="hobi[]" value="Berenang" > Berenang
        <input type="checkbox" name="hobi[]" value="Mancing"> Mancing
        <br>
        <br>
        <label for="agama">Agama</label>
        <select name="agama" id="agama" required>
            <option value="Islam">Islam</option>
            <option value="Kristen">Kristen</option>
            <option value="Hindu">Hindu</option>
            <option value="Buddha">Buddha</option>
            <option value="Konghucu">Konghucu</option>
        </select>
        <br>
        <br>
        <label for="angka1">Angka 1</label>
        <input type="number" name="angka1" required>
        <br>
        <br>
        
        <label for="operator">Operasi</label>
        <select name="operator" required>
            <option value="tambah">(+)</option>
            <option value="kurang">(-)</option>
            <option value="kali">(*)</option>
            <option value="bagi">(/)</option>
        </select>
        <br>
        <br>
        
        <label for="angka2">Angka 2</label>
        <input type="number" name="angka2" required>
        <br>
        <br>
        <input type="submit" value="Kirim">
        <input type="reset" value="Reset">
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama = $_POST["nama"] ?? "";
        $usia = $_POST["usia"] ?? "";
        $alamat = $_POST["alamat"] ?? "";
        $jenis_kelamin = $_POST["jenis_kelamin"] ?? "Tidak dipilih";
        $hobi = $_POST["hobi"] ?? [];
        $agama = $_POST["agama"] ?? "";
        $angka1 = $_POST["angka1"] ?? 0;
        $angka2 = $_POST["angka2"] ?? 0;

        $operator = $_POST["operator"] ?? "tambah";

        function hasilPerhitungan($angka1, $angka2, $operator) {
            switch($operator) {
                case 'tambah':
                    return $angka1 + $angka2;
                case 'kurang':
                    return $angka1 - $angka2;
                case 'kali':
                    return $angka1 * $angka2;
                case 'bagi':
                    return $angka2 != 0 ? ($angka1 / $angka2) : "Error (dibagi 0)";
                default:
                    return 0;
            }
        }
        
        $hasilHitung = hasilPerhitungan($angka1, $angka2, $operator);
        $hobi_str = implode(", ", $hobi);

        echo "<br><h3>Hasil Input:</h3>";
        echo "<textarea rows='9' cols='40' readonly>";
        echo "Nama: $nama\n";
        echo "Usia: $usia\n";
        echo "Alamat: $alamat\n";
        echo "Jenis Kelamin: $jenis_kelamin\n";
        echo "Hobi: $hobi_str\n";
        echo "Agama: $agama\n";
        echo "Hasil Hitung: $angka1 ($operator) $angka2 = $hasilHitung\n";
        echo "</textarea>";
    }
    ?>
</body>
</html>