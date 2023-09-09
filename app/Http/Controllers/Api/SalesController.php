<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sale;
use App\Product_Sale;
use App\Payment;
use App\User;
use App\UserFcm;
use App\CashRegister;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Storage;


class SalesController extends Controller
{
	//=============account API===========================	
	/* User create_account API */	
	
	//api exist user login
	
	
	
	public function createsales(Request $request)
    {
		$myinput =  $request->input()['data'];
		$mydata = explode(";", $myinput);
		$idcashregister = $mydata[0];
		$iduser = $mydata[1];
		$idcustomer = $mydata[2];
		$idwarehouse = $mydata[3];
		$idproduct = $mydata[4];
		$qty = $mydata[5];
		$unitprice = $mydata[6];
		$idunitsale = $mydata[7];
		$total = $mydata[8];		
		
		$noreference = $idcashregister . '-' . date('Ymd-His');
		$nosales = "pos" . $noreference;
		$nopayment = "pay" . $noreference;
		
		$user = User::where('id', $iduser)->first();
		if( !empty($user) )
		{			
			$new_Sales = new Sale;			
			$new_Sales->reference_no = $nosales;
			$new_Sales->user_id = $iduser;
			$new_Sales->cash_register_id = $idcashregister;
			$new_Sales->customer_id = $idcustomer;
			$new_Sales->warehouse_id = $idwarehouse;
			$new_Sales->biller_id = 4;
			$new_Sales->item = 1;
			$new_Sales->total_qty = $qty;
			$new_Sales->total_discount = 0;
			$new_Sales->total_tax = 0;
			$new_Sales->total_price = $total;
			$new_Sales->grand_total = $total;
			$new_Sales->order_tax_rate = 0;
			$new_Sales->order_tax = 0;
			$new_Sales->order_discount_type = 'Flat';
			$new_Sales->order_discount = 0;
			$new_Sales->shipping_cost = 0;
			$new_Sales->sale_status = 1;
			$new_Sales->payment_status = 4;
			$new_Sales->paid_amount = $total;
			$check_sales = $new_Sales->save();
			$salesid = $new_Sales->id;
			
			if( $check_sales == true )
			{

				$new_prodsales = new Product_Sale;	
				$new_prodsales->sale_id = $salesid;
				$new_prodsales->product_id = $idproduct;
				$new_prodsales->qty = $qty;
				$new_prodsales->sale_unit_id = 2;
				$new_prodsales->net_unit_price = $unitprice;
				$new_prodsales->discount = 0;
				$new_prodsales->tax_rate = 0;
				$new_prodsales->tax = 0;
				$new_prodsales->total = $total;
				$check_prodsales = $new_prodsales->save();
				$prodsalesid = $new_prodsales->id;
				
				if( $check_prodsales == true )
				{
					$new_payment = new Payment;
					$new_payment->payment_reference = $nopayment;
					$new_payment->user_id = $iduser;
					$new_payment->sale_id = $salesid;
					$new_payment->cash_register_id = $idcashregister;
					$new_payment->account_id = 4;
					$new_payment->amount = $total;
					$new_payment->change = 0;
					$new_payment->paying_method = 'Cash';
					$check_payment = $new_payment->save();
					
					if( $check_payment == true )
					{
						$listsales = DB::select(DB::raw("SELECT * FROM sales where id = :idsales"), array("idsales" =>$salesid,));
						if( !empty($listsales)) $dtsales = 1; else $dtsales = 0;
						
						$listproductsales = DB::select(DB::raw("SELECT * FROM product_sales where id = :idprodsales"), array("idprodsales" =>$prodsalesid,));
						if( !empty($listproductsales)) $dtsalesproduct = 1; else $dtsalesproduct = 0;
						
						$data = array("status"=>"OK",						
						"message"=>"data Ada",	
						"dtsales"=>$dtsales,"listsales"=>$listsales,
						"dtsalesproduct"=>$dtsalesproduct,"listproductsales"=>$listproductsales,
						"result"=>1);
					}
					else
						$data = array("status"=>"error","message"=>"Simpan data gagal, ulangi lagi!","result"=>0);
				}
				else
					$data = array("status"=>"error","message"=>"Simpan data gagal, ulangi lagi!","result"=>0);				
			}
			else
				$data = array("status"=>"error","message"=>"Simpan data gagal, ulangi lagi!","result"=>0);
		}		
		else
            $data = array("status"=>"error","message"=>"Email belum terdaftar!","result"=>0);
					 
        return response()->json($data);		
	}
	
	

	private function udate($format = 'u', $utimestamp = null) 
	{
		if (is_null($utimestamp))
			$utimestamp = microtime(true);

		$timestamp = floor($utimestamp);
		$milliseconds = round(($utimestamp - $timestamp) * 1000000);

		return date(preg_replace('`(?<!\\\\)u`', $milliseconds, $format), $timestamp);
   	}
	
}