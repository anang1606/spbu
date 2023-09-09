<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomController extends Controller
{
    public function product_category(Request $request)
    {
        DB::beginTransaction();
        try {
            $categories = base64_decode($request->input('_token'));
            $brands = base64_decode($request->input('_uuid'));

            if ($categories === 'all' && $brands === 'all') {
                $lims_product_list = Product::where('type','!=','ingredients')->whereNull('is_variant')->get();
                $lims_product_list_with_variant =
                Product::where('type','!=','ingredients')->whereNotNull('is_variant')->get();

                foreach ($lims_product_list as $key => $product) {
                    $images = explode(",", $product->image);
                    $product->base_image = $images[0];
                }

                foreach ($lims_product_list_with_variant as $product) {
                    $images = explode(",", $product->image);
                    $product->base_image = $images[0];
                    $lims_product_variant_data = $product->variant()->orderBy('position')->get();
                    $main_name = $product->name;
                    $temp_arr = [];
                    foreach ($lims_product_variant_data as $key => $variant) {
                        $product->name = $main_name.' ['.$variant->name.']';
                        $product->code = $variant->pivot['item_code'];
                        $lims_product_list[] = clone($product);
                    }
                }

            } else if ($categories !== 'all' && $brands === 'all') {
                $lims_product_list = Product::where([['category_id',
                $categories],['type','!=','ingredients']])->whereNull('is_variant')->get();
                $lims_product_list_with_variant = Product::where([['category_id',
                $categories],['type','!=','ingredients']])->whereNotNull('is_variant')->get();

                foreach ($lims_product_list as $key => $product) {
                    $images = explode(",", $product->image);
                    $product->base_image = $images[0];
                }

                foreach ($lims_product_list_with_variant as $product) {
                    $images = explode(",", $product->image);
                    $product->base_image = $images[0];
                    $lims_product_variant_data = $product->variant()->orderBy('position')->get();
                    $main_name = $product->name;
                    $temp_arr = [];
                    foreach ($lims_product_variant_data as $key => $variant) {
                        $product->name = $main_name.' ['.$variant->name.']';
                        $product->code = $variant->pivot['item_code'];
                        $lims_product_list[] = clone($product);
                    }
                }

            }else if ($categories === 'all' && $brands !== 'all') {
                $lims_product_list = Product::where([['brand_id',
                $brands],['type','!=','ingredients']])->whereNull('is_variant')->get();
                $lims_product_list_with_variant = Product::where('brand_id',
                $brands)->whereNotNull('is_variant')->get();

                foreach ($lims_product_list as $key => $product) {
                    $images = explode(",", $product->image);
                    $product->base_image = $images[0];
                }

                foreach ($lims_product_list_with_variant as $product) {
                    $images = explode(",", $product->image);
                    $product->base_image = $images[0];
                    $lims_product_variant_data = $product->variant()->orderBy('position')->get();
                    $main_name = $product->name;
                    $temp_arr = [];
                    foreach ($lims_product_variant_data as $key => $variant) {
                        $product->name = $main_name.' ['.$variant->name.']';
                        $product->code = $variant->pivot['item_code'];
                        $lims_product_list[] = clone($product);
                    }
                }

            }else{
                $lims_product_list = Product::where([['brand_id', $brands],['category_id',
                $categories],['type','!=','ingredients']])->whereNull('is_variant')->get();
                $lims_product_list_with_variant = Product::where([['brand_id', $brands],['category_id',
                $categories],['type','!=','ingredients']])->whereNotNull('is_variant')->get();

                foreach ($lims_product_list as $key => $product) {
                    $images = explode(",", $product->image);
                    $product->base_image = $images[0];
                }

                foreach ($lims_product_list_with_variant as $product) {
                    $images = explode(",", $product->image);
                    $product->base_image = $images[0];
                    $lims_product_variant_data = $product->variant()->orderBy('position')->get();
                    $main_name = $product->name;
                    $temp_arr = [];
                    foreach ($lims_product_variant_data as $key => $variant) {
                        $product->name = $main_name.' ['.$variant->name.']';
                        $product->code = $variant->pivot['item_code'];
                        $lims_product_list[] = clone($product);
                    }
                }

            }

            return $lims_product_list;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}