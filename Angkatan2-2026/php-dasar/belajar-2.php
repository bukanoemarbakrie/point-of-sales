<?php
const email = "contoh@gmail.com";

echo email;
echo "<br>";
echo "<br>";
define("nama", "Ridho");


echo $nama;
echo "<br>";

$fruits = array("Apel", "Mangga", "Pisang");
$cars = ["Toyota", "Daihatsu", "Maung"];
// var_dump($buah);
echo "<br>";
array_push($fruits, "Quldi", "Anggur", "Qorma", "Pear");
foreach ($fruits as $key => $fruit) {
    echo "Nama Buah adalah $fruit <br>";
}
echo $fruits[2];
// Array Asosiative

$motorcyles = [[
    'merek' => 'Honda',
    'warna' => 'Hitam',
    'tahun' => '2024',
    'cc' => 250
], [
    'merek' => 'Yamaha',
    'warna' => 'Biru',
    'tahun' => '2023',
    'cc' => 150

], [
    'merek' => 'Piaggio',
    'warna' => 'Kuning',
    'tahun' => '2025',
    'cc' => 150

]];

// var_dump($motorcyles);
foreach ($motorcyles as $index => $motorcyle) {
    if ($index != 2) {
        echo "<ul>
        <li>Nama Motor : " . $motorcyle['merek'] . " </li>
        <li>Warna Motor :" . $motorcyle['warna'] . "</li>
        <li>Tahun Motor : " . $motorcyle['tahun'] . "</li>
        <li>CC Motor :" . $motorcyle['cc'] . "</li>
        </ul>";
    }
}

echo $motorcyles[0]["cc"];

// < : Kecil
// > : Besar
// <= : lebih kecil atau sama dengan
// => : lebih besar atau sama dengan
// == : sama dengan
// !== : tidak sama dengan

$nama = "Ridho";
echo "<br>";
if ($nama == "Jabbar") {
    echo "Salah";
} else {
    echo "Benar";
}

$nilai = 102;
echo "<br>";
if ($nilai >= 90 && $nilai <= 100) {
    echo "A";
} else if ($nilai >= 80 && $nilai <= 89) {
    echo "B";
} else if ($nilai >= 60 && $nilai <= 79) {
    echo "C";
} else if ($nilai > 100) {
    echo "Kebanyakan Cees!";
} else {
    echo "Belajar lagi Cees Ngulang!";
}

echo "<br>";
$hasil = ($nilai >= 90 && $nilai <= 100) ? 'A' : ($nilai >= 80 && $nilai <= 89  ? 'B' : ($nilai <= 79 ? 'C' : 'Nilai Tidak Diketahui'));

echo $hasil . "<br>";

$warna = "Hitam";
echo "<br>";
switch ($warna) {
    case 'Biru':
        echo "Ini warna Biru";
        break;
    case 'Orange':
        echo "Ini warna Orange";
        break;
    case 'Hijau':
        echo "Ini warna Hijau";
        break;
    case 'Pink':
        echo "Ini warna Pink";
        break;

    default:
        echo "Bukan warna Ituh";
        break;
}

// looping atau perulangan = struktur kode yang digunakan untuk menjalankan blok kode selama kondisi tertentu terpenuhi 
// for, while , do..while
echo "<br>";
for ($i = 1; $i <= 5; $i++) {
    echo "Saya Seorang Pelajar di PPKD Jakarta Pusat" . "<br>";
}
echo "<br>";
// while 
$a = 1;
while ($a <= 10) {
    echo "Ini Angka ke- $a" . "<br>";
    $a++;
}
echo "<br>";
// do while
$b =  1;
do {
    echo "Halo ke-$b" . "<br>";
    $b++;
} while ($b <= 20);
echo "<br>";

// function : blok kode yg diberi nama, yang bisa di panggil kapan saja untuk menjalankan tugas tertentu 
// menghindari perulangan kode (kode reuse), memecah logika menjadi bagian terkecil
// - array_push(),substr(),strln(),str_word_count(),ucfirst()

function namaAnda($nama,$usia) {
    return "Nama Anda Adalah $nama, Usia Anda Adalah $usia Tahun" . "<br>"; 
}
echo namaAnda("Andi", 22);
echo namaAnda("Jabbar", 24);
echo namaAnda("Sultan", 28);
echo "<br>";

$stringName = "Saya Sedang Belajar Pemograman Dasar pada Bahasa Pemrograman PHP";

echo substr($stringName, 5);
echo "<br>";
echo strlen($stringName);
echo "<br>";
echo str_word_count($stringName);
echo "<br>";
echo ucfirst($stringName);
echo "<br>";
echo ucwords ($stringName);