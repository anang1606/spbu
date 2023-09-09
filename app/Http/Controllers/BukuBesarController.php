<?php

namespace App\Http\Controllers;

use App\Account;
use App\CoaSaldo;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Datatables;

class BukuBesarController extends Controller
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
            return view('buku_besar.index', compact('all_permission','tahun','coa'));
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
			if($akun =='') {
           		return redirect()->back()->with('message', 'Pengguna Wajib Memilih Akun');
       		}

			$date = date_create($hari);

			if($hari=='') return '404';

			$menu = 'buku_besar';

        	$datepicker = true;

			$rangeFilter = "Tanggal ".date_format($date, 'd F Y');
			$tahun = date_format($date,"Y");

			$saldotahun = \DB::table('accounts')
                    ->select(DB::raw('sum(initial_balance - total_balance) as saldo'))
					->where('tahun', '=', $tahun)
					->where('account_no', '=', $akun)
					->first()->saldo;

			if (date_format($date,"d-m") != "01-01")
			{
				$prevdebit = \DB::table('coa_jurnal')
						->select(DB::raw('sum(debit) as total'))
						->where(DB::raw("(DATE_FORMAT(tanggal,'%Y'))"),$tahun)
						->where('tanggal', '<', $date)
						->where('idcoa', '=', $akun)
						->first()->total;

				$prevkredit = \DB::table('coa_jurnal')
						->select(DB::raw('sum(kredit) as total'))
						->where(DB::raw("(DATE_FORMAT(tanggal,'%Y'))"),$tahun)
						->where('tanggal', '<', $date)
						->where('idcoa', '=', $akun)
						->first()->total;
			}
			else
			{
				$prevdebit = 0;
				$prevkredit = 0;
			}

			$saldoawal = ($saldotahun + $prevdebit)-$prevkredit;

			$acc = $this->myQuery('Harian',$saldoawal,date_format($date, 'Y/m/d'),$akun,$saldoakhir);

			if (strlen($akun) > 0)
				$coaname = Account::where('account_no', '=', $akun)->first()->name;
			else
				$coaname	= '';

        	return view('buku_besar.view', compact('menu', 'acc', 'rangeFilter','akun','coaname','saldoawal','saldoakhir'));
    }

    public function _getDataBulanan(Request $request)
    {
			$bulans = $request->bulan;

			$s = explode(';',$bulans);
			$bulan = $s[0];
			$akun = $s[1];
			if($akun =='') {
           		return redirect()->back()->with('message', 'Pengguna Wajib Memilih Akun');
       		}

			$date = date_create($bulan.'-01');
			if($bulan=='') return '404';
			$menu = 'buku_besar';
			$datepicker = true;

			$rangeFilter = date_format($date,"F Y");
			$tahun = date_format($date,"Y");

			$saldotahun = \DB::table('accounts')
                    ->select(DB::raw('sum(initial_balance - total_balance) as saldo'))
					->where('tahun', '=', $tahun)
					->where('account_no', '=', $akun)
					->first()->saldo;

			if (date_format($date,"d-m") != "01-01")
			{
				$prevdebit = \DB::table('coa_jurnal')
						->select(DB::raw('sum(debit) as total'))
						->where(DB::raw("(DATE_FORMAT(tanggal,'%Y'))"),$tahun)
						->where('tanggal', '<', $date)
						->where('idcoa', '=', $akun)
						->first()->total;

				$prevkredit = \DB::table('coa_jurnal')
						->select(DB::raw('sum(kredit) as total'))
						->where(DB::raw("(DATE_FORMAT(tanggal,'%Y'))"),$tahun)
						->where('tanggal', '<', $date)
						->where('idcoa', '=', $akun)
						->first()->total;
			}
			else
			{
				$prevdebit = 0;
				$prevkredit = 0;
			}

			$saldoawal = ($saldotahun + $prevdebit)-$prevkredit;

            $acc = $this->myQuery('Bulanan',$saldoawal,$bulan,$akun,$saldoakhir);

			if (strlen($akun) > 0)
				$coaname	= Account::where('account_no', '=', $akun)->first()->name;
			else
				$coaname	= '';

        	return view('buku_besar.view', compact('menu', 'acc', 'rangeFilter','akun','coaname','saldoawal','saldoakhir'));
    }

    public function _getDataTahunan(Request $request)
    {
			$tahuns = $request->tahun;

			$s = explode(';',$tahuns);
			$tahun = $s[0];
			$akun = $s[1];
			if($akun =='') {
			    return redirect()->back()->with('message', 'Pengguna Wajib Memilih Akun');
			}

			if($tahun=='') return '404';

			$menu = 'buku_besar';

			$saldoawal = \DB::table('accounts')
                    ->select(DB::raw('sum(initial_balance - total_balance) as saldo'))
					->where('tahun', '=', $tahun)
					->where('account_no', '=', $akun)
					->first()->saldo;

        	$datepicker = true;

            $acc = $this->myQuery('Tahunan',$saldoawal,$tahun,$akun,$saldoakhir);
			$rangeFilter = $tahun;
			if (strlen($akun) > 0)
				$coaname = Account::where('account_no', '=', $akun)->first()->name;
			else
				$coaname	= '';

        	return view('buku_besar.view', compact('menu', 'acc', 'rangeFilter','akun','coaname','saldoawal','saldoakhir'));
    }

    public function myQuery($jnsdata,$vsaldo,$vdata,$vakun,&$vsaldoakhir)
	{
		if (strlen($vakun) > 0)
			$where1 = "idcoa = '$vakun'";
		else
			$where1 = "idcoa IS NOT NULL";

		if ($jnsdata == 'Harian')
		{
			$where2 = "tanggal = '$vdata'";
		}
		elseif ($jnsdata == 'Bulanan')
		{
			$where2 = "DATE_FORMAT(tanggal, '%Y-%m') = '$vdata'";
		}
		elseif ($jnsdata == 'Tahunan')
		{
			$where2 = "YEAR(tanggal) = ".$vdata;
		}

		$data = \DB::select("SELECT tanggal, kode_reff, keterangan, debit, kredit,
		@saldo := @saldo + debit - kredit AS saldo
		FROM coa_jurnal, (SELECT @saldo := $vsaldo) AS variableInit
		WHERE $where1 AND $where2 ORDER BY id,tanggal");

		$data2 = \DB::select("SELECT @saldo := @saldo + debit - kredit AS saldo
		FROM coa_jurnal, (SELECT @saldo := $vsaldo) AS variableInit
		WHERE $where1 AND $where2 ORDER BY id desc,tanggal desc Limit 1");

		if ($data2 == true)
			$vsaldoakhir = $data2[0]->saldo;
		else
			$vsaldoakhir = 0;

		return $data;
	}

}