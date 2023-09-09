@extends('layout.top-head')
@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">
<style>
    * {
        font-family: 'Poppins', sans-serif;
    }

    body {
        background-color: #eff3f7;
        display: flex;
        flex-direction: column;
        font-family: Poppins, Helvetica, sans-serif;
        font-size: .875rem;
        font-weight: 400;
        line-height: 1.313rem;
        padding: 0 !important;
    }

    .pos-screen {
        background-color: rgba(0, 158, 247, .05) !important;
    }

    .left-content .main-table {
        height: auto;
        max-height: 470px;
        min-height: calc(100vh - 368px);
    }

    .svg-inline--fa {
        display: var(--fa-display, inline-block);
        height: 1em;
        overflow: visible;
        vertical-align: -0.125em;
    }

    .bg-btn-pink,
    .bg-btn-pink:hover {
        background-color: #ff679b;
        border-color: #ff679b;
    }

    .bootstrap-select.btn-group>.dropdown-toggle {
        height: 43px !important;
    }

    .form-group .bootstrap-select.btn-group {
        border-radius: 0.938rem !important;
    }

    .start-0 {
        left: 0 !important;
    }

    .end-0 {
        right: 0 !important;
    }

    .bottom-0 {
        bottom: 0 !important;
    }

    .top-0 {
        top: 0 !important;
    }

    .input-group>.custom-file:focus,
    .input-group>.custom-select:focus,
    .input-group>.form-control:focus {
        z-index: 0;
    }

    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    .right-content .product-list-block {
        height: auto;
        max-height: 500px;
        min-height: calc(100vh - 218px);
        overflow-y: auto;
        padding-left: 8px;
        padding-right: 8px;
    }

    .right-content .button-list .custom-btn-size {
        white-space: nowrap;
        padding: .563rem 1.563rem;
        font-size: .875rem;
        font-weight: 400;
    }

    .btn-light {
        background-color: #eff3f6;
        border-color: #eff3f6;
        color: #060917;
    }

    .btn-light:hover {
        background-color: #6571ff !important;
        border-color: #6571ff !important;
        color: #fff !important;
    }

    .right-content .button-list__item-active {
        background-color: #6571ff !important;
        border-color: #6571ff !important;
        color: #fff !important;
        transition: .4s ease-in-out;
    }

    .scollable {
        overflow: auto;
        padding-bottom: 6px;
    }

    .scollable:hover::-webkit-scrollbar-thumb {
        background: #d8d7d7;
    }

    /* width */
    .scollable::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    /* Track */
    .scollable::-webkit-scrollbar-track {
        background: transparent;
    }

    /* Handle */
    .scollable::-webkit-scrollbar-thumb {
        background: transparent;
    }

    /* Handle on hover */
    .scollable::-webkit-scrollbar-thumb:hover {
        background: #d8d7d7;
    }

    .right-content .product-list-block .product-custom-card {
        border-radius: 6px;
        box-shadow: 0 4px 20px 1px rgb(0 0 0 / 6%), 0 1px 4px rgb(0 0 0 / 8%);
        cursor: pointer;
        margin-bottom: 16px;
        margin-left: 8px;
        margin-right: 8px;
        outline: 1px solid #e0e3ff;
        width: calc(16.66% - 16px);
        transition: .4s ease-in-out;
    }

    .right-content .product-list-block .product-custom-card.active {
        outline: 1px solid #6571ff !important;
    }

    .right-content .product-list-block .product-custom-card:hover {
        outline: 1px solid #6571ff !important;
    }

    .right-content .product-list-block .product-custom-card .card .card-img-top {
        height: 82px !important;
        max-height: 82px !important;
        -o-object-fit: contain;
        object-fit: contain;
        width: 100% !important;
    }

    .right-content .product-list-block .custom-card-body {
        color: #3f4254;
    }

    .right-content .product-list-block .product-custom-card .card .product-title {
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        display: -webkit-box;
        overflow: hidden;
        word-break: break-all;
    }

    body {
        overflow: hidden;
    }

    .items-summary-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0px 15px;
    }

    .items-summary-wrap h4 {
        font-size: 15px;
        font-weight: 600;
        margin-top: 0px;
    }

    #myTable .input-group {
        max-width: 100%;
        justify-content: center;
    }

    .bottom-navigation {
        display: none;
    }

    @media (max-width: 1499px) {
        .right-content .product-list-block .product-custom-card {
            margin-left: 6px;
            margin-right: 6px;
            width: calc(20% - 12px);
        }
    }

    @media (max-width: 1199px) {
        .right-content .product-list-block .product-custom-card {
            width: calc(25% - 12px);
        }
    }

    .btn-fab {
        display: none;
    }

    @media (max-width: 991px) {
        .content-menu {
            position: absolute;
            top: 0;
            left: -100%;
            background: #fff;
            z-index: 999;
            transition: .4s ease-in-out;
        }

        .btn.btn-fab {
            display: block;
            position: absolute;
            right: 8px;
            bottom: 16px;
            background: #ff679b;
            color: #fff;
            border-radius: 50%;
            width: 47px;
            height: 47px;
            box-shadow: 0 4px 20px 1px rgb(0 0 0 / 6%), 0 1px 4px rgb(0 0 0 / 8%);
            cursor: pointer;
        }

        .content-menu.show {
            left: 0;
            height: 100%;
        }

        .hidden-menu-button,
        .button-menu {
            display: none !important;
        }

        .pos-page {
            position: relative;
            padding: 0 !important;
        }

        .left-content .main-table {
            min-height: calc(100vh - 406px);
        }

        .bottom-navigation {
            display: flex;
        }
    }

    @media (max-width: 480px) {
        .right-content .product-list-block .product-custom-card {
            width: calc(33.33% - 12px);
        }
    }

    @media (max-width: 575px) {
        .right-content .product-list-block .product-custom-card {
            width: calc(25% - 12px);
        }
    }

    @media (max-width: 767px) {
        .right-content .product-list-block .product-custom-card {
            width: calc(32.66% - -54px) !important;
        }

        .left-content .main-table {
            min-height: calc(100vh - 526px);
        }

        .pos-page .container-fluid {
            padding: 0;
        }

        .right-content .button-list .custom-btn-size {
            font-size: .675rem;
        }
    }

    @media (max-width: 422px) {
        .right-content .product-list-block .product-custom-card {
            width: calc(33.33% - -51px) !important;
        }
    }

    @media (max-width: 375px) {
        .right-content .product-list-block .product-custom-card {
            width: calc(33.33% - -43px) !important;
        }
    }

    @media (max-width: 371px) {
        .right-content .product-list-block .product-custom-card {
            width: calc(33.33% - -42px) !important;
        }
    }

    @media (max-width: 365px) {
        .right-content .product-list-block .product-custom-card {
            width: calc(33.33% - -40px) !important;
        }
    }

    @media (max-width: 354px) {
        .right-content .product-list-block .product-custom-card {
            width: calc(33.33% - -39px) !important;
        }
    }

    @media (max-width: 347px) {
        .right-content .product-list-block .product-custom-card {
            width: calc(33.33% - -38px) !important;
        }
    }

    @media (max-width: 341px) {
        .right-content .product-list-block .product-custom-card {
            width: calc(33.33% - -37px) !important;
        }
    }

    @media (max-width: 335px) {
        .right-content .product-list-block .product-custom-card {
            width: 100% !important;
        }
    }

    .bottom-navigation {
        width: 100%;
        margin-top: 10px;
        padding: 10px;
        justify-content: space-between;
        background: rgb(255, 255, 255);
        border-radius: 0.938rem;
        box-shadow: 0 4px 20px 1px rgb(0 0 0 / 6%), 0 1px 4px rgb(0 0 0 / 8%);
        position: relative;
    }

    .bottom-navigation .btn-bottom {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        padding: 5px;
        color: #949494;
        font-weight: 600;
        font-size: 12px;
        text-decoration: none;
        transition: all .3s;
    }

    .bottom-navigation .btn-bottom.main {
        background-color: #34cea7;
        color: #fff;
        border-radius: 100%;
        width: 68px;
        height: 68px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        top: -25px;
        border: 6px solid #fff;
    }

    .bottom-navigation .btn-bottom.main span {
        font-size: 10px;
    }

    @media (max-width: 991px) {
        .right-content .product-list-block .product-custom-card {
            width: calc(32.66% - 12px);
        }
    }

