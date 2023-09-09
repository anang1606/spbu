<?php

namespace App\Http\Controllers;

use App\CustomerGroupDetail;
use Illuminate\Http\Request;
use App\CustomerGroup;
use App\Product;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;
use Exception;
use Illuminate\Support\Facades\DB;

class CustomerGroupController extends Controller
{
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('customer_group')) {
            $products = Product::where('is_active',1)->get();
            $lims_customer_group_all = CustomerGroup::where('is_active', true)->with('details.product')->get();
            return view('customer_group.index',compact('lims_customer_group_all','products'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        $products = Product::where('is_active',1)->get();
        return view('customer_group.create',compact('products'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'name' => [
                    'max:255',
                        Rule::unique('customer_groups')->where(function ($query) {
                        return $query->where('is_active', 1);
                    }),
                ],
            ]);

            $createCustomerGroup = new CustomerGroup;
            $createCustomerGroup->name = $request->name;
            $createCustomerGroup->percentage = 0;
            $createCustomerGroup->warehouse_id = 1;
            $createCustomerGroup->is_active = true;

            if($createCustomerGroup->save()){
                foreach($request->products as $product){
                    $getProducts = Product::find($product);

                    if($getProducts){
                        $createCustomerGroupDetails = new CustomerGroupDetail;
                        $createCustomerGroupDetails->customer_group_id = $createCustomerGroup->id;
                        $createCustomerGroupDetails->product_id = $getProducts->id;
                        $createCustomerGroupDetails->stock = 0;

                        if($createCustomerGroupDetails->save()){
                            DB::commit();
                        }
                    }
                }
            }

            return redirect()->back()->with('message', 'Save data berhasil!!');
        } catch (Exception $e) {
            // return $e->getMessage();
            return redirect()->back()->with('not_permitted', 'Terjadi kesalahan silahkan coba lagi.');
        }
    }

    public function edit($id)
    {
        $lims_customer_group_data = CustomerGroup::where('id',$id)->with('details')->first();
        $productId = [];
        foreach($lims_customer_group_data->details as $ls){
            $productId[] = $ls->product_id;
        }
        unset($lims_customer_group_data->details);
        $lims_customer_group_data->products = $productId;
        return $lims_customer_group_data;
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'name' => [
                    'max:255',
                        Rule::unique('customer_groups')->ignore($request->customer_group_id)->where(function ($query) {
                        return $query->where('is_active', 1);
                    }),
                ],
            ]);

            $customerGroup = CustomerGroup::where('id',$request->customer_group_id)->with('details')->first();
            $customerGroup->name = $request->name;
            if($customerGroup->save()){
                $delete_id = [];

                foreach($request->products as $id_product){
                    $getProducts = Product::find($id_product);
                    if($getProducts){
                        $delete_id[] = $getProducts->id;

                        $checkCustomerGroupDetails = CustomerGroupDetail::where([['customer_group_id',$customerGroup->id],['product_id',$getProducts->id]])->first();

                        if(!$checkCustomerGroupDetails){
                            $createCustomerGroupDetails = new CustomerGroupDetail;
                            $createCustomerGroupDetails->customer_group_id = $customerGroup->id;
                            $createCustomerGroupDetails->product_id = $getProducts->id;
                            $createCustomerGroupDetails->stock = 0;

                            $createCustomerGroupDetails->save();
                        }
                    }
                }

                CustomerGroupDetail::where('customer_group_id',$customerGroup->id)
                ->whereNotIn('product_id',$delete_id)
                ->update(['is_active' => 0]);

                DB::commit();
            }
            return redirect()->back()->with('message', 'Update data berhasil!!');
        } catch (Exception $e) {
            // return $e->getMessage();
            return redirect()->back()->with('not_permitted', 'Terjadi kesalahan silahkan coba lagi.');
        }
    }

    public function importCustomerGroup(Request $request)
    {
        //get file
        $upload=$request->file('file');
        $ext = pathinfo($upload->getClientOriginalName(), PATHINFO_EXTENSION);
        if($ext != 'csv')
            return redirect()->back()->with('not_permitted', 'Please upload a CSV file');
        $filename =  $upload->getClientOriginalName();
        $upload=$request->file('file');
        $filePath=$upload->getRealPath();
        //open and read
        $file=fopen($filePath, 'r');
        $header= fgetcsv($file);
        $escapedHeader=[];
        //validate
        foreach ($header as $key => $value) {
            $lheader=strtolower($value);
            $escapedItem=preg_replace('/[^a-z]/', '', $lheader);
            array_push($escapedHeader, $escapedItem);
        }
        //looping through othe columns
        while($columns=fgetcsv($file))
        {
            if($columns[0]=="")
                continue;
            foreach ($columns as $key => $value) {
                $value=preg_replace('/\D/','',$value);
            }
           $data= array_combine($escapedHeader, $columns);

           $customer_group = CustomerGroup::firstOrNew([ 'name'=>$data['name'], 'is_active'=>true ]);
           $customer_group->name = $data['name'];
           $customer_group->percentage = $data['percentage'];
           $customer_group->is_active = true;
           $customer_group->save();
        }
        return redirect('customer_group')->with('message', 'Customer Group imported successfully');

    }

    public function exportCustomerGroup(Request $request)
    {
        $lims_customer_group_data = $request['customer_groupArray'];
        $csvData=array('name, percentage');
        foreach ($lims_customer_group_data as $customer_group) {
            if($customer_group > 0) {
                $data = CustomerGroup::where('id', $customer_group)->first();
                $csvData[]=$data->name. ',' . $data->percentage;
            }
        }
        $filename="customer_group- " .date('d-m-Y').".csv";
        $file_path=public_path().'/downloads/'.$filename;
        $file_url=url('/').'/downloads/'.$filename;
        $file = fopen($file_path,"w+");
        foreach ($csvData as $exp_data){
          fputcsv($file,explode(',',$exp_data));
        }
        fclose($file);
        return $file_url;
    }

    public function deleteBySelection(Request $request)
    {
        $customer_group_id = $request['customer_groupIdArray'];
        foreach ($customer_group_id as $id) {
            $lims_customer_group_data = CustomerGroup::find($id);
            $lims_customer_group_data->is_active = false;
            $lims_customer_group_data->save();
        }
        return 'Customer Group deleted successfully!';
    }

    public function destroy($id)
    {
        $lims_customer_group_data = CustomerGroup::find($id);
        $lims_customer_group_data->is_active = false;
        if($lims_customer_group_data->save()){
            CustomerGroupDetail::where('customer_group_id',$lims_customer_group_data->id)
                ->update(['is_active' => 0]);
        }
        return redirect('customer_group')->with('not_permitted', 'Data deleted successfully');
    }

}
