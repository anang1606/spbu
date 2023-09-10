<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\UserFcm;
use App\CashRegister;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
	//=============account API===========================	
	/* User create_account API */	
	
	public function login(Request $request)
    {
		$myinput =  $request->input()['data'];
		$mydata = explode(";", $myinput);
		$username = $mydata[0];
		$password = $mydata[1];
		$tokenfcm = $mydata[2];
		
		$user = User::where('email', $username)->first();
		if( !empty($user) )
		{
			if(auth()->attempt(array('email' => $username, 'password' => $password)))
			{
				$userfcm = UserFcm::where('user_id', $user->id)->first();
				if( !empty($userfcm) )
					$check_fcm = UserFcm::where('user_id',$user->id)->update(['tokenfcm'=>$tokenfcm]);
				else				
				{
					$new_fcm = new UserFcm;
					$new_fcm->user_id = $user->id;
					$new_fcm->tokenfcm = $tokenfcm;
					$check_fcm = $new_fcm->save();
				}
				if( $check_fcm == true )
				{
					$listuser = DB::select(DB::raw("SELECT * FROM users where email = :emails"), array("emails" =>$username,));
					if( !empty($listuser)) $dtusers = 1; else $dtusers = 0;	
					
					$listcashregisters = DB::select(DB::raw("SELECT * FROM cash_registers where user_id = :iduser"), array("iduser" =>$user->id,));
					if( !empty($listcashregisters)) $dtcashregisters = 1; else $dtcashregisters = 0;
					
					$listwarehouses = DB::select(DB::raw("SELECT * FROM warehouses WHERE id = :idwarehouse"), array("idwarehouse" =>$user->warehouse_id,));
					if( !empty($listwarehouses)) $dtwarehouses = 1; else $dtwarehouses = 0;
					
					$listproducts = DB::select("SELECT * FROM products");
					if( !empty($listproducts)) $dtproducts = 1; else $dtproducts = 0;
					
					$usercashregister = CashRegister::where('user_id', $user->id)->first();
					
					$listsales = DB::select(DB::raw("SELECT * FROM sales WHERE cash_register_id = :idcashregister"), array("idcashregister" =>$usercashregister->id,));
					if( !empty($listsales)) $dtsales = 1; else $dtsales = 0;
						
					$listproductsales = DB::select(DB::raw("SELECT product_sales.* FROM sales INNER JOIN product_sales ON product_sales.sale_id = sales.id 
					WHERE sales.cash_register_id = :idcashregister"), array("idcashregister" =>$usercashregister->id,));
					if( !empty($listproductsales)) $dtsalesproduct = 1; else $dtsalesproduct = 0;	
					
					$listcustomergroups = DB::select(DB::raw("SELECT * FROM customer_groups WHERE warehouse_id = :idwarehouse"), array("idwarehouse" =>$user->warehouse_id,));
					if( !empty($listcustomergroups)) $dtcustomergroups = 1; else $dtcustomergroups = 0;
					
					$listcustomers = DB::select("SELECT * FROM customers");
					if( !empty($listcustomers)) $dtcustomers = 1; else $dtcustomers = 0;
					
					$listoperator = DB::select("SELECT * FROM users WHERE role_id = 3");
					if( !empty($listoperator)) $dtoperator = 1; else $dtoperator = 0;
					
					$check_login = User::where('email', $username)->update(['is_login'=>1]);
					
					$data = array("status"=>"OK",						
						"message"=>"data Ada","warehous"=>$user->warehouse_id,						
						"listuser"=>$listuser,
						"dtcashregisters"=>$dtcashregisters,"listcashregisters"=>$listcashregisters,
						"dtwarehouses"=>$dtwarehouses,"listwarehouses"=>$listwarehouses,						
						"dtproducts"=>$dtproducts,"listproducts"=>$listproducts,
						"dtsales"=>$dtsales,"listsales"=>$listsales,
						"dtsalesproduct"=>$dtsalesproduct,"listproductsales"=>$listproductsales,						
						"dtcustomergroups"=>$dtcustomergroups,"listcustomergroups"=>$listcustomergroups,
						"dtcustomers"=>$dtcustomers,"listcustomers"=>$listcustomers,
						"dtoperator"=>$dtoperator,"listoperator"=>$listoperator,
						"result"=>1);	
					
				}
				else				
					$data = array("status"=>"error","message"=>"FCM Not OK!","result"=>1);
			}
			else 			
				$data = array("status"=>"error","message"=>"Email atau password salah!","result"=>1);				
		}		
		else
            $data = array("status"=>"error","message"=>"Email belum terdaftar!","result"=>0);
					 
        return response()->json($data);		
	}
	
	public function logoutmesin(Request $request)
    {
		$myinput =  $request->input()['data'];
		$mydata = explode(";", $myinput);
		$username = $mydata[0];
		$password = $mydata[1];
		
		$user = User::where('email', $username)->first();
		if( !empty($user) )
		{
			if(auth()->attempt(array('email' => $username, 'password' => $password)))
			{
				$check_logout = User::where('email', $username)->update(['is_login'=>0]);
				$data = array("status"=>"OK","message"=>"Logout sukses!","result"=>1);				
			}
			else			
				$data = array("status"=>"error","message"=>"Email atau password salah!","result"=>0);
		}
		else
            $data = array("status"=>"error","message"=>"Email belum terdaftar!","result"=>0);
		return response()->json($data);		
	}
	
	public function cekpin(Request $request)
    {
		$myinput =  $request->input()['data'];
		$mydata = explode(";", $myinput);
		$username = $mydata[0];
		$password = $mydata[1];
		$user = User::where('email', $username)->first();
		if( !empty($user) )
		{
			if(auth()->attempt(array('email' => $username, 'password' => $password)))
				$data = array("status"=>"OK","message"=>"PIN Ok!","iduser"=>$user->id,"result"=>1);
			else
				$data = array("status"=>"error","message"=>"PIN yang anda masukan salah!","result"=>0);
		}
		else
            $data = array("status"=>"error","message"=>"Terjadi kesalahan, Hubungi admin!","result"=>0);
					 
        return response()->json($data);
	}
	
	public function gantipin(Request $request)
    {
		$myinput =  $request->input()['data'];
		$mydata = explode(";", $myinput);
		$username = $mydata[0];
		$password = $mydata[1];
		$password2 = bcrypt($mydata[2]);	
		
		$user = User::where('email', $username)->first();
		if( !empty($user) )
		{
			if(auth()->attempt(array('email' => $username, 'password' => $password)))
			{
				$ganti_pin = User::where('email', $username)->update(['password'=>$password2]);
				$data = array("status"=>"OK","message"=>"Ganti PIN sukses!","result"=>1);
			}
			else
				$data = array("status"=>"error","message"=>"PIN yang anda masukan salah!","result"=>0);
		}
		else
            $data = array("status"=>"error","message"=>"Terjadi kesalahan, Hubungi admin!","result"=>0);
								 
        return response()->json($data);
	}	

	public function sendnotification(Request $request)
	{
		$myinput =  $request->input()['data'];
		$mydata = explode(";", $myinput);
		$username = $mydata[0];
		$mybody = $mydata[1];	
		
		$user = User::where('email', $username)->first();	
			
		$userfcm = UserFcm::where('iduser',$user->id)->firstOrFail();
        $tokenfcm = $userfcm->tokenfcm;
		if($tokenfcm !== false )
		{
			#API access key from Google API's Console
			define( 'API_ACCESS_KEY', 'AAAA_yACeDs:APA91bFlpzZUYoDmz3Auc3DVeSQJsPpsDdZ4pme9bgV2eZ4QJdMKxcZhP7XaAFqLKdgwKZg2GKGB4aYpw-X2UC_qbgOnk7F4KPqVUz_2Yd0Md3_NCchXdwXVBlg7aMhF_pj3Wz_Hiouo' );
			$body = array(
			"to" => $tokenfcm,
			"data" => array(	
				"title" => "Payel",
				"body" => "Apa Kabar?",
				"sound" => "default",
				"priority" => "high",
				"show_in_foreground" => true,
				"targetScreen" => 'detail'               
				),
				"priority" => 10
			);
			
			$headers = array(
				'Content-Type: application/json',
				'Authorization: key=' . API_ACCESS_KEY	
			);
			
			#Send Reponse To FireBase Server	
			$ch = curl_init();
			curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
			curl_setopt( $ch,CURLOPT_POST, true );
			curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $body ) );
			$result = curl_exec($ch);
			curl_close( $ch );
			if ($result === false) return false;
			$json = json_decode($result, true);			
			if ($json['success'] == 0)
				$data = array("status"=>"error","message"=>"Notifikasi gagal terkirim!","result"=>0);
			else
				$data = array("status"=>"OK","message"=>"Notifikasi Sukses terkirim!","result"=>1);
		}
		else
			$data = array("status"=>"error","message"=>"Token tidak  terdaftar!","result"=>0);
			
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
	
	public function qrcodemake(Request $request)
    {
		$myinput =  $request->input()['data'];			
		$datas = $this->AES_Rijndael_Encript($myinput);	
		$data = array("status"=>"error","message"=>$datas,"result"=>0);					 
        return response()->json($data);	
		
	}
	
	public function qrcoderead(Request $request)
    {
		$myinput =  $request->input()['data'];	
		$datas = $this->AES_Rijndael_Decript($myinput);			
		$data = array("status"=>"error","message"=>$datas,"result"=>0);					 
        return response()->json($data);	
		
	}
	
	private function AES_Rijndael_Encript($data) 
	{
		$key = 'rBf20BQDTcCP4T3Hl5u92LG8NlTTG2nw';
  		$iv  = 'G2nwajhz6Qfn+dg=';
		return openssl_encrypt($data, "AES-256-CBC", $key, 0, $iv);      
    }
	
	private function AES_Rijndael_Decript($data) 
	{
        $key = 'rBf20BQDTcCP4T3Hl5u92LG8NlTTG2nw';
  		$iv  = 'G2nwajhz6Qfn+dg=';        
		return openssl_decrypt($data, "AES-256-CBC", $key, 0, $iv);
    }	
}