</style>
<div class="d-flex flex-column flex-root">
    <div class="pos-screen px-3 container-fluid">
        <div class="row">
            <div class="pos-left-scs col-xxl-4 col-lg-5 col-sm-12">
                {!! Form::open(['route' => 'sales.store', 'method' => 'post', 'files' => true, 'class' =>
                'payment-form']) !!}
                @php
                if ($lims_pos_setting_data) {
                $keybord_active = $lims_pos_setting_data->keybord_active;
                } else {
                $keybord_active = 0;
                }

                $customer_active = DB::table('permissions')
                ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                ->where([['permissions.name', 'customers-add'], ['role_id', \Auth::user()->role_id]])
                ->first();
                @endphp
                <div class="top-nav my-2">
                    <div class="align-items-center justify-content-between grp-select h-100 row">
                        <div class="col-6 mt-2">
                            <div class="form-group" style="margin:0px">
                                <input type="text" name="created_at" id="time_now" readOnly disabled style="height:45px;border-radius: 0.938rem !important;background:#fff;color:#7c5cc4" class="form-control date" placeholder="Choose date"/>
                            </div>
                        </div>
                        <div class="col-6 mt-2">
                            <div class="form-group" style="margin:0px">
                                @if ($lims_pos_setting_data)
                                <input type="hidden" name="customer_id_hidden" value="{{ $lims_pos_setting_data->customer_id }}">
                                @endif
                                <div class="input-group pos">
                                    @if ($customer_active)
                                    <select required name="customer_id" id="customer_id" class="selectpicker form-control" data-live-search="true" title="Select customer..." style="width: 100px">
                                        <?php
                                                        $deposit = [];
                                                        $points = [];
                                                        ?>
                                        @foreach ($lims_customer_list as $customer)
                                        @php
                                        $deposit[$customer->id] = $customer->deposit - $customer->expense;

                                        $points[$customer->id] = $customer->points;
                                        @endphp
                                        <option value="{{ $customer->id }}">
                                            {{ $customer->name . ' (' . $customer->phone_number . ')' }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-default btn-sm" style="background-color: #6571ff!important;border-color: #fff!important;color: #fff!important;" data-toggle="modal" data-target="#addCustomer"><i class="dripicons-plus"></i></button>
                                    @else
                                    <?php
                                                    $deposit = [];
                                                    $points = [];
                                                    ?>
                                    <select required name="customer_id" id="customer_id" class="selectpicker form-control" data-live-search="true" title="Select customer...">
                                        @foreach ($lims_customer_list as $customer)
                                        @php
                                        $deposit[$customer->id] = $customer->deposit - $customer->expense;

                                        $points[$customer->id] = $customer->points;
                                        @endphp
                                        <option value="{{ $customer->id }}">
                                            {{ $customer->name . ' (' . $customer->phone_number . ')' }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @endif
                                </div>
                                @if ($lims_pos_setting_data)
                                <input type="hidden" name="warehouse_id_hidden" value="{{ $lims_pos_setting_data->warehouse_id }}">
                                @endif
                                <input type="hidden" name="warehouse_id" id="warehouse_id" value="{{ $lims_pos_setting_data->warehouse_id }}">

                                @if ($lims_pos_setting_data)
                                <input type="hidden" name="biller_id_hidden" value="{{ Auth::user()->id }}">
                                @endif
                                <input type="hidden" name="biller_id" id="biller_id" value="{{ Auth::user()->id }}">
                            </div>
                        </div>
                        {{--  <div class="col-6 mt-2">
                            <div class="form-group" style="margin:0px">
                                @if ($lims_pos_setting_data)
                                <input type="hidden" name="warehouse_id_hidden" value="{{ $lims_pos_setting_data->warehouse_id }}" style="font-size:1.3rem">
                                @endif
                                <select required id="warehouse_id" name="warehouse_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select warehouse...">
                                    @foreach ($lims_warehouse_list as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>  --}}
                        {{--  <div class="col-6 mt-2">
                            <div class="form-group" style="margin:0px">
                                @if ($lims_pos_setting_data)
                                <input type="hidden" name="biller_id_hidden" value="{{ $lims_pos_setting_data->biller_id }}">
                                @endif
                                <select required id="biller_id" name="biller_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Biller...">
                                    @foreach ($lims_biller_list as $biller)
                                    <option value="{{ $biller->id }}">
                                        {{ $biller->name . ' (' . $biller->company_name . ')' }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>  --}}
                    </div>
                </div>
                <div class="left-content card custom-card p-3" style="border-radius: 0.938rem;margin-bottom:0">
                    <div class="main-table overflow-auto scollable">
                        <table class="mb-0 table table-hover order-list" id="myTable">
                            <thead class="position-sticky top-0" style="z-index:999">
                                <tr>
                                    <th style="font-size: 14px;font-weight:500;color: #212529;background-color: #fff;border-bottom: 1px solid #e6dfdf;box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);">
                                        Produk</th>
                                    <th style="font-size: 14px;font-weight:500;color: #212529;background-color: #fff;border-bottom: 1px solid #e6dfdf;box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);" class="text-center">Harga</th>
                                    <th style="font-size: 14px;font-weight:500;color: #212529;background-color: #fff;border-bottom: 1px solid #e6dfdf;box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);" class="text-center">
                                        Jumlah</th>
                                    <th style="font-size: 14px;font-weight:500;color: #212529;background-color: #fff;border-bottom: 1px solid #e6dfdf;box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);" colspan="2">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-id"></tbody>
                        </table>
                    </div>
                    <div class="calculation mt-3">
                        <div class="total-price row">
                            <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="items-summary-wrap">
                                    <p>Total Items</p>
                                    <h4 class="cartItems" id="item">0</h4>
                                </div>
                                <div class="items-summary-wrap">
                                    <p>Total </p>
                                    <h4 class="cartItems" id="subtotal">0</h4>
                                </div>
                                <div class="items-summary-wrap">
                                    <p>
                                        Pajak
                                        <button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#order-tax"><i class="dripicons-document-edit"></i></button>
                                    </p>
                                    <h4 class="cartItems" id="tax">0</h4>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="items-summary-wrap">
                                    <p>
                                        Diskon
                                        <button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#order-discount-modal"> <i class="dripicons-document-edit"></i></button>
                                    </p>
                                    <h4 class="cartItems" id="discount">0</h4>
                                </div>
                                <div class="items-summary-wrap">
                                    <p>
                                        Pengiriman
                                        <button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#shipping-cost-modal"><i class="dripicons-document-edit"></i></button>
                                    </p>
                                    <h4 class="cartItems" id="shipping-cost">0</h4>
                                </div>
                                <div class="items-summary-wrap">
                                    <p>
                                        Kupon
                                        <button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#coupon-modal"><i class="dripicons-document-edit"></i></button>
                                    </p>
                                    <h4 class="cartItems" id="coupon-text">0</h4>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2 mt-2">
                                <div class="items-summary-wrap">
                                    <p style="font-size: 18px;margin: 0;">Total Keseluruhan</p>
                                    <h4 style="font-size: 32px;" class="cartItems" id="grand-total">0</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between hidden-menu-button" style="gap:10px">
                        <button type="button" id="draft-btn" style="display: flex;align-items: center;justify-content: center;gap: 6px;" class="text-white bg-btn-pink btn-rounded w-100 py-2 rounded-10 px-3 btn btn-info">
                            Pending (F8)
                        </button>
                        <button type="button" style="display: flex;align-items: center;justify-content: center;gap: 6px;" class="text-white btn-rounded w-100 py-2 rounded-10 px-3 btn btn-danger" onclick="return confirmCancel()" id="cancel-btn">
                            Reset (F9)
                        </button>
                        <button type="button" data-toggle="modal" id="cash-btn" data-target="#add-payment" style="display: flex;align-items: center;justify-content: center;gap: 6px;" class="text-white btn-rounded w-100 py-2 rounded-10 px-3 btn btn-success payment-btn">
                            Bayar
                            (insert)
                        </button>
                    </div>
                    <div class="row" style="display: none;">
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="hidden" name="total_qty" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="hidden" name="total_discount" value="0.00" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="hidden" name="total_tax" value="0.00" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="hidden" name="total_price" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="hidden" name="item" />
                                <input type="hidden" name="order_tax" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="hidden" name="grand_total" />
                                <input type="hidden" name="used_points" />
                                <input type="hidden" name="coupon_discount" />
                                <input type="hidden" name="sale_status" value="1" />
                                <input type="hidden" name="coupon_active">
                                <input type="hidden" name="coupon_id">
                                <input type="hidden" name="coupon_discount" />

                                <input type="hidden" name="pos" value="1" />
                                <input type="hidden" name="draft" value="0" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bottom-navigation">
                    <a href="/" class="btn-bottom">
                        <i class="fa fa-tachometer"></i>
                        <span>Dashboard</span>
                    </a>
                    <div class="btn-bottom" style="margin-right: 62px" id="draft-btn">
                        <i class="fa fa-hand-paper-o"></i>
                        <span>Pending</span>
                    </div>
                    <div class="btn-bottom main payment-btn" data-toggle="modal" id="cash-btn" data-target="#add-payment">
                        <i class="ms-2 fa fa-money"></i>
                        <span>Bayar</span>
                    </div>
                    <div class="btn-bottom" onclick="return confirmCancel()" id="cancel-btn">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" class="fs-4" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"></path>
                            <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z">
                            </path>
                        </svg>
                        <span>Reset</span>
                    </div>
                    <div class="btn-bottom" id="open-product">
                        <i class="fa fa-list-ul"></i>
                        <span>Product</span>
                    </div>
                </div>
                <!-- payment modal -->
                <div id="add-payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Finalize Sale') }}</h5>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="row">
                                            <div class="col-md-6 mt-1">
                                                <label>Pembayaran *</label>
                                                <input type="text" name="paying_amount" class="form-control numkey" style="font-size: 25px;" required step="any">
                                            </div>
                                            <div class="col-md-6 mt-1">
                                                <label>Total *</label>
                                                <input readonly type="text" name="paid_amount" class="form-control numkey" style="font-size: 25px;" step="any">
                                            </div>
                                            <div class="col-md-12 mt-1">
                                                <label id="label-change">Kurang : </label>
                                                <p id="change" class="ml-2" style="font-size: 32px; color: rgb(0, 0, 0); font-weight: 600;">-25.000</p>
                                            </div>
                                            <div class="col-md-12 mt-1">
                                                <input type="hidden" name="paid_by_id">
                                                <label>{{ trans('file.Paid By') }}</label>
                                                <select name="paid_by_id_select" class="form-control selectpicker">
                                                    <option value="1">Cash</option>
                                                    <option value="2">Gift Card</option>
                                                    <option value="3">Credit Card</option>
                                                    <option value="4">Cheque</option>
                                                    <option value="5">Paypal</option>
                                                    <option value="6">Deposit</option>
                                                    @if ($lims_reward_point_setting_data->is_active)
                                                    <option value="7">Points</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group col-md-12 mt-3">
                                                <div class="card-element form-control">
                                                </div>
                                                <div class="card-errors" role="alert"></div>
                                            </div>
                                            <div class="form-group col-md-12 gift-card">
                                                <label> {{ trans('file.Gift Card') }} *</label>
                                                <input type="hidden" name="gift_card_id">
                                                <select id="gift_card_id_select" name="gift_card_id_select" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Gift Card..."></select>
                                            </div>
                                            <div class="form-group col-md-12 cheque">
                                                <label>{{ trans('file.Cheque Number') }} *</label>
                                                <input type="text" name="cheque_no" class="form-control">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>{{ trans('file.Payment Note') }}</label>
                                                <textarea id="payment_note" rows="2" class="form-control" name="payment_note"></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label>{{ trans('file.Sale Note') }}</label>
                                                <textarea rows="3" class="form-control" name="sale_note"></textarea>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>{{ trans('file.Staff Note') }}</label>
                                                <textarea rows="3" class="form-control" name="staff_note"></textarea>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button id="submit-btn" type="button" class="btn btn-primary mr-3">Simpan (Enter)</button>
                                            <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-danger">Kembali (Esc)</button>
                                        </div>
                                    </div>
                                    <div class="col-md-2 qc" data-initial="1">
                                        <h4><strong>{{ trans('file.Quick Cash') }}</strong></h4>
                                        <button class="btn btn-block btn-primary qc-btn sound-btn" data-amount="1000" type="button">1K</button>
                                        <button class="btn btn-block btn-primary qc-btn sound-btn" data-amount="2000" type="button">2K</button>
                                        <button class="btn btn-block btn-primary qc-btn sound-btn" data-amount="5000" type="button">5K</button>
                                        <button class="btn btn-block btn-primary qc-btn sound-btn" data-amount="10000" type="button">10K</button>
                                        <button class="btn btn-block btn-primary qc-btn sound-btn" data-amount="50000" type="button">50K</button>
                                        <button class="btn btn-block btn-primary qc-btn sound-btn" data-amount="100000" type="button">100K</button>
                                        <button class="btn btn-block btn-danger qc-btn sound-btn" data-amount="0" type="button">Hapus</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- order_discount modal -->
                <div id="order-discount-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ trans('file.Order Discount') }}</h5>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>{{ trans('file.Order Discount Type') }}</label>
                                        <select id="order-discount-type" name="order_discount_type_select" class="form-control">
                                            <option value="Flat">{{ trans('file.Flat') }}</option>
                                            <option value="Percentage">{{ trans('file.Percentage') }}</option>
                                        </select>
                                        <input type="hidden" name="order_discount_type">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>{{ trans('file.Value') }}</label>
                                        <input type="text" name="order_discount_value" class="form-control numkey" id="order-discount-val" onkeyup='saveValue(this);'>
                                        <input type="hidden" name="order_discount" class="form-control" id="order-discount" onkeyup='saveValue(this);'>
                                    </div>
                                </div>
                                <button type="button" name="order_discount_btn" class="btn btn-primary" data-dismiss="modal">{{ trans('file.submit') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- coupon modal -->
                <div id="coupon-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ trans('file.Coupon Code') }}</h5>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="text" id="coupon-code" class="form-control" placeholder="Type Coupon Code...">
                                </div>
                                <button type="button" class="btn btn-primary coupon-check" data-dismiss="modal">{{ trans('file.submit') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- order_tax modal -->
                <div id="order-tax" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ trans('file.Order Tax') }}</h5>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="hidden" name="order_tax_rate">
                                    <select class="form-control" name="order_tax_rate_select" id="order-tax-rate-select">
                                        <option value="0">No Tax</option>
                                        @foreach ($lims_tax_list as $tax)
                                        <option value="{{ $tax->rate }}">{{ $tax->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="button" name="order_tax_btn" class="btn btn-primary" data-dismiss="modal">{{ trans('file.submit') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- shipping_cost modal -->
                <div id="shipping-cost-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ trans('file.Shipping Cost') }}</h5>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="text" name="shipping_cost" class="form-control numkey format-rupiah" id="shipping-cost-val" step="any" onkeyup='saveValue(this);'>
                                </div>
                                <button type="button" name="shipping_cost_btn" class="btn btn-primary" data-dismiss="modal">{{ trans('file.submit') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="ps-lg-0 pos-right-scs col-xxl-8 col-lg-7 col-sm-12 content-menu" id="content-menu">
                <div class="right-content">
                    <div class="d-sm-flex align-items-center flex-xxl-nowrap" style="gap:5px">
                        <div class="search-box form-group my-2 w-100">
                            <input style="height:45px;border-radius: 0.938rem !important;" type="text" name="product_code_name" id="lims_productcodeSearch" placeholder="Scan/Search product by name/code" class="form-control" />
                        </div>
                        <div class="align-items-center header-btn-grp justify-xxl-content-end justify-lg-content-center justify-content-start flex-nowrap nav button-menu" style="gap:5px">
                            <button class="btn btn-info bg-btn-pink" data-toggle="modal" data-target="#recentTransaction">
                                <i class="fa fa-list-ul"></i>
                            </button>
                            <button class="btn btn-info" data-toggle="modal" id="register-details-btn" data-target="#register-details-modal">
                                <i class="dripicons-briefcase"></i>
                            </button>
                            <button class="btn custom-btn-size btn-light button-list__item-active" id="today-sale-btn" data-toggle="modal" data-target="#today-sale-modal">
                                <i class="dripicons-shopping-bag"></i>
                            </button>
                            <button class="btn custom-btn-size btn-light button-list__item-active" id="btnFullscreen">
                                <i class="dripicons-expand"></i>
                            </button>
                            <a href="/" class="btn custom-btn-size btn-light button-list__item-active">
                                <i class="dripicons-meter"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card h-100 position-relative" style="border-radius: 0.938rem;margin-bottom:0">
                        <div class="p-3">
                            <div class="button-list mb-2 d-flex flex-nowrap nav w-100">
                                <div class="d-flex w-100" style="align-items:flex-start;gap:6px">
                                    <button class="btn custom-btn-size btn-light btn-category button-list__item-active" data-category="all" style="border-radius: 0.625rem !important;">
                                        All Categories
                                    </button>
                                    <div style="width: 100%;gap:10px;" class="pl-2 pr-2 d-flex flex-row scollable">
                                        @foreach ($lims_category_list as $category)
                                        <button class="custom-btn-size btn btn-light btn-category" data-category="{{ $category->id }}" style="border-radius: 0.625rem !important;">
                                            {{ $category->name }}
                                        </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="button-list mb-2 d-flex flex-nowrap nav w-100">
                                <div class="d-flex w-100" style="align-items:flex-start;gap:6px">
                                    <button class="btn custom-btn-size btn-light btn-brand button-list__item-active" data-brand="all" style="border-radius: 0.625rem !important;">
                                        All Brands
                                    </button>
                                    <div style="width: 100%;gap:10px;" class="pl-2 pr-2 d-flex flex-row scollable">
                                        @foreach ($lims_brand_list as $brand)
                                        <button class="custom-btn-size btn btn-light btn-brand" data-brand="{{ $brand->id }}" style="border-radius: 0.625rem !important;">
                                            {{ $brand->title }}
                                        </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="product-container">
                        </div>
                        <button class="btn btn-fab" id="close-menu-product">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<audio id="mysoundclip1" preload="auto">
    <source src="{{ url('beep/beep-timber.mp3') }}">
    </source>
</audio>
<audio id="mysoundclip2" preload="auto">
    <source src="{{ url('beep/beep-07.mp3') }}">
    </source>
</audio>
<template id="product-product">
    <div class="product-custom-card product-img sound-btn" data-template="conten">
        <div class="position-relative h-100 card" style="margin-bottom: 0;padding: 6px 0px;">
            <img src="" data-url="{{ base64_encode(url('images/product/')) }}" data-template="image" class="card-img-top" />
            <div class="px-2 pt-2 pb-1 custom-card-body card-body">
                <h6 class="product-title mb-0 text-gray-900" data-template="name">MacBook Pro M1</h6>
                <span class="fs-small text-gray-700" data-template="code">2011-8574</span>
            </div>
        </div>
    </div>
</template>
<template id="filter-not-found">
    <div class="d-flex align-items-center justify-content-center product-list-block pt-1">
        <div class="d-flex flex-wrap product-list-block__product-block">
            <h4 class="m-auto" style="font-weight:500">No Product Available</h4>
        </div>
    </div>
</template>
<!-- product edit modal -->
<div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modal_header" class="modal-title"></h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row modal-element">
                        <div class="col-md-4 form-group">
                            <label>{{ trans('file.Quantity') }}</label>
                            <input type="text" name="edit_qty" class="form-control numkey format-rupiah">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>{{ trans('file.Unit Discount') }}</label>
                            <input type="text" name="edit_discount" class="form-control numkey format-rupiah">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>{{ trans('file.Unit Price') }}</label>
                            <input type="text" name="edit_unit_price" class="form-control numkey format-rupiah" step="any">
                        </div>
                        <?php
                                        $tax_name_all[] = 'No Tax';
                                        $tax_rate_all[] = 0;
                                        foreach ($lims_tax_list as $tax) {
                                            $tax_name_all[] = $tax->name;
                                            $tax_rate_all[] = $tax->rate;
                                        }
                                        ?>
                        <div class="col-md-4 form-group">
                            <label>{{ trans('file.Tax Rate') }}</label>
                            <select name="edit_tax_rate" class="form-control selectpicker">
                                @foreach ($tax_name_all as $key => $name)
                                <option value="{{ $key }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="edit_unit" class="col-md-4 form-group">
                            <label>{{ trans('file.Product Unit') }}</label>
                            <select name="edit_unit" class="form-control selectpicker">
                            </select>
                        </div>
                    </div>
                    <button type="button" name="update_btn" class="btn btn-primary">{{ trans('file.update') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- recent transaction modal -->
<div id="recentTransaction" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Recent Transaction') }}
                    <div class="badge badge-primary">{{ trans('file.latest') }} 10</div>
                </h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#sale-latest" role="tab" data-toggle="tab">{{ trans('file.Sale') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#draft-latest" role="tab" data-toggle="tab">{{ trans('file.Draft') }}</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane show active" id="sale-latest">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>{{ trans('file.date') }}</th>
                                        <th>{{ trans('file.reference') }}</th>
                                        <th>{{ trans('file.customer') }}</th>
                                        <th>{{ trans('file.grand total') }}</th>
                                        <th>{{ trans('file.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recent_sale as $sale)
                                    <?php $customer = DB::table('customers')->find($sale->customer_id); ?>
                                    <tr>
                                        <td>{{ date('d-m-Y', strtotime($sale->created_at)) }}</td>
                                        <td>{{ $sale->reference_no }}</td>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ number_format($sale->grand_total, 0, '.', '.') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                @if (in_array('sales-edit', $all_permission))
                                                <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-success btn-sm" title="Edit"><i class="dripicons-document-edit"></i></a>&nbsp;
                                                @endif
                                                @if (in_array('sales-delete', $all_permission))
                                                {{ Form::open(['route' => ['sales.destroy', $sale->id], 'method' => 'DELETE']) }}
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirmDelete()" title="Delete"><i class="dripicons-trash"></i></button>
                                                {{ Form::close() }}
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="draft-latest">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>{{ trans('file.date') }}</th>
                                        <th>{{ trans('file.reference') }}</th>
                                        <th>{{ trans('file.customer') }}</th>
                                        <th>{{ trans('file.grand total') }}</th>
                                        <th>{{ trans('file.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recent_draft as $draft)
                                    <?php $customer = DB::table('customers')->find($draft->customer_id); ?>
                                    <tr>
                                        <td>{{ date('d-m-Y', strtotime($draft->created_at)) }}</td>
                                        <td>{{ $draft->reference_no }}</td>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ number_format($draft->grand_total, 0, '.', '.') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                @if (in_array('sales-edit', $all_permission))
                                                <a href="{{ url('sales/' . $draft->id . '/create') }}" class="btn btn-success btn-sm" title="Edit"><i class="dripicons-document-edit"></i></a>&nbsp;
                                                @endif
                                                @if (in_array('sales-delete', $all_permission))
                                                {{ Form::open(['route' => ['sales.destroy', $draft->id], 'method' => 'DELETE']) }}
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirmDelete()" title="Delete"><i class="dripicons-trash"></i></button>
                                                {{ Form::close() }}
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- add cash register modal -->
<div id="cash-register-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['route' => 'cashRegister.store', 'method' => 'post']) !!}
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Add Cash Register') }}
                </h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
            </div>
            <div class="modal-body">
                <p class="italic">
                    <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                </p>
                <div class="row">
                    {{--  <div class="col-md-6 form-group warehouse-section">
                        <label>{{ trans('file.Warehouse') }} *</strong> </label>
                        <select required name="warehouse_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select warehouse...">
                            @foreach ($lims_warehouse_list as $warehouse)
                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                    </div>  --}}
                    <div class="col-md-12 form-group">
                        <label>{{ trans('file.Cash in Hand') }} *</strong> </label>
                        <input type="hidden" name="warehouse_id" value="{{ $lims_pos_setting_data->warehouse_id }}">
                        <input style="height:45px;border-radius: 0.938rem !important;background:#fff;color:#7c5cc4" type="text" name="cash_in_hand" required class="form-control format-rupiah">
                    </div>
                    <div class="col-md-12 form-group">
                        <button type="submit" class="btn btn-primary">{{ trans('file.submit') }}</button>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
<!-- cash register details modal -->
<div id="register-details-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title">
                    {{ trans('file.Cash Register Details') }}
                </h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
            </div>
            <div class="modal-body">
                <p>{{ trans('file.Please review the transaction and payments.') }}</p>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <td>{{ trans('file.Cash in Hand') }}:</td>
                                    <td id="cash_in_hand" class="text-right">0</td>
                                </tr>
                                <tr>
                                    <td>{{ trans('file.Total Sale Amount') }}:</td>
                                    <td id="total_sale_amount" class="text-right"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('file.Total Payment') }}:</td>
                                    <td id="total_payment" class="text-right"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('file.Cash Payment') }}:</td>
                                    <td id="cash_payment" class="text-right"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('file.Credit Card Payment') }}:</td>
                                    <td id="credit_card_payment" class="text-right"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('file.Cheque Payment') }}:</td>
                                    <td id="cheque_payment" class="text-right"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('file.Gift Card Payment') }}:</td>
                                    <td id="gift_card_payment" class="text-right"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('file.Deposit Payment') }}:</td>
                                    <td id="deposit_payment" class="text-right"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('file.Paypal Payment') }}:</td>
                                    <td id="paypal_payment" class="text-right"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('file.Total Sale Return') }}:</td>
                                    <td id="total_sale_return" class="text-right"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('file.Total Expense') }}:</td>
                                    <td id="total_expense" class="text-right"></td>
                                </tr>
                                <tr>
                                    <td><strong>{{ trans('file.Total Cash') }}:</strong></td>
                                    <td id="total_cash" class="text-right"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6" id="closing-section">
                        <form action="{{ route('cashRegister.close') }}" method="POST">
                            @csrf
                            <input type="hidden" name="cash_register_id">
                            <button type="submit" class="btn btn-primary">{{ trans('file.Close Register') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- today sale modal -->
<div id="today-sale-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Today Sale') }} dan {{ trans('file.Today Profit') }}</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
            </div>
            <div class="modal-body">
                <p>{{ trans('file.Please review the transaction and payments.') }}</p>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <td>{{ trans('file.Total Sale Amount') }}:</td>
                                    <td class="total_sale_amount text-right"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('file.Cash Payment') }}:</td>
                                    <td class="cash_payment text-right"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('file.Credit Card Payment') }}:</td>
                                    <td class="credit_card_payment text-right"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('file.Cheque Payment') }}:</td>
                                    <td class="cheque_payment text-right"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('file.Gift Card Payment') }}:</td>
                                    <td class="gift_card_payment text-right"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('file.Deposit Payment') }}:</td>
                                    <td class="deposit_payment text-right"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('file.Paypal Payment') }}:</td>
                                    <td class="paypal_payment text-right"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('file.Total Payment') }}:</td>
                                    <td class="total_payment text-right"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('file.Total Sale Return') }}:</td>
                                    <td class="total_sale_return text-right"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('file.Total Expense') }}:</td>
                                    <td class="total_expense text-right"></td>
                                </tr>
                                <tr>
                                    <td><strong>{{ trans('file.Total Cash') }}:</strong></td>
                                    <td class="total_cash text-right"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12 mt-4">
                        <div class="row">
                            <div class="col-md-6">
                                <select required name="warehouseId" class="form-control">
                                    <option value="0">{{ trans('file.All Warehouse') }}</option>
                                    @foreach ($lims_warehouse_list as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mt-2">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <td>{{ trans('file.Product Revenue') }}:</td>
                                            <td class="product_revenue text-right"></td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('file.Product Cost') }}:</td>
                                            <td class="product_cost text-right"></td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('file.Expense') }}:</td>
                                            <td class="expense_amount text-right"></td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{ trans('file.Profit') }}:</strong></td>
                                            <td class="profit text-right"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- add customer modal -->
