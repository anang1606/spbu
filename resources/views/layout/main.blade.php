<!DOCTYPE html>
<html dir="@if (Config::get('app.locale') == 'ar' || $general_setting->is_rtl) {{ 'rtl' }} @endif">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $general_setting->site_title }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="manifest" href="{{ url('manifest.json') }}">
    <meta name="theme-color" content="#2264DC" />
    <!-- Bootstrap CSS-->
    <link rel="icon" type="image/png" href="{{ url('images/asset-icons.png') }}" />
    <link rel="stylesheet" href="<?php echo asset('vendor/bootstrap/css/bootstrap.min.css'); ?>" type="text/css">


    <link rel="preload" href="<?php echo asset('vendor/bootstrap-toggle/css/bootstrap-toggle.min.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link href="<?php echo asset('vendor/bootstrap-toggle/css/bootstrap-toggle.min.css'); ?>" rel="stylesheet">
    </noscript>
    <link rel="preload" href="<?php echo asset('vendor/bootstrap/css/bootstrap-datepicker.min.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link href="<?php echo asset('vendor/bootstrap/css/bootstrap-datepicker.min.css'); ?>" rel="stylesheet">
    </noscript>
    <link rel="preload" href="<?php echo asset('vendor/jquery-timepicker/jquery.timepicker.min.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link href="<?php echo asset('vendor/jquery-timepicker/jquery.timepicker.min.css'); ?>" rel="stylesheet">
    </noscript>
    <link rel="preload" href="<?php echo asset('vendor/bootstrap/css/awesome-bootstrap-checkbox.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link href="<?php echo asset('vendor/bootstrap/css/awesome-bootstrap-checkbox.css'); ?>" rel="stylesheet">
    </noscript>
    <link rel="preload" href="<?php echo asset('vendor/bootstrap/css/bootstrap-select.min.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link href="<?php echo asset('vendor/bootstrap/css/bootstrap-select.min.css'); ?>" rel="stylesheet">
    </noscript>
    <!-- Font Awesome CSS-->
    <link rel="preload" href="<?php echo asset('vendor/font-awesome/css/font-awesome.min.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link href="<?php echo asset('vendor/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet">
    </noscript>
    <!-- Drip icon font-->
    <link rel="preload" href="<?php echo asset('vendor/dripicons/webfont.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link href="<?php echo asset('vendor/dripicons/webfont.css'); ?>" rel="stylesheet">
    </noscript>
    <!-- Google fonts - Roboto -->
    <link rel="preload" href="https://fonts.googleapis.com/css?family=Nunito:400,500,700" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,500,700" rel="stylesheet">
    </noscript>
    <!-- jQuery Circle-->
    <link rel="preload" href="<?php echo asset('css/grasp_mobile_progress_circle-1.0.0.min.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link href="<?php echo asset('css/grasp_mobile_progress_circle-1.0.0.min.css'); ?>" rel="stylesheet">
    </noscript>
    <!-- Custom Scrollbar-->
    <link rel="preload" href="<?php echo asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link href="<?php echo asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css'); ?>" rel="stylesheet">
    </noscript>

    @if (Route::current()->getName() != '/')
        <!-- date range stylesheet-->
        <link rel="preload" href="<?php echo asset('vendor/daterange/css/daterangepicker.min.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript>
            <link href="<?php echo asset('vendor/daterange/css/daterangepicker.min.css'); ?>" rel="stylesheet">
        </noscript>
        <!-- table sorter stylesheet-->
        <link rel="preload" href="<?php echo asset('vendor/datatable/dataTables.bootstrap4.min.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript>
            <link href="<?php echo asset('vendor/datatable/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet">
        </noscript>
        <link rel="preload" href="https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.bootstrap.min.css"
            as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript>
            <link href="https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.bootstrap.min.css"
                rel="stylesheet">
        </noscript>
        <link rel="preload" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css"
            as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript>
            <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css"
                rel="stylesheet">
        </noscript>
    @endif

    <link rel="stylesheet" href="<?php echo asset('css/style.default.css'); ?>" id="theme-stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('css/dropzone.css'); ?>">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?php echo asset('css/custom-' . $general_setting->theme); ?>" type="text/css" id="custom-style">

    @if (Config::get('app.locale') == 'ar' || $general_setting->is_rtl)
        <!-- RTL css -->
        <link rel="stylesheet" href="<?php echo asset('vendor/bootstrap/css/bootstrap-rtl.min.css'); ?>" type="text/css">
        <link rel="stylesheet" href="<?php echo asset('css/custom-rtl.css'); ?>" type="text/css" id="custom-style">
    @endif
</head>

<body @if ($theme == 'dark') class="dark-mode dripicons-brightness-low" @else class="" @endif
    onload="myFunction()">
    <div id="loader"></div>
    @if ($general_setting->type === 'KbPeShVmYq3t6w9yBEHMcQfTjWnZ')
        @include('layout/__libs/standard_sidebar')
    @else
        @include('layout/__libs/premium_sidebar')
    @endif
    <div class="page">
        <!-- navbar-->
        @include('layout/__libs/header')
        <!-- notification modal -->
        <div id="notification-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Send Notification') }}</h5>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                    </div>
                    <div class="modal-body">
                        <p class="italic">
                            <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                        </p>
                        {!! Form::open(['route' => 'notifications.store', 'method' => 'post', 'files' => true]) !!}
                        <div class="row">
                            <?php
                            $lims_user_list = DB::table('users')
                                ->where([['is_active', true], ['id', '!=', \Auth::user()->id]])
                                ->get();
                            ?>
                            <div class="col-md-6 form-group">
                                <input type="hidden" name="sender_id" value="{{ \Auth::id() }}">
                                <label>{{ trans('file.User') }} *</label>
                                <select name="receiver_id" class="selectpicker form-control" required
                                    data-live-search="true" data-live-search-style="begins" title="Select user...">
                                    @foreach ($lims_user_list as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->name . ' (' . $user->email . ')' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>{{ trans('file.Attach Document') }}</label>
                                <input type="file" name="document" class="form-control">
                            </div>
                            <div class="col-md-12 form-group">
                                <label>{{ trans('file.Message') }} *</label>
                                <textarea rows="5" name="message" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{ trans('file.submit') }}</button>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- end notification modal -->

        <!-- expense modal -->
        <div id="expense-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Add Expense') }}</h5>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                    </div>
                    <div class="modal-body">
                        <p class="italic">
                            <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                        </p>
                        {!! Form::open(['route' => 'expenses.store', 'files' => true, 'method' => 'post']) !!}
                        <?php
                        $lims_expense_category_list = DB::table('expense_categories')
                            ->where('is_active', true)
                            ->get();
                        if (Auth::user()->role_id > 2) {
                            $lims_warehouse_list = DB::table('warehouses')
                                ->where([['is_active', true], ['id', Auth::user()->warehouse_id]])
                                ->get();
                        } else {
                            $lims_warehouse_list = DB::table('warehouses')
                                ->where('is_active', true)
                                ->get();
                        }
                        $lims_account_list = \App\Account::where('is_active', true)->get();
                        ?>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>{{ trans('file.Date') }}</label>
                                <input type="text" name="created_at" class="form-control date" readonly disabled
                                    value="{{ date('Y-m-d') }}" placeholder="Choose date" />
                                <input type="hidden" name="warehouse_id" value="{{ $lims_warehouse_list[0]->id }}">
                            </div>
                            @if ($general_setting->type !== 'KbPeShVmYq3t6w9yBEHMcQfTjWnZ')
                                <div class="col-md-6 form-group">
                                    <label>{{ trans('file.Expense Category') }} *</label>
                                    <select name="expense_category_id" class="selectpicker form-control" required
                                        data-live-search="true" data-live-search-style="begins"
                                        title="Select Expense Category...">
                                        @foreach ($lims_expense_category_list as $expense_category)
                                            <option value="{{ $expense_category->id }}">
                                                {{ $expense_category->name . ' (' . $expense_category->code . ')' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label> {{ trans('file.Account') }}</label>
                                    <select class="form-control selectpicker" name="account_id">
                                        @foreach ($lims_account_list as $account)
                                            @if ($account->is_default)
                                                <option selected value="{{ $account->id }}">{{ $account->name }}
                                                    [{{ $account->account_no }}]</option>
                                            @else
                                                <option value="{{ $account->id }}">{{ $account->name }}
                                                    [{{ $account->account_no }}]</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <input type="hidden" name="expense_category_id"
                                    value="{{ $lims_expense_category_list[0]->id }}">
                                <input type="hidden" name="account_id" value="{{ $lims_account_list[0]->id }}">
                            @endif
                            <div class="col-md-6 form-group">
                                <label>{{ trans('file.Amount') }} *</label>
                                <input type="text" name="amount" step="any" required
                                    class="form-control format-rupiah">
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ trans('file.Attach Document') }}</label>
                                    <i class="dripicons-question" data-toggle="tooltip"
                                        title="Only images file is supported"></i>
                                    <input type="file" name="document" accept="image/*" class="form-control">
                                    @if ($errors->has('extension'))
                                        <span>
                                            <strong>{{ $errors->first('extension') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('file.Note') }}</label>
                            <textarea name="note" rows="3" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{ trans('file.submit') }}</button>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- end expense modal -->

        <!-- account modal -->
        <div id="account-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Add Account') }}</h5>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                    </div>
                    <div class="modal-body">
                        <p class="italic">
                            <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                        </p>
                        {!! Form::open(['route' => 'accounts.store', 'method' => 'post']) !!}
                        <div class="form-group">
                            <label>{{ trans('file.Account No') }} *</label>
                            <input type="text" name="account_no" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>{{ trans('file.name') }} *</label>
                            <input type="text" name="name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>{{ trans('file.Initial Balance') }}</label>
                            <input type="number" name="initial_balance" step="any" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>{{ trans('file.Note') }}</label>
                            <textarea name="note" rows="3" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{ trans('file.submit') }}</button>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- end account modal -->

        <!-- account statement modal -->
        <div id="account-statement-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Account Statement') }}</h5>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                    </div>
                    <div class="modal-body">
                        <p class="italic">
                            <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                        </p>
                        {!! Form::open(['route' => 'accounts.statement', 'method' => 'post']) !!}
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label> {{ trans('file.Account') }}</label>
                                <select class="form-control selectpicker" name="account_id">
                                    @foreach ($lims_account_list as $account)
                                        <option value="{{ $account->id }}">{{ $account->name }}
                                            [{{ $account->account_no }}]</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label> {{ trans('file.Type') }}</label>
                                <select class="form-control selectpicker" name="type">
                                    <option value="0">{{ trans('file.All') }}</option>
                                    <option value="1">{{ trans('file.Debit') }}</option>
                                    <option value="2">{{ trans('file.Credit') }}</option>
                                </select>
                            </div>
                            <div class="col-md-12 form-group">
                                <label>{{ trans('file.Choose Your Date') }}</label>
                                <div class="input-group">
                                    <input type="text" class="daterangepicker-field form-control" required />
                                    <input type="hidden" name="start_date" />
                                    <input type="hidden" name="end_date" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{ trans('file.submit') }}</button>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- end account statement modal -->

        <!-- warehouse modal -->
        <div id="warehouse-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Warehouse Report') }}</h5>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                    </div>
                    <div class="modal-body">
                        <p class="italic">
                            <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                        </p>
                        {!! Form::open(['route' => 'report.warehouse', 'method' => 'post']) !!}

                        <div class="form-group">
                            <label>{{ trans('file.Warehouse') }} *</label>
                            <select name="warehouse_id" class="selectpicker form-control" required
                                data-live-search="true" id="warehouse-id" data-live-search-style="begins"
                                title="Select warehouse...">
                                @foreach ($lims_warehouse_list as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <input type="hidden" name="start_date" value="{{ date('Y-m') . '-' . '01' }}" />
                        <input type="hidden" name="end_date" value="{{ date('Y-m-d') }}" />

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{ trans('file.submit') }}</button>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- end warehouse modal -->

        <!-- user modal -->
        <div id="user-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
            class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.User Report') }}</h5>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                    </div>
                    <div class="modal-body">
                        <p class="italic">
                            <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                        </p>
                        {!! Form::open(['route' => 'report.user', 'method' => 'post']) !!}
                        <?php
                        $lims_user_list = DB::table('users')
                            ->where('is_active', true)
                            ->get();
                        ?>
                        <div class="form-group">
                            <label>{{ trans('file.User') }} *</label>
                            <select name="user_id" class="selectpicker form-control" required data-live-search="true"
                                id="user-id" data-live-search-style="begins" title="Select user...">
                                @foreach ($lims_user_list as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name . ' (' . $user->phone . ')' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <input type="hidden" name="start_date" value="{{ date('Y-m') . '-' . '01' }}" />
                        <input type="hidden" name="end_date" value="{{ date('Y-m-d') }}" />

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{ trans('file.submit') }}</button>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- end user modal -->

        <!-- customer modal -->
        <div id="customer-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Customer Report') }}</h5>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                    </div>
                    <div class="modal-body">
                        <p class="italic">
                            <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                        </p>
                        {!! Form::open(['route' => 'report.customer', 'method' => 'post']) !!}
                        <?php
                        $lims_customer_list = DB::table('customers')
                            ->where('is_active', true)
                            ->get();
                        ?>
                        <div class="form-group">
                            <label>{{ trans('file.customer') }} *</label>
                            <select name="customer_id" class="selectpicker form-control" required
                                data-live-search="true" id="customer-id" data-live-search-style="begins"
                                title="Select customer...">
                                @foreach ($lims_customer_list as $customer)
                                    <option value="{{ $customer->id }}">
                                        {{ $customer->name . ' (' . $customer->phone_number . ')' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <input type="hidden" name="start_date" value="{{ date('Y-m') . '-' . '01' }}" />
                        <input type="hidden" name="end_date" value="{{ date('Y-m-d') }}" />

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{ trans('file.submit') }}</button>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- end customer modal -->

        <!-- supplier modal -->
        <div id="supplier-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Supplier Report') }}</h5>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                    </div>
                    <div class="modal-body">
                        <p class="italic">
                            <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                        </p>
                        {!! Form::open(['route' => 'report.supplier', 'method' => 'post']) !!}
                        <?php
                        $lims_supplier_list = DB::table('suppliers')
                            ->where('is_active', true)
                            ->get();
                        ?>
                        <div class="form-group">
                            <label>{{ trans('file.Supplier') }} *</label>
                            <select name="supplier_id" class="selectpicker form-control" required
                                data-live-search="true" id="supplier-id" data-live-search-style="begins"
                                title="Select Supplier...">
                                @foreach ($lims_supplier_list as $supplier)
                                    <option value="{{ $supplier->id }}">
                                        {{ $supplier->name . ' (' . $supplier->phone_number . ')' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <input type="hidden" name="start_date" value="{{ date('Y-m') . '-' . '01' }}" />
                        <input type="hidden" name="end_date" value="{{ date('Y-m-d') }}" />

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{ trans('file.submit') }}</button>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- end supplier modal -->

        <div style="display:none" id="content" class="animate-bottom">
            @yield('content')
        </div>

        <footer class="main-footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <p>&copy; {{ $general_setting->site_title }} | {{ trans('file.Developed') }}
                            {{ trans('file.By') }} <span class="external">Cidigi Inovasi</span> | V 3.7
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script type="text/javascript" src="<?php echo asset('vendor/jquery/jquery.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/jquery/jquery-ui.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/jquery/bootstrap-datepicker.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/jquery/jquery.timepicker.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/popper.js/umd/popper.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/bootstrap-toggle/js/bootstrap-toggle.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/bootstrap/js/bootstrap-select.min.js'); ?>"></script>

    <script type="text/javascript" src="<?php echo asset('js/grasp_mobile_progress_circle-1.0.0.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/jquery.cookie/jquery.cookie.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/chart.js/Chart.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('js/charts-custom.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/jquery-validation/jquery.validate.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>
    @if (Config::get('app.locale') == 'ar' || $general_setting->is_rtl)
        <script type="text/javascript" src="<?php echo asset('js/front_rtl.js'); ?>"></script>
    @else
        <script type="text/javascript" src="<?php echo asset('js/front.js'); ?>"></script>
    @endif

    @if (Route::current()->getName() != '/')
        <script type="text/javascript" src="<?php echo asset('vendor/daterange/js/moment.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo asset('vendor/daterange/js/knockout-3.4.2.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo asset('vendor/daterange/js/daterangepicker.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo asset('vendor/tinymce/js/tinymce/tinymce.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo asset('js/dropzone.js'); ?>"></script>

        <!-- table sorter js-->
        <script type="text/javascript" src="<?php echo asset('vendor/datatable/pdfmake.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo asset('vendor/datatable/vfs_fonts.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo asset('vendor/datatable/jquery.dataTables.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo asset('vendor/datatable/dataTables.bootstrap4.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo asset('vendor/datatable/dataTables.buttons.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo asset('vendor/datatable/buttons.bootstrap4.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo asset('vendor/datatable/buttons.colVis.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo asset('vendor/datatable/buttons.html5.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo asset('vendor/datatable/buttons.print.min.js'); ?>"></script>

        <script type="text/javascript" src="<?php echo asset('vendor/datatable/sum().js'); ?>"></script>
        <script type="text/javascript" src="<?php echo asset('vendor/datatable/dataTables.checkboxes.min.js'); ?>"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js">
        </script>
        <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js">
        </script>
        <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js">
        </script>
    @endif
    @stack('scripts')
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/service-worker.js').then(function(
                    registration) {
                    // Registration was successful
                    console.log('ServiceWorker registration successful with scope: ', registration
                        .scope);
                }, function(err) {
                    // registration failed :(
                    console.log('ServiceWorker registration failed: ', err);
                });
            });
        }
    </script>
    <script type="text/javascript">
        var theme = <?php echo json_encode($theme); ?>;
        if (theme == 'dark') {
            $('body').addClass('dark-mode');
            $('#switch-theme i').addClass('dripicons-brightness-low');
        } else {
            $('body').removeClass('dark-mode');
            $('#switch-theme i').addClass('dripicons-brightness-max');
        }
        $('#switch-theme').click(function() {
            if (theme == 'light') {
                theme = 'dark';
                var url = <?php echo json_encode(route('switchTheme', 'dark')); ?>;
                $('body').addClass('dark-mode');
                $('#switch-theme i').addClass('dripicons-brightness-low');
            } else {
                theme = 'light';
                var url = <?php echo json_encode(route('switchTheme', 'light')); ?>;
                $('body').removeClass('dark-mode');
                $('#switch-theme i').addClass('dripicons-brightness-max');
            }

            $.get(url, function(data) {
                console.log('theme changed to ' + theme);
            });
        });

        var alert_product = <?php echo json_encode($alert_product); ?>;

        if ($(window).outerWidth() > 1199) {
            $('nav.side-navbar').removeClass('shrink');
        }

        function myFunction() {
            setTimeout(showPage, 100);
        }

        function showPage() {
            document.getElementById("loader").style.display = "none";
            document.getElementById("content").style.display = "block";
        }

        $("div.alert").delay(4000).slideUp(800);

        function confirmDelete() {
            if (confirm("Are you sure want to delete?")) {
                return true;
            }
            return false;
        }

        $("li#notification-icon").on("click", function(argument) {
            $.get('notifications/mark-as-read', function(data) {
                $("span.notification-number").text(alert_product);
            });
        });

        $("a#add-expense").click(function(e) {
            e.preventDefault();
            $('#expense-modal').modal();
        });

        $("a#send-notification").click(function(e) {
            e.preventDefault();
            $('#notification-modal').modal();
        });

        $("a#add-account").click(function(e) {
            e.preventDefault();
            $('#account-modal').modal();
        });

        $("a#account-statement").click(function(e) {
            e.preventDefault();
            $('#account-statement-modal').modal();
        });

        $("a#profitLoss-link").click(function(e) {
            e.preventDefault();
            $("#profitLoss-report-form").submit();
        });

        $("a#report-link").click(function(e) {
            e.preventDefault();
            $("#product-report-form").submit();
        });

        $("a#purchase-report-link").click(function(e) {
            e.preventDefault();
            $("#purchase-report-form").submit();
        });

        $("a#sale-report-link").click(function(e) {
            e.preventDefault();
            $("#sale-report-form").submit();
        });
        $("a#sale-report-chart-link").click(function(e) {
            e.preventDefault();
            $("#sale-report-chart-form").submit();
        });

        $("a#payment-report-link").click(function(e) {
            e.preventDefault();
            $("#payment-report-form").submit();
        });

        $("a#warehouse-report-link").click(function(e) {
            e.preventDefault();
            $('#warehouse-modal').modal();
        });

        $("a#user-report-link").click(function(e) {
            e.preventDefault();
            $('#user-modal').modal();
        });

        $("a#customer-report-link").click(function(e) {
            e.preventDefault();
            $('#customer-modal').modal();
        });

        $("a#supplier-report-link").click(function(e) {
            e.preventDefault();
            $('#supplier-modal').modal();
        });

        $("a#due-report-link").click(function(e) {
            e.preventDefault();
            $("#due-report-form").submit();
        });

        $(".daterangepicker-field").daterangepicker({
            callback: function(startDate, endDate, period) {
                var start_date = startDate.format('YYYY-MM-DD');
                var end_date = endDate.format('YYYY-MM-DD');
                var title = start_date + ' To ' + end_date;
                $(this).val(title);
                $('#account-statement-modal input[name="start_date"]').val(start_date);
                $('#account-statement-modal input[name="end_date"]').val(end_date);
            }
        });

        $('.date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true
        });

        $('.selectpicker').selectpicker({
            style: 'btn-link',
        });
    </script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="{{ asset('js/notification.js') }}"></script>
</body>

</html>
