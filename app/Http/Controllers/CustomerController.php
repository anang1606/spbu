<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomerGroup;
use App\Customer;
use App\Deposit;
use App\User;
use App\Supplier;
use App\Sale;
use App\Payment;
use App\CashRegister;
use App\Account;
use Auth;
use DB;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Mail\UserNotification;
use App\Product;
use Illuminate\Support\Facades\Mail;

class CustomerController extends Controller
{
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('customers-index')) {
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if (empty($all_permission))
                $all_permission[] = 'dummy text';
            $lims_customer_all = Customer::with('customerGroup', 'product')->where('is_active', true)->get();
            return view('customer.index', compact('lims_customer_all', 'all_permission'));
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('customers-add')) {
            $lims_product = Product::where('is_active', true)->get();
            $lims_customer_group_all = CustomerGroup::where('is_active', true)->get();
            return view('customer.create', compact('lims_customer_group_all', 'lims_product'));
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function findProduct(Request $request){
        $getCustomerGroup = CustomerGroup::where('id',$request->_val)->with('details.product')->first();
        return $getCustomerGroup;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'phone_number' => [
                'max:255',
                Rule::unique('customers')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);

        $lims_customer_data = $request->all();
        $lims_customer_data['is_active'] = true;
        $message = 'Customer';
        $lims_customer_data['name'] = $lims_customer_data['customer_name'];

        $message .= ' created successfully!';

        Customer::create($lims_customer_data);
        if ($lims_customer_data['pos'])
            return redirect('pos')->with('message', $message);
        else
            return redirect('customer')->with('create_message', $message);
    }

    public function edit($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('customers-edit')) {
            $lims_customer_data = Customer::find($id);
            $lims_product = Product::where('is_active', true)->get();
            $lims_customer_group_all = CustomerGroup::where('is_active', true)->get();
            return view('customer.edit', compact('lims_customer_data', 'lims_customer_group_all', 'lims_product'));
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function generateQrView()
    {
        $lims_customer_data = Customer::where('is_active', true)->with('product')->get();
        foreach($lims_customer_data as $data){
            unset($data->customer_group_id);
            unset($data->user_id);
            unset($data->email);
            unset($data->address);
            unset($data->city);
            unset($data->state);
            unset($data->postal_code);
            unset($data->country);
            unset($data->warehouse_id);
            unset($data->phone_number);
            unset($data->created_at);
            unset($data->updated_at);
            unset($data->product->created_at);
            unset($data->product->updated_at);
            unset($data->product->barcode_symbology);
            unset($data->product->brand_id);
            unset($data->product->type);
            unset($data->product->warehouse_id);
            unset($data->product->is_variant);
            unset($data->product->is_batch);
            unset($data->product->is_imei);
            unset($data->product->is_diffPrice);
            unset($data->product->featured);
            unset($data->product->product_list);
            unset($data->product->variant_list);
            unset($data->product->qty_list);
            unset($data->product->price_list);
            unset($data->product->alert_quantity);
            unset($data->product->variant_value);
            unset($data->product->variant_option);
            unset($data->product->product_details);
            unset($data->product->file);
            unset($data->product->image);
            unset($data->product->is_embeded);
            unset($data->product->purchase_unit_id);
            unset($data->product->sale_unit_id);
            unset($data->product->promotion_price);
            unset($data->product->promotion);
            unset($data->product->daily_sale_objective);
            unset($data->product->starting_date);
            unset($data->product->last_date);
            unset($data->product->tax_method);
            unset($data->product->tax_id);
            unset($data->product->unit_id);
            unset($data->product->category_id);
        }

        // return $lims_customer_data;
        return view('qrcode.generate', compact('lims_customer_data'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'phone_number' => [
                'max:255',
                Rule::unique('customers')->ignore($id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);

        $input = $request->all();
        $lims_customer_data = Customer::find($id);

        if (isset($input['user'])) {
            $this->validate($request, [
                'name' => [
                    'max:255',
                    Rule::unique('users')->where(function ($query) {
                        return $query->where('is_deleted', false);
                    }),
                ],
                'email' => [
                    'email',
                    'max:255',
                    Rule::unique('users')->where(function ($query) {
                        return $query->where('is_deleted', false);
                    }),
                ],
            ]);

            $input['phone'] = $input['phone_number'];
            $input['role_id'] = 5;
            $input['is_active'] = true;
            $input['is_deleted'] = false;
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $input['user_id'] = $user->id;
            $message = 'Customer updated and user created successfully';
        } else {
            $message = 'Customer updated successfully';
        }

        $input['name'] = $input['customer_name'];
        $lims_customer_data->update($input);
        return redirect('customer')->with('edit_message', $message);
    }

    public function importCustomer(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('customers-add')) {
            $upload = $request->file('file');
            $ext = pathinfo($upload->getClientOriginalName(), PATHINFO_EXTENSION);
            if ($ext != 'csv')
                return redirect()->back()->with('not_permitted', 'Please upload a CSV file');
            $filename =  $upload->getClientOriginalName();
            $filePath = $upload->getRealPath();
            //open and read
            $file = fopen($filePath, 'r');
            $header = fgetcsv($file);
            $escapedHeader = [];
            //validate
            foreach ($header as $key => $value) {
                $lheader = strtolower($value);
                $escapedItem = preg_replace('/[^a-z]/', '', $lheader);
                array_push($escapedHeader, $escapedItem);
            }
            //looping through othe columns
            while ($columns = fgetcsv($file)) {
                if ($columns[0] == "")
                    continue;
                foreach ($columns as $key => $value) {
                    $value = preg_replace('/\D/', '', $value);
                }
                $data = array_combine($escapedHeader, $columns);
                $lims_customer_group_data = CustomerGroup::where('name', $data['customergroup'])->first();
                $customer = Customer::firstOrNew(['name' => $data['name']]);
                $customer->customer_group_id = $lims_customer_group_data->id;
                $customer->name = $data['name'];
                $customer->company_name = $data['companyname'];
                $customer->email = $data['email'];
                $customer->phone_number = $data['phonenumber'];
                $customer->address = $data['address'];
                $customer->city = $data['city'];
                $customer->state = $data['state'];
                $customer->postal_code = $data['postalcode'];
                $customer->country = $data['country'];
                $customer->is_active = true;
                $customer->save();
                $message = 'Customer Imported Successfully';
                if ($data['email']) {
                    try {
                        Mail::send('mail.customer_create', $data, function ($message) use ($data) {
                            $message->to($data['email'])->subject('New Customer');
                        });
                    } catch (\Exception $e) {
                        $message = 'Customer imported successfully. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
                    }
                }
            }
            return redirect('customer')->with('import_message', $message);
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function deleteBySelection(Request $request)
    {
        $customer_id = $request['customerIdArray'];
        foreach ($customer_id as $id) {
            $lims_customer_data = Customer::find($id);
            $lims_customer_data->is_active = false;
            $lims_customer_data->save();
        }
        return 'Customer deleted successfully!';
    }

    public function destroy($id)
    {
        $lims_customer_data = Customer::find($id);
        $lims_customer_data->is_active = false;
        $lims_customer_data->save();
        return redirect('customer')->with('not_permitted', 'Data deleted Successfully');
    }
}
