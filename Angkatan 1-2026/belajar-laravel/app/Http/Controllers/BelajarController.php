<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BelajarController extends Controller
{
    public function index()
    {
        return view('belajar');
    }
    public function getSiswa()
    {
        $tittle = "Data Siswa";
        $siswa = [
            [
                'nama' => 'Kylie Jenner',
                'nilai' => 100,
            ],
            [
                'nama' => 'Kendal Gomes',
                'nilai' => 90,
            ],
            [
                'nama' => 'Critstina peri',
                'nilai' => 60,
            ],
        ];
        return view('siswa', compact('tittle', 'siswa'));
    }
    public function create()
    {
        return view('tambah-siswa');

    }

    public function store(Request $request)
    {
        $nama = $request->nama;
        $nilai = $request->nilai;

        $status = $nilai >= 75 ? 'Lulus' : 'Tidak Lulus';

        return "Siswa $nama dengan nilai $nilai dinyatakan $status";
    }
}
