<?php

namespace App\Http\Controllers;

use App\AccNeracaLajur;
use App\Account;
use App\CoaSaldo;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Datatables;

class NeracaLajurController extends Controller
{
    public function index()
    {
        $thnnow = date('Y');
        $thn = 2020;
        $tahun = [];
        for ($i = 0; $i < 100; $i++) {
            $thn = $thn + 1;
            array_push($tahun, ($thn));
            if ($thn >= $thnnow) break;
        }

        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('products-index')) {
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if (empty($all_permission))
                $all_permission[] = 'dummy text';

            $coa = Account::where('note', 'NOT LIKE', 'Level%')->orderby('account_no')->get();
            return view('neraca_lajur.index', compact('all_permission', 'tahun', 'coa'));
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function _getDataHarian(Request $request)
    {
        $haris = $request->hari;

        $s = explode(';', $haris);
        $hari = $s[0];
        //$akun = $s[1];

        $date = date_create($hari);
        $rangeFilter = "Tanggal " . date_format($date, "d F Y");

        if ($hari == '') return '404';

        $menu = 'neraca_lajur';

        $datepicker = true;
        $tahun = date_format($date, "Y");

        AccNeracaLajur::whereNotNull('idcoa')
            ->delete();

        $level1  = Account::where('note', '=', 'Level 1')
            ->get();

        foreach ($level1 as $row1) {
            $totalakun = \DB::table('coa_jurnal')
                ->select(DB::raw('sum(debit+kredit) as total'))
                ->where(DB::raw("(DATE_FORMAT(tanggal,'%Y'))"), $tahun)
                ->where('idcoa', 'Like', substr($row1->account_no, 0, 1) . "%")
                ->first()->total;

            if ($totalakun > 0) {
                $select = Account::select('account_no', 'name', 'note')
                    ->where('note', 'LIKE', 'Level%')
                    ->where('account_no', 'LIKE', substr($row1->account_no, 0, 1) . '%')
                    ->orderby('account_no');

                $rows_inserted = AccNeracaLajur::insertUsing(['idcoa', 'namacoa', 'typecoa'], $select);

                $dataisi = \DB::table('coa_jurnal')
                    ->select(
                        'coa_jurnal.idcoa',
                        'a1.name',
                        'a1.note'
                    )
                    ->join('accounts as a1', 'coa_jurnal.idcoa', '=', 'a1.account_no')
                    ->where(DB::raw("(DATE_FORMAT(coa_jurnal.tanggal,'%Y'))"), $tahun)
                    ->where('a1.note', 'NOT LIKE', 'Level%')
                    ->where('coa_jurnal.idcoa', 'LIKE', substr($row1->account_no, 0, 1) . '%')
                    ->orderby('coa_jurnal.idcoa')
                    ->get()
                    ->unique();

                foreach ($dataisi as $row2) {
                    $saldo = Account::where('account_no', '=', $row2->idcoa)
                        ->first();
                    if ($saldo == true) {
                        $adebit = $saldo->initial_balance;
                        $akredit = $saldo->total_balance;
                    } else {
                        $adebit = 0;
                        $akredit = 0;
                    }

                    $gerakan = \DB::table('coa_jurnal')
                        ->select(DB::raw('sum(debit) as bdebit'), DB::raw('sum(kredit) as bkredit'))
                        ->where(DB::raw("(DATE_FORMAT(tanggal,'%Y'))"), $tahun)
                        ->where('idcoa', '=', $row2->idcoa)
                        ->first();

                    if ($gerakan == true) {
                        $bdebit = $gerakan->bdebit;
                        $bkredit = $gerakan->bkredit;
                    } else {
                        $bdebit = 0;
                        $bkredit = 0;
                    }

                    $dtlevel1 = new AccNeracaLajur();
                    $dtlevel1->idcoa = $row2->idcoa;
                    $dtlevel1->namacoa   = $row2->name;
                    $dtlevel1->typecoa  = $row2->note;
                    $dtlevel1->adebit  = $adebit;
                    $dtlevel1->akredit  = $akredit;
                    $dtlevel1->bdebit  = $bdebit;
                    $dtlevel1->bkredit  = $bkredit;
                    $dtlevel1->cdebit  = $adebit + $bdebit;
                    $dtlevel1->ckredit  = $akredit + $bkredit;
                    if (substr($row1->idcoa, 0, 1) == '1') {
                        $dtlevel1->edebit  = $adebit + $bdebit;
                        $dtlevel1->ekredit  = $akredit + $bkredit;
                    }
                    $dtlevel1->save();
                }
            } else {
                $dtlevel1 = new AccNeracaLajur();
                $dtlevel1->idcoa = $row1->account_no;
                $dtlevel1->namacoa   = $row1->name;
                $dtlevel1->typecoa  = $row1->note;
                $dtlevel1->save();
            }
        }

        $total1 = \DB::table('acc_neracalajur')
            ->select(
                DB::raw('sum(adebit) as tadebit'),
                DB::raw('sum(akredit) as takredit'),
                DB::raw('sum(bdebit) as tbdebit'),
                DB::raw('sum(bkredit) as tbkredit'),
                DB::raw('sum(cdebit) as tcdebit'),
                DB::raw('sum(ckredit) as tckredit'),
                DB::raw('sum(ddebit) as tddebit'),
                DB::raw('sum(dkredit) as tdkredit'),
                DB::raw('sum(edebit) as tedebit'),
                DB::raw('sum(ekredit) as tekredit')
            )
            ->first();
        $neraca  = AccNeracaLajur::orderby('idcoa')->get();

        return view('neraca_lajur.view', compact('menu', 'rangeFilter', 'neraca', 'rangeFilter', 'total1'));
    }

    public function _getDataBulanan(Request $request)
    {
        $bulans = $request->bulan;

        $s = explode(';', $bulans);
        $bulan = $s[0];
        //$akun = $s[1];

        $date = date_create($bulan . '-01');

        if ($bulan == '') return '404';

        $menu = 'neraca_lajur';

        $datepicker = true;
        $rangeFilter = "Bulan " . date_format($date, "F Y");
        $tahun = date_format($date, "Y");

        AccNeracaLajur::whereNotNull('idcoa')
            ->delete();

        $level1 = Account::where('note', '=', 'Level 1')
            ->get();

        foreach ($level1 as $row1) {
            $totalakun = \DB::table('coa_jurnal')
                ->select(DB::raw('sum(debit+kredit) as total'))
                ->where(DB::raw("(DATE_FORMAT(tanggal,'%Y'))"), $tahun)
                ->where('idcoa', 'Like', substr($row1->account_no, 0, 1) . "%")
                ->first()->total;
            if ($totalakun > 0) {
                $select = Account::select('account_no', 'name', 'note')
                    ->where('note', 'LIKE', 'Level%')
                    ->where('account_no', 'LIKE', substr($row1->account_no, 0, 1) . '%')
                    ->orderby('account_no');

                $rows_inserted = AccNeracaLajur::insertUsing(['idcoa', 'namacoa', 'typecoa'], $select);

                $dataisi = \DB::table('coa_jurnal')
                    ->select(
                        'coa_jurnal.idcoa',
                        'a1.name',
                        'a1.note'
                    )
                    ->join('accounts as a1', 'coa_jurnal.idcoa', '=', 'a1.account_no')
                    ->where(DB::raw("(DATE_FORMAT(coa_jurnal.tanggal,'%Y'))"), $tahun)
                    ->where('a1.note', 'NOT LIKE', 'Level%')
                    ->where('coa_jurnal.idcoa', 'LIKE', substr($row1->account_no, 0, 1) . '%')
                    ->orderby('coa_jurnal.idcoa')
                    ->get()
                    ->unique();

                foreach ($dataisi as $row2) {
                    $saldo = Account::where('account_no', '=', $row2->idcoa)
                        ->first();

                    if ($saldo == true) {
                        $adebit = $saldo->initial_balance;
                        $akredit = $saldo->total_balance;
                    } else {
                        $adebit = 0;
                        $akredit = 0;
                    }

                    $gerakan = \DB::table('coa_jurnal')
                        ->select(DB::raw('sum(debit) as bdebit'), DB::raw('sum(kredit) as bkredit'))
                        ->where(DB::raw("(DATE_FORMAT(tanggal,'%Y'))"), $tahun)
                        ->where('idcoa', '=', $row2->idcoa)
                        ->first();

                    if ($saldo == true) {
                        $adebit = $saldo->debit;
                        $akredit = $saldo->kredit;
                    } else {
                        $adebit = 0;
                        $akredit = 0;
                    }


                    $gerakan = \DB::table('coa_jurnal')
                        ->select(DB::raw('sum(debit) as bdebit'), DB::raw('sum(kredit) as bkredit'))
                        ->where(DB::raw("(DATE_FORMAT(tanggal,'%Y'))"), $tahun)
                        ->where('idcoa', '=', $row2->idcoa)
                        ->first();

                    if ($gerakan == true) {
                        $bdebit = $gerakan->bdebit;
                        $bkredit = $gerakan->bkredit;
                    } else {
                        $bdebit = 0;
                        $bkredit = 0;
                    }


                    $dtlevel1 = new AccNeracaLajur();
                    $dtlevel1->idcoa = $row2->idcoa;
                    $dtlevel1->namacoa = $row2->name;
                    $dtlevel1->typecoa = $row2->note;
                    $dtlevel1->adebit = $adebit;
                    $dtlevel1->akredit = $akredit;
                    $dtlevel1->bdebit = $bdebit;
                    $dtlevel1->bkredit = $bkredit;
                    $dtlevel1->cdebit = $adebit + $bdebit;
                    $dtlevel1->ckredit = $akredit + $bkredit;
                    if (substr($row1->idcoa, 0, 1) == '1') {
                        $dtlevel1->edebit  = $adebit + $bdebit;
                        $dtlevel1->ekredit  = $akredit + $bkredit;
                    }
                    $dtlevel1->save();
                }
            } else {
                $dtlevel1 = new AccNeracaLajur();
                $dtlevel1->idcoa = $row1->account_no;
                $dtlevel1->namacoa = $row1->name;
                $dtlevel1->typecoa = $row1->note;
                $dtlevel1->save();
            }
        }

        $total1 = \DB::table('acc_neracalajur')
            ->select(
                DB::raw('sum(adebit) as tadebit'),
                DB::raw('sum(akredit) as takredit'),
                DB::raw('sum(bdebit) as tbdebit'),
                DB::raw('sum(bkredit) as tbkredit'),
                DB::raw('sum(cdebit) as tcdebit'),
                DB::raw('sum(ckredit) as tckredit'),
                DB::raw('sum(ddebit) as tddebit'),
                DB::raw('sum(dkredit) as tdkredit'),
                DB::raw('sum(edebit) as tedebit'),
                DB::raw('sum(ekredit) as tekredit')
            )
            ->first();
        $neraca  = AccNeracaLajur::orderby('idcoa')->get();
        return view('neraca_lajur.view', compact('menu', 'rangeFilter', 'neraca', 'rangeFilter', 'total1'));
    }

    public function _getDataTahunan(Request $request)
    {
        $tahuns = $request->tahun;

        $s = explode(';', $tahuns);
        $tahun = $s[0];

        if ($tahun == '') return '404';

        $menu = 'neraca_lajur';

        $datepicker = true;
        $rangeFilter = 'Tahun ' . $tahun;

        AccNeracaLajur::whereNotNull('idcoa')
            ->delete();

        $level1 = Account::where('note', '=', 'Level 1')
            ->get();

        foreach ($level1 as $row1) {
            $totalakun = \DB::table('coa_jurnal')
                ->select(DB::raw('sum(debit+kredit) as total'))
                ->where(DB::raw("(DATE_FORMAT(tanggal,'%Y'))"), $tahun)
                ->where('idcoa', 'Like', substr($row1->account_no, 0, 1) . "%")
                ->first()->total;

            if ($totalakun > 0) {
                $select = Account::select('account_no', 'name', 'note')
                    ->where('note', 'LIKE', 'Level%')
                    ->where('account_no', 'LIKE', substr($row1->account_no, 0, 1) . '%')
                    ->orderby('account_no');

                $rows_inserted = AccNeracaLajur::insertUsing(['idcoa', 'namacoa', 'typecoa'], $select);

                $dataisi = \DB::table('coa_jurnal')
                    ->select(
                        'coa_jurnal.idcoa',
                        'a1.name',
                        'a1.note'
                    )
                    ->join('accounts as a1', 'coa_jurnal.idcoa', '=', 'a1.account_no')
                    ->where(DB::raw("(DATE_FORMAT(coa_jurnal.tanggal,'%Y'))"), $tahun)
                    ->where('a1.note', 'NOT LIKE', 'Level%')
                    ->where('coa_jurnal.idcoa', 'LIKE', substr($row1->account_no, 0, 1) . '%')
                    ->orderby('coa_jurnal.idcoa')
                    ->get()
                    ->unique();

                foreach ($dataisi as $row2) {
                    $saldo = Account::where('account_no', '=', $row2->idcoa)
                        ->first();

                    if ($saldo == true) {
                        $adebit = $saldo->initial_balance;
                        $akredit = $saldo->total_balance;
                    } else {
                        $adebit = 0;
                        $akredit = 0;
                    }

                    $gerakan = \DB::table('coa_jurnal')
                        ->select(DB::raw('sum(debit) as bdebit'), DB::raw('sum(kredit) as bkredit'))
                        ->where(DB::raw("(DATE_FORMAT(tanggal,'%Y'))"), $tahun)
                        ->where('idcoa', '=', $row2->idcoa)
                        ->first();

                    if ($saldo == true) {
                        $adebit = $saldo->debit;
                        $akredit = $saldo->kredit;
                    } else {
                        $adebit = 0;
                        $akredit = 0;
                    }


                    $gerakan = \DB::table('coa_jurnal')
                        ->select(DB::raw('sum(debit) as bdebit'), DB::raw('sum(kredit) as bkredit'))
                        ->where(DB::raw("(DATE_FORMAT(tanggal,'%Y'))"), $tahun)
                        ->where('idcoa', '=', $row2->idcoa)
                        ->first();

                    if ($gerakan == true) {
                        $bdebit = $gerakan->bdebit;
                        $bkredit = $gerakan->bkredit;
                    } else {
                        $bdebit = 0;
                        $bkredit = 0;
                    }


                    $dtlevel1 = new AccNeracaLajur();
                    $dtlevel1->idcoa = $row2->idcoa;
                    $dtlevel1->namacoa = $row2->name;
                    $dtlevel1->typecoa = $row2->note;
                    $dtlevel1->adebit = $adebit;
                    $dtlevel1->akredit = $akredit;
                    $dtlevel1->bdebit = $bdebit;
                    $dtlevel1->bkredit = $bkredit;
                    $dtlevel1->cdebit = $adebit + $bdebit;
                    $dtlevel1->ckredit = $akredit + $bkredit;
                    if (substr($row1->idcoa, 0, 1) == '1') {
                        $dtlevel1->edebit  = $adebit + $bdebit;
                        $dtlevel1->ekredit  = $akredit + $bkredit;
                    }
                    $dtlevel1->save();
                }
            }else {
                $dtlevel1 = new AccNeracaLajur();
                $dtlevel1->idcoa = $row1->account_no;
                $dtlevel1->namacoa = $row1->name;
                $dtlevel1->typecoa = $row1->note;
                $dtlevel1->save();
            }
        }

        $total1 = \DB::table('acc_neracalajur')
            ->select(
                DB::raw('sum(adebit) as tadebit'),
                DB::raw('sum(akredit) as takredit'),
                DB::raw('sum(bdebit) as tbdebit'),
                DB::raw('sum(bkredit) as tbkredit'),
                DB::raw('sum(cdebit) as tcdebit'),
                DB::raw('sum(ckredit) as tckredit'),
                DB::raw('sum(ddebit) as tddebit'),
                DB::raw('sum(dkredit) as tdkredit'),
                DB::raw('sum(edebit) as tedebit'),
                DB::raw('sum(ekredit) as tekredit')
            )
            ->first();
        $neraca  = AccNeracaLajur::orderby('idcoa')->get();
        return view('neraca_lajur.view', compact('menu', 'rangeFilter', 'neraca', 'rangeFilter', 'total1'));
    }
}
