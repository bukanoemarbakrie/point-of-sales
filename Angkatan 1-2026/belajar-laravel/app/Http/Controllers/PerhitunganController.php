<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerhitunganController extends Controller
{

    function indexLPkubus(Request $request)
    {
        return view('kubus.lp_kubus');
    }
    public function indexVkubus() {
        return view('kubus.v_kubus');
    }
    public function indexVtabung() {
        return view('tabung.v_tabung');
    }


    function store(Request $request)
    {
        $angka1 = $request->angka1;
        $angka2 = $request->angka2;
        $operator = $request->operator;

        $hasil = 0;

        switch ($operator) {
            case '+':
                $hasil = $angka1 + $angka2;
                break;
            case '-':
                $hasil = $angka1 - $angka2;
                break;
            case '*':
                $hasil = $angka1 * $angka2;
                break;
            case '/':
                if ($angka2 == 0) {
                    return back()->with('eror', 'Tidak bisa dibagi 0');
                }
                $hasil = $angka1 / $angka2;
                break;
        }
        return view('perhitungan.index', compact('hasil'));
    }

    function storeLPkubus(Request $request)
    {
        //L = 6*s^2
        $s = $request->sisi;
        $hasil = 6 * $s * $s;

        return view('kubus.lp_kubus', compact('hasil'));
    }

    function storeVkubus(Request $request) {
       //V = s^3
       $s = $request->sisi;
       $hasil = $s * $s * $s;

       return view('kubus.v_kubus', compact('hasil'));
   }
   function storeLPtabung(Request $request) {
       //V = s^3
       $jari = $request->jari;
       $tinggi = $request->tinggi;
       $hasil = 2 * 3.14 * $jari * ($jari + $tinggi);

       return view('tabung.lp_tabung', compact('hasil'));
   }

//    function storeVtabung(Request $request) {
//        //V = s^3
//        $jari = $request->jari;
//        $tinggi = $request->tinggi;
//        $hasil = 2 * 3.14 * $jari * ($jari + $tinggi);

//        return view('tabung.v_tabung', compact('hasil'));
//    }
}

