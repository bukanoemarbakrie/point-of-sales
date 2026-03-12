<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tittle ?? '' }}</title>
</head>
<body>
    <h3>Tambah Siswa</h3>
    <form action="{{ route('siswa.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="">Nama</label>
            <input type="text" name="nama" placeholder="Masukkan Nama" required>
        </div>
        <br>
        <div class="form-group">
            <label for="">Nilai</label>
            <input type="text" name="nilai" placeholder="Masukkan Nilai" required>
        </div>
        <div class="form-group">
            <button type="submit">Simpan</button>
        </div>
    </form>
</body>
</html>