<div id="addCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['route' => 'customer.store', 'method' => 'post', 'files' => true]) !!}
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Add Customer') }}</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
            </div>
            <div class="modal-body">
                <p class="italic">
                    <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                </p>
                <div class="form-group">
                    <label>{{ trans('file.Customer Group') }} *</strong> </label>
                    <select required class="form-control selectpicker" name="customer_group_id">
                        @foreach ($lims_customer_group_all as $customer_group)
                        <option value="{{ $customer_group->id }}">{{ $customer_group->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>{{ trans('file.name') }} *</strong> </label>
                    <input type="text" name="customer_name" required class="form-control">
                </div>
                <div class="form-group">
                    <label>{{ trans('file.Email') }}</label>
                    <input type="text" name="email" placeholder="example@example.com" class="form-control">
                </div>
                <div class="form-group">
                    <label>{{ trans('file.Phone Number') }} *</label>
                    <input type="text" name="phone_number" required class="form-control">
                </div>
                <div class="form-group">
                    <label>{{ trans('file.Address') }} *</label>
                    <input type="text" name="address" required class="form-control">
                </div>
                <div class="form-group">
                    <label>{{ trans('file.City') }} *</label>
                    <input type="text" name="city" required class="form-control">
                </div>
                <div class="form-group">
                    <input type="hidden" name="pos" value="1">
                    <input type="submit" value="{{ trans('file.submit') }}" class="btn btn-primary">
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
@include('sale.pos_js')
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{ asset('js/app/pos.js') }}"></script>
<script>
    document.getElementById('open-product').addEventListener('click', function() {
        document.getElementById('content-menu').classList.add('show')
    })
    document.getElementById('close-menu-product').addEventListener('click', function() {
        document.getElementById('content-menu').classList.remove('show')
    })

</script>
@endpush
