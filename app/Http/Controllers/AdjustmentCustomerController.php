<?php

namespace App\Http\Controllers;

use App\AdjustmentCustomer;
use App\AdjustmentCustomerDetail;
use App\AdjustmentCustomerDetails;
use App\CustomerGroup;
use App\CustomerGroupDetail;
use App\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdjustmentCustomerController extends Controller
{
    public function index()
    {
        $adjustments = AdjustmentCustomer::with('details.product', 'details.group')->get();
        return view('adjustment_customer.index', compact('adjustments'));
    }

    public function create()
    {
        $lims_customer_group_all = CustomerGroup::where('is_active', true)->get();
        return view('adjustment_customer.create', compact('lims_customer_group_all'));
    }

    public function edit($id)
    {
        $lims_adjustment_data = AdjustmentCustomer::with('details.product', 'details.group')->where('id', $id)->first();
        $lims_customer_group_all = CustomerGroup::where('is_active', true)->get();
        return view('adjustment_customer.edit', compact('lims_customer_group_all', 'lims_adjustment_data'));
    }

    public function productSearch(Request $request)
    {
        $product_code = explode("[", $request['data']);
        $product_code[1] = rtrim($product_code[1], "]");
        $product_code[1] = base64_decode($product_code[1]);
        $lims_product_data = Product::where([
            ['id', $product_code[1]],
            ['is_active', true]
        ])->first();

        $company = CustomerGroup::find($request->_uuid);

        $product[] = $lims_product_data->name;
        $product[] = $lims_product_data->code;
        $product[] = $lims_product_data->id;
        $product[] = $company->id;
        $product[] = $company->name;

        return $product;
    }

    public function checkQty(Request $request)
    {
        $checkQty = CustomerGroupDetail::where([
            ['customer_group_id', $request->_rgpi],
            ['product_id', $request->_rpdi],
        ])->first();
        $qty = 0;
        if ($checkQty) {
            $qty = $checkQty->stock;
        }
        return (int)$qty;
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->except('document');
            $data['reference_no'] = 'cgp-' . date("Ymd") . '-' . date("his");

            $lims_adjustment_data = new AdjustmentCustomer;
            $lims_adjustment_data->reference_no = $data['reference_no'];
            $lims_adjustment_data->total_qty = $data['total_qty'];
            $lims_adjustment_data->item = $data['item'];
            $lims_adjustment_data->note = $data['note'];
            if ($lims_adjustment_data->save()) {

                $product_id = $data['product_id'];
                $product_code = $data['product_code'];
                $qty = $data['qty'];
                $action = $data['action'];
                $group_id = $data['group_id'];

                foreach ($product_id as $key => $pro_id) {
                    $customerDetails = CustomerGroupDetail::where([
                        ['product_id', $pro_id],
                        ['customer_group_id', $group_id[$key]],
                    ])->first();

                    if ($action[$key] == '-') {
                        $customerDetails->stock -= $qty[$key];
                    } elseif ($action[$key] == '+') {
                        $customerDetails->stock += $qty[$key];
                    }

                    if ($customerDetails->save()) {
                        $adjustment_details = new AdjustmentCustomerDetail;
                        $adjustment_details->adjustment_customer_id = $lims_adjustment_data->id;
                        $adjustment_details->product_id = $pro_id;
                        $adjustment_details->qty = $qty[$key];
                        $adjustment_details->action = $action[$key];
                        $adjustment_details->customer_id = $group_id[$key];

                        if ($adjustment_details->save()) {
                            DB::commit();
                        }
                    }
                }
            }
            return redirect('adjustment-customer')->with('message', 'Data inserted successfully');
        } catch (Exception $ex) {
            // return $ex->getMessage();
            return redirect('adjustment-customer')->with('not_permitted', 'Terjadi kesalahan, Silahkan coba lagi.');
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = $request->except('document');
            $lims_adjustment_data = AdjustmentCustomer::find($id);
            $lims_adjustment_data->total_qty = $data['total_qty'];
            $lims_adjustment_data->item = $data['item'];
            $lims_adjustment_data->note = $data['note'];

            $lims_product_adjustment_data = AdjustmentCustomerDetail::where('adjustment_customer_id', $id)->get();

            $product_id = $data['product_id'];
            $group_id = $data['group_id'];
            $qty = $data['qty'];
            $action = $data['action'];

            foreach ($lims_product_adjustment_data as $key => $product_adjustment_data) {
                $old_product_id[] = $product_adjustment_data->product_id;

                $customerDetails = CustomerGroupDetail::where([
                    ['product_id', $product_adjustment_data->product_id],
                    ['customer_group_id', $group_id[$key]],
                ])->first();

                if ($product_adjustment_data->action == '-') {
                    $customerDetails->stock += $product_adjustment_data->qty;
                } elseif ($product_adjustment_data->action == '+') {
                    $customerDetails->stock -= $product_adjustment_data->qty;
                }

                $customerDetails->save();

                if (!(in_array($old_product_id[$key], $product_id)) && $product_adjustment_data->customer_id == $group_id[$key]) {
                    $product_adjustment_data->delete();
                }
            }

            foreach ($product_id as $key => $pro_id) {
                $customerDetails = CustomerGroupDetail::where([
                    ['product_id', $pro_id],
                    ['customer_group_id', $group_id[$key]],
                ])->first();

                if ($action[$key] == '-') {
                    $customerDetails->stock -= $qty[$key];
                } elseif ($action[$key] == '+') {
                    $customerDetails->stock += $qty[$key];
                }

                if ($customerDetails->save()) {

                    $product_adjustment['adjustment_customer_id'] = $lims_adjustment_data->id;
                    $product_adjustment['product_id'] = $pro_id;
                    $product_adjustment['qty'] = $qty[$key];
                    $product_adjustment['action'] = $action[$key];
                    $product_adjustment['customer_id'] = $group_id[$key];

                    if (in_array($pro_id, $old_product_id) && $customerDetails->customer_group_id == $group_id[$key]) {
                        AdjustmentCustomerDetail::where([
                            ['adjustment_customer_id', $lims_adjustment_data->id],
                            ['product_id', $pro_id],
                            ['customer_id', $group_id[$key]],
                        ])->update($product_adjustment);
                    } else {
                        $adjustment_details = new AdjustmentCustomerDetail;
                        $adjustment_details->adjustment_customer_id = $lims_adjustment_data->id;
                        $adjustment_details->product_id = $pro_id;
                        $adjustment_details->qty = $qty[$key];
                        $adjustment_details->action = $action[$key];
                        $adjustment_details->customer_id = $group_id[$key];

                        $adjustment_details->save();
                    }
                    DB::commit();
                }
            }

            return redirect('adjustment-customer')->with('message', 'Data update successfully');
        } catch (Exception $ex) {
            // return $ex->getMessage();
            return redirect('adjustment-customer')->with('not_permitted', 'Terjadi kesalahan, Silahkan coba lagi.');
        }
    }
}
