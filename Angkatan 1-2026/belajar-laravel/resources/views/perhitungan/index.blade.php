<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   <h2>Perhitungan</h2>
   <a href="{{ url('navbar') }}">Kembali</a>
   <a href="">Luas Permukaan Kubus</a>
   <a href="">Volume Kubus</a>
   <a href="">Luas Permukaan Tabung</a>
   <a href="">Volume Tabung</a>
   <form action="{{ route('perhitungan.store') }}" method="post">
    @csrf
    <input type="number" name="angka1" required><br>
    <select name="operator" required>
        <option value="">--Pilih Operator--</option>
        <option value="+">+</option>
        <option value="-">-</option>
        <option value="*">*</option>
        <option value="/">/</option>
    </select><br>
    <input type="number" name="angka2" required><br>
    <button type="submit">Hitung</button><br>
   </form>
   @isset($hasil)
     <h3>Hasil :{{ $hasil }}</h3>
   @endisset
</body>
</html>
