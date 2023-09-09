<?php

namespace App\Http\Controllers;

use App\AccNeracaLajur;
use App\Account;
use App\LabaRugi as ModelLabaRugi;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Datatables;

class LabaRugiController extends Controller
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
            return view('laba_rugi.index', compact('all_permission', 'tahun', 'coa'));
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function data(Request $request)
    {

        $get_data = ModelLabaRugi::where('tahun',$request->tahun)->get();

        $data['tahun'] = $request->tahun;
        $data['data'] = $get_data;
        return view('laba_rugi.data',$data);
    }
}
