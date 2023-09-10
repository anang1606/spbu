<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
	//=============account API===========================	
	/* User create_account API */	
	
	//api exist user login
	
	public function getall(Request $request)
    {
		$listproducts = DB::select("SELECT * FROM products");
		if( !empty($listproducts)) $dtproducts = 1; else $dtproducts = 0;	
		$data = array("status"=>"OK","message"=>"Produk ada!","dtproducts"=>$dtproducts,"listproducts"=>$listproducts,"result"=>0);
        return response()->json($data);	
	}
	
	public function cekharga(Request $request)
    {
		$idproduk =  $request->input()['data'];
		
		$product = Product::where(['id' => $idproduk])->first();
		if( !empty($product) )
			$data = array("status"=>"OK","message"=>"Produk ada!","harga"=>$product->price,"result"=>0);							
		else
			$data = array("status"=>"error","message"=>"Produk tidak ada!","result"=>0);					 
        return response()->json($data);	
	}	
}