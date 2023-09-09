<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\PosisiKeuangan;
use Illuminate\Http\Request;

class PosisiKeuanganCtrl extends Controller
{
    public function index(Request $request)
    {
        $data['menu'] = 'posisi_keuangan';
        return view('posisi_keuangan.index', $data);
    }

    public function data(Request $request)
    {
        $asset_lancar = PosisiKeuangan::on(\Config('db'))->where('urutan',1)->orderBy('id_coa','ASC')->get();
        $asset_tidak_lancar = PosisiKeuangan::on(\Config('db'))->where('urutan',2)->orderBy('id_coa','ASC')->get();
        $liabilitas = PosisiKeuangan::on(\Config('db'))->where('urutan',4)->orderBy('id_coa','ASC')->get();
        $ekuitas = PosisiKeuangan::on(\Config('db'))->where('urutan',5)->orderBy('id_coa','ASC')->get();

        $data['menu'] = 'posisi_keuangan';
        $data['asset_lancar'] = $asset_lancar;
        $data['asset_tidak_lancar'] = $asset_tidak_lancar;
        $data['liabilitas'] = $liabilitas;
        $data['ekuitas'] = $ekuitas;
        return view('posisi_keuangan.data', $data);
    }

}
