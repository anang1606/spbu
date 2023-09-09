<?php

namespace App\Http\Controllers;

use App\Account;
use App\CoaSaldo;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Datatables;

class JurnalUmumController extends Controller
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
        if($role->hasPermissionTo('products-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';

            $coa = Account::where('note', 'NOT LIKE', 'Level%')->orderby('account_no')->get();
            return view('jurnal_umum.index', compact('all_permission','tahun','coa'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function _getDataHarian(Request $request)
    {
			$haris = $request->hari;

			$s = explode(';',$haris);
			$hari = $s[0];
			$akun = $s[1];
			$variable = 'Harian';

			$date = date_create($hari);

			if($hari=='') return '404';

			$menu = 'jurnal_umum';

        	$datepicker = true;

			$rangeFilter = "Tanggal ".date_format($date, 'd F Y');

			if (strlen($akun) > 0)
			{
				$coaname	= Account::where('account_no', '=', $akun)->first()->name;
				$acc = \DB::table('acc_jurnalumum')
                    ->select(
                        'acc_jurnalumum.tanggal',
                        'acc_jurnalumum.kode_reff',
                        'acc_jurnalumum.keterangan',
						DB::raw('CONCAT(acc_jurnalumum.coadebit, " | ", a1.name) AS coadebit'),
						DB::raw('CONCAT(acc_jurnalumum.coakredit, " | ", a2.name) AS coakredit'),
                        'acc_jurnalumum.saldo'
                    )
                    ->join('accounts as a1', 'acc_jurnalumum.coadebit', '=', 'a1.account_no')
					->join('accounts as a2', 'acc_jurnalumum.coakredit', '=', 'a2.account_no')
					->where('acc_jurnalumum.tanggal','=',$date)
					->where('coadebit','=',$akun)
					->orwhere('coakredit','=',$akun)
					->orderby('acc_jurnalumum.tanggal')
                    ->get();
			}
			else
			{
				$coaname	= '';
				$acc = \DB::table('acc_jurnalumum')
                    ->select(
                        'acc_jurnalumum.tanggal',
                        'acc_jurnalumum.kode_reff',
                        'acc_jurnalumum.keterangan',
						DB::raw('CONCAT(acc_jurnalumum.coadebit, " | ", a1.name) AS coadebit'),
						DB::raw('CONCAT(acc_jurnalumum.coakredit, " | ", a2.name) AS coakredit'),
                        'acc_jurnalumum.saldo'
                    )
                    ->join('accounts as a1', 'acc_jurnalumum.coadebit', '=', 'a1.account_no')
					->join('accounts as a2', 'acc_jurnalumum.coakredit', '=', 'a2.account_no')
					->where('acc_jurnalumum.tanggal','=',$date)
					->orderby('acc_jurnalumum.tanggal')
                    ->get();
			}

        	return view('jurnal_umum.view', compact('menu', 'acc', 'rangeFilter','akun','coaname','variable','hari'));
    }

    public function _getDataBulanan(Request $request)
    {
			$bulans = $request->bulan;

			$s = explode(';',$bulans);
			$bulan = $s[0];
			$akun = $s[1];
			$variable = 'Bulanan';

			$date = date_create($bulan.'-01');

            if($bulan=='') return '404';

			$menu = 'jurnal_umum';

        	$datepicker = true;

			$rangeFilter = "Bulan ".date_format($date,"F Y");

			if (strlen($akun) > 0)
			{
				$coaname = Account::where('account_no', '=', $akun)->first()->name;
				$acc = \DB::table('acc_jurnalumum')
                    ->select(
                        'acc_jurnalumum.tanggal',
                        'acc_jurnalumum.kode_reff',
                        'acc_jurnalumum.keterangan',
						DB::raw('CONCAT(acc_jurnalumum.coadebit, " | ", a1.name) AS coadebit'),
						DB::raw('CONCAT(acc_jurnalumum.coakredit, " | ", a2.name) AS coakredit'),
                        'acc_jurnalumum.saldo'
                    )
                    ->join('accounts as a1', 'acc_jurnalumum.coadebit', '=', 'a1.account_no')
					->join('accounts as a2', 'acc_jurnalumum.coakredit', '=', 'a2.account_no')
					->where(DB::raw("(DATE_FORMAT(acc_jurnalumum.tanggal,'%Y-%m'))"),$bulan)
					->where('coadebit','=',$akun)
					->orwhere('coakredit','=',$akun)
					->orderby('acc_jurnalumum.tanggal')
                    ->get();

			}
			else
			{
				$coaname	= '';
				$acc = \DB::table('acc_jurnalumum')
                    ->select(
                        'acc_jurnalumum.tanggal',
                        'acc_jurnalumum.kode_reff',
                        'acc_jurnalumum.keterangan',
						DB::raw('CONCAT(acc_jurnalumum.coadebit, " | ", a1.name) AS coadebit'),
						DB::raw('CONCAT(acc_jurnalumum.coakredit, " | ", a2.name) AS coakredit'),
                        'acc_jurnalumum.saldo'
                    )
                    ->join('accounts as a1', 'acc_jurnalumum.coadebit', '=', 'a1.account_no')
					->join('accounts as a2', 'acc_jurnalumum.coakredit', '=', 'a2.account_no')
					->where(DB::raw("(DATE_FORMAT(acc_jurnalumum.tanggal,'%Y-%m'))"),$bulan)
					->orderby('acc_jurnalumum.tanggal')
                    ->get();

			}

        	return view('jurnal_umum.view', compact('menu', 'acc', 'rangeFilter','akun', 'coaname','variable','bulan'));
    }

    public function _getDataTahunan(Request $request)
    {
			$tahuns = $request->tahun;

			$s = explode(';',$tahuns);
			$tahun = $s[0];
			$akun = $s[1];
			$variable = 'Tahunan';


			if($tahun=='') return '404';

			$menu = 'jurnal_umum';

        	$datepicker = true;
			$rangeFilter = 'Tahun '.$tahun;
			if (strlen($akun) > 0)
			{
				$coaname = Account::where('account_no', '=', $akun)->first()->name;
				$acc = \DB::table('acc_jurnalumum')
                    ->select(
                        'acc_jurnalumum.tanggal',
                        'acc_jurnalumum.kode_reff',
                        'acc_jurnalumum.keterangan',
						DB::raw('CONCAT(acc_jurnalumum.coadebit, " | ", a1.name) AS coadebit'),
						DB::raw('CONCAT(acc_jurnalumum.coakredit, " | ", a2.name) AS coakredit'),
                        'acc_jurnalumum.saldo'
                    )
                    ->join('accounts as a1', 'acc_jurnalumum.coadebit', '=', 'a1.account_no')
					->join('accounts as a2', 'acc_jurnalumum.coakredit', '=', 'a2.account_no')
					->where(DB::raw("(DATE_FORMAT(acc_jurnalumum.tanggal,'%Y'))"),$tahun)
					->where('coadebit','=',$akun)
					->orwhere('coakredit','=',$akun)
					->orderby('acc_jurnalumum.tanggal')
                    ->get();
			}
			else
			{
				$coaname	= '';
				$acc = \DB::table('acc_jurnalumum')
                    ->select(
                        'acc_jurnalumum.tanggal',
                        'acc_jurnalumum.kode_reff',
                        'acc_jurnalumum.keterangan',
						DB::raw('CONCAT(acc_jurnalumum.coadebit, " | ", a1.name) AS coadebit'),
						DB::raw('CONCAT(acc_jurnalumum.coakredit, " | ", a2.name) AS coakredit'),
                        'acc_jurnalumum.saldo'
                    )
                    ->join('accounts as a1', 'acc_jurnalumum.coadebit', '=', 'a1.account_no')
					->join('accounts as a2', 'acc_jurnalumum.coakredit', '=', 'a2.account_no')
					->where(DB::raw("(DATE_FORMAT(acc_jurnalumum.tanggal,'%Y'))"),$tahun)
					->orderby('acc_jurnalumum.tanggal')
                    ->get();
			}

        	return view('jurnal_umum.view', compact('menu', 'acc', 'rangeFilter','akun','coaname','variable','tahun'));
    }

}
