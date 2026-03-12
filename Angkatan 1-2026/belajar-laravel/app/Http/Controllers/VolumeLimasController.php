<?php

namespace App\Http\Controllers;

use App\Models\Limas;
use Illuminate\Http\Request;

class VolumeLimasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //SELECT * FROM limas;
        $limas = \App\Models\Limas::orderBy('id', 'DESC')->get();
        return view('limas.index', compact('limas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('limas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //untuk wajib isi minimal angka 1
        $request->validate([
            'luas_alas' => 'required|numeric|min:1',
            'tinggi' => 'required|numeric|min:1'
        ]);


        $l_alas = $request->luas_alas;
        $t = $request->tinggi;
        $hasil = 1 /3 * $l_alas * $t;
        //INSERT INTO limas () VALUES ();
        Limas::create([
            'luas_alas' => $l_alas,
            'tinggi' =>  $t,
            'hasil' => $hasil
        ]);
        return redirect()->route('volumelimas.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $limas = \App\Models\Limas::find($id);
        return view('limas.edit', compact('limas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $limas = \App\Models\Limas::find($id);
        $request->validate([
            'luas_alas' => 'required|numeric|min:1',
            'tinggi' => 'required|numeric|min:1'
        ]);

        $limas->luas_alas = $request->luas_alas;
        $limas->tinggi = $request->tinggi;
        $limas->hasil = 1 / 3 * $request->luas_alas * $request->tinggi;
        $limas->update();

        return redirect()->route('volumelimas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $limas = \App\Models\Limas::find($id);
        $limas->delete();

        return redirect()->route('volumelimas.index');
    }
}
