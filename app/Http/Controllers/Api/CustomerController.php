<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Customer;
use App\CustomerGroup;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Storage;


class CustomerController extends Controller
{
	//=============account API===========================	
	/* User create_account API */	
	
	public function cekdata(Request $request)
    {
		$myinput =  $request->input()['data'];
		$mydata = explode(";", $myinput);
		$idcustomer = $mydata[0];
		$plat = $mydata[1];
		$idgroup = $mydata[2];
		$perusahaan = $mydata[3];
		$jenis = $mydata[4];
		$idproduk = $mydata[5];
		
		$listcustomers = DB::select(DB::raw("SELECT * FROM customers WHERE id = :idcustomer and name = :plat and customer_group_id = :idgroup and company_name = :perusahaan and jenis_kendaraan = :jenis and product_id = :idproduk"), 
		array("idcustomer" =>$idcustomer,"plat" =>$plat,"idgroup" =>$idgroup,"perusahaan" =>$perusahaan,"jenis" =>$jenis,"idproduk" =>$idproduk,));
		if( !empty($listcustomers))
		{
			if ($listcustomers[0]->is_active === 1)
			{
				$listcustomergroups = CustomerGroup::where(['id' => $idgroup])->get();
				if( !empty($listcustomergroups) )
				{
					$listproducts = Product::where(['id' => $idproduk])->get();
					if( !empty($listproducts) )
						$data = array("status"=>"OK","message"=>"Produk ada!","listcustomers"=>$listcustomers,"listcustomergroups"=>$listcustomergroups,"listproducts"=>$listproducts,"result"=>1);
					else
						$data = array("status"=>"error","message"=>"Data Produk tidak ada!","result"=>0);
				}
				else
					$data = array("status"=>"error","message"=>"Perusahaan tidak terdafta!","result"=>0);	
			}	
			else			
				$data = array("status"=>"error","message"=>"Kendaraan sudah tidak aktif!","result"=>$listcustomers);	
		}
		else
			$data = array("status"=>"error","message"=>"Data tidak sesuai!","result"=>0);
					 
        return response()->json($data);	
	}	
}