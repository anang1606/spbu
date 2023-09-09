<?php

namespace App\Http\Controllers\Api;

use App\GeneralSetting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function upgrade(){
        DB::beginTransaction();
        try {
            $get_setting = GeneralSetting::latest()->first();

            $get_setting->type = 'zCFJaNdRgUkXp2s5v8xADGKbP';
            if ($get_setting->save()) {
                DB::commit();
                return response()->json([
                        'success' => true,
                        'message' => 'Upgrade Paket Berhasil',
                        'code' => 200,
                    ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ]);
        }
    }	
}