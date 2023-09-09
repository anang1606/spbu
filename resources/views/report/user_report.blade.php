@extends('layout.main') @section('content')
    <section class="forms">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header mt-2">
                    <h3 class="text-center">{{ trans('file.User Report') }}</h3>
                </div>
                {!! Form::open(['route' => 'report.user', 'method' => 'post']) !!}
                <div class="row mb-3">
                    <div class="col-md-4 offset-md-2 mt-3">
                        <div class="form-group row">
                            <label class="d-tc mt-2"><strong>{{ trans('file.Choose Your Date') }}</strong> &nbsp;</label>
                            <div class="d-tc">
                                <div class="input-group">
                                    <input type="text" class="daterangepicker-field form-control"
                                        value="{{ $start_date }} To {{ $end_date }}" required />
                                    <input type="hidden" name="start_date" value="{{ $start_date }}" />
                                    <input type="hidden" name="end_date" value="{{ $end_date }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-group row">
                            <label class="d-tc mt-2"><strong>{{ trans('file.Choose User') }}</strong> &nbsp;</label>
                            <div class="d-tc">
                                <input type="hidden" name="user_id_hidden" value="{{ $user_id }}" />
                                <select id="user_id" name="user_id" class="selectpicker form-control"
                                    data-live-search="true" data-live-search-style="begins">
                                    @foreach ($lims_user_list as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->phone }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 mt-3">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">{{ trans('file.submit') }}</button>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="user_id_hidden" value="{{ $user_id }}" />
                {!! Form::close() !!}
            </div>
        </div>
        <ul class="nav nav-tabs ml-4 mt-3" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" href="#user-sale" role="tab" data-toggle="tab">{{ trans('file.Sale') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#user-purchase" role="tab" data-toggle="tab">{{ trans('file.Purchase') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#user-payments" role="tab" data-toggle="tab">{{ trans('file.Payment') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#user-expense" role="tab" data-toggle="tab">{{ trans('file.Expense') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#user-payroll" role="tab" data-toggle="tab">{{ trans('file.Payroll') }}</a>
            </li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade show active" id="user-sale">
                <div class="table-responsive mb-4">
                    <table id="sale-table" class="table table-hover">
                        <thead>
                            <tr>
                                <th class="not-exported-sale"></th>
                                <th>{{ trans('file.Date') }}</th>
                                <th>{{ trans('file.reference') }}</th>
                                <th>{{ trans('file.customer') }}</th>
                                <th>{{ trans('file.product') }} ({{ trans('file.qty') }})</th>
                                <th>{{ trans('file.grand total') }}</th>
                                <th>{{ trans('file.Paid') }}</th>
                                <th>{{ trans('file.Due') }}</th>
                                <th>{{ trans('file.Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lims_sale_data as $key => $sale)
                                <tr>
                                    <td>{{ $key }}</td>
                                    <td>{{ date($general_setting->date_format, strtotime($sale->created_at->toDateString())) . ' ' . $sale->created_at->toTimeString() }}
                                    </td>
                                    <td>{{ $sale->reference_no }}</td>
                                    <td>{{ $sale->customer->name }}</td>
                                    <td>
                                        @foreach ($lims_product_sale_data[$key] as $product_sale_data)
                                            <?php
                                            $product = App\Product::select('name')->find($product_sale_data->product_id);
                                            if ($product_sale_data->variant_id) {
                                                $variant = App\Variant::find($product_sale_data->variant_id);
                                                $product->name .= ' [' . $variant->name . ']';
                                            }
                                            $unit = App\Unit::find($product_sale_data->sale_unit_id);
                                            ?>
                                            @if ($unit)
                                                {{ $product->name . ' (' . number_format($product_sale_data->qty,0,'.','.') . ' ' . $unit->unit_code . ')' }}
                                            @else
                                                {{ $product->name . ' (' . number_format($product_sale_data->qty,0,'.','.') . ')' }}
                                            @endif
                                            <br>
                                        @endforeach
                                    </td>
                                    <td>{{ $sale->grand_total }}</td>
                                    @if ($sale->paid_amount)
                                        <td class="paid-amount">{{ $sale->paid_amount }}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    <td>{{ $sale->grand_total - $sale->paid_amount }}</td>
                                    @if ($sale->sale_status == 1)
                                        <td>
                                            <div class="badge badge-success">{{ trans('file.Completed') }}</div>
                                        </td>
                                    @else
                                        <td>
                                            <div class="badge badge-danger">{{ trans('file.Pending') }}</div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="tfoot active">
                            <tr>
                                <th></th>
                                <th>Total:</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="user-purchase">
                <div class="table-responsive mb-4">
                    <table id="purchase-table" class="table table-hover">
                        <thead>
                            <tr>
                                <th class="not-exported-purchase"></th>
                                <th>{{ trans('file.Date') }}</th>
                                <th>{{ trans('file.reference') }}</th>
                                <th>{{ trans('file.Supplier') }}</th>
                                <th>{{ trans('file.product') }} ({{ trans('file.qty') }})</th>
                                <th>{{ trans('file.grand total') }}</th>
                                <th>{{ trans('file.Paid Amount') }}</th>
                                <th>{{ trans('file.Due') }}</th>
                                <th>{{ trans('file.Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lims_purchase_data as $key => $purchase)
                                <tr>
                                    <td>{{ $key }}</td>
                                    <?php
                                    $supplier = DB::table('suppliers')->find($purchase->supplier_id);
                                    ?>
                                    <td>{{ date($general_setting->date_format, strtotime($purchase->created_at->toDateString())) . ' ' . $purchase->created_at->toTimeString() }}
                                    </td>
                                    <td>{{ $purchase->reference_no }}</td>
                                    @if ($supplier)
                                        <td>{{ $supplier->name }}</td>
                                    @else
                                        <td>N/A</td>
                                    @endif
                                    <td>
                                        @foreach ($lims_product_purchase_data[$key] as $product_purchase_data)
                                            <?php
                                            $product = App\Product::select('name')->find($product_purchase_data->product_id);
                                            if ($product_purchase_data->variant_id) {
                                                $variant = App\Variant::find($product_purchase_data->variant_id);
                                                $product->name .= ' [' . $variant->name . ']';
                                            }
                                            $unit = App\Unit::find($product_purchase_data->purchase_unit_id);
                                            ?>
                                            @if ($unit)
                                                {{ $product->name . ' (' . number_format($product_purchase_data->qty,0,'.','.') . ' ' . $unit->unit_code . ')' }}
                                            @else
                                                {{ $product->name . ' (' . number_format($product_purchase_data->qty,0,'.','.') . ')' }}
                                            @endif
                                            <br>
                                        @endforeach
                                    </td>
                                    <td>{{ $purchase->grand_total }}</td>
                                    <td>{{ $purchase->paid_amount }}</td>
                                    <td>{{ $purchase->grand_total - $purchase->paid_amount }}</td>
                                    @if ($purchase->status == 1)
                                        <td>
                                            <div class="badge badge-success">{{ trans('file.Recieved') }}</div>
                                        </td>
                                    @elseif($purchase->status == 2)
                                        <td>
                                            <div class="badge badge-success">{{ trans('file.Partial') }}</div>
                                        </td>
                                    @elseif($purchase->status == 3)
                                        <td>
                                            <div class="badge badge-danger">{{ trans('file.Pending') }}</div>
                                        </td>
                                    @elseif($purchase->status == 4)
                                        <td>
                                            <div class="badge badge-danger">{{ trans('file.Ordered') }}</div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="tfoot active">
                            <tr>
                                <th></th>
                                <th>Total:</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="user-payments">
                <div class="table-responsive mb-4">
                    <table id="payment-table" class="table table-hover">
                        <thead>
                            <tr>
                                <th class="not-exported-payment"></th>
                                <th>{{ trans('file.Date') }}</th>
                                <th>{{ trans('file.reference') }}</th>
                                <th>{{ trans('file.Amount') }}</th>
                                <th>{{ trans('file.Paid Method') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lims_payment_data as $key => $payment)
                                <tr>
                                    <td>{{ $key }}</td>
                                    <td>{{ date($general_setting->date_format, strtotime($payment->created_at)) }}</td>
                                    <td>{{ $payment->payment_reference }}</td>
                                    <td>{{ $payment->amount }}</td>
                                    <td>{{ $payment->paying_method }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="tfoot active">
                            <tr>
                                <th></th>
                                <th>Total:</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="user-expense">
                <div class="table-responsive mb-4">
                    <table id="expense-table" class="table table-hover">
                        <thead>
                            <tr>
                                <th class="not-exported-expense"></th>
                                <th>{{ trans('file.Date') }}</th>
                                <th>{{ trans('file.reference') }}</th>
                                <th>{{ trans('file.category') }}</th>
                                <th>{{ trans('file.Amount') }}</th>
                                <th>{{ trans('file.Note') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lims_expense_data as $key => $expense)
                                <tr>
                                    <td>{{ $key }}</td>
                                    <td>{{ date($general_setting->date_format, strtotime($expense->created_at)) }}</td>
                                    <td>{{ $expense->reference_no }}</td>
                                    <td>{{ $expense->expenseCategory->name }}</td>
                                    <td>{{ $expense->amount }}</td>
                                    <td>{{ $expense->note }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="tfoot active">
                            <tr>
                                <th></th>
                                <th>Total:</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="user-payroll">
                <div class="table-responsive mb-4">
                    <table id="payroll-table" class="table table-hover">
                        <thead>
                            <tr>
                                <th class="not-exported-payroll"></th>
                                <th>{{ trans('file.Date') }}</th>
                                <th>{{ trans('file.reference') }}</th>
                                <th>{{ trans('file.Employee') }}</th>
                                <th>{{ trans('file.Amount') }}</th>
                                <th>{{ trans('file.Method') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lims_payroll_data as $key => $payroll)
                                <tr>
                                    <td>{{ $key }}</td>
                                    <td>{{ date($general_setting->date_format, strtotime($payroll->created_at)) }}</td>
                                    <td>{{ $payroll->reference_no }}</td>
                                    <td>{{ $payroll->employee->name }}</td>
                                    <td>{{ $payroll->amount }}</td>
                                    @if ($payroll->paying_method == 0)
                                        <td>Cash</td>
                                    @elseif($payroll->paying_method == 1)
                                        <td>Cheque</td>
                                    @else
                                        <td>Credit Card</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="tfoot active">
                            <tr>
                                <th></th>
                                <th>Total:</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    <script type="text/javascript">
        function formatRupiah(angka) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi),
                separator = '';

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return rupiah;
        }
        $("ul#report").siblings('a').attr('aria-expanded', 'true');
        $("ul#report").addClass("show");
        $("ul#report #user-report-menu").addClass("active");

        $('#user_id').val($('input[name="user_id_hidden"]').val());
        $('.selectpicker').selectpicker('refresh');

        $('#sale-table').DataTable({
            "order": [],
            'columnDefs': [{
                    "orderable": false,
                    'targets': 0
                },
                {
                    'render': function(data, type, row, meta) {
                        if (type === 'display') {
                            data =
                                '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                        }

                        return data;
                    },
                    'checkboxes': {
                        'selectRow': true,
                        'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                    },
                    'targets': [0]
                },
                {
                    'targets': [5,6,7],
                    'render': function(data, type, row, meta) {
                        return 'Rp. '+formatRupiah((data !== null) ? data.toString() : '0')
                    },
                }
            ],
            'select': {
                style: 'multi',
                selector: 'td:first-child'
            },
            'lengthMenu': [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            dom: '<"row"lfB>rtip',
            buttons: [{
                    extend: 'pdf',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported-sale)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_sale(dt, true);
                        $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                        datatable_sum_sale(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported-sale)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_sale(dt, true);
                        $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                        datatable_sum_sale(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported-sale)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_sale(dt, true);
                        $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                        datatable_sum_sale(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'colvis',
                    columns: ':gt(0)'
                }
            ],
            drawCallback: function() {
                var api = this.api();
                datatable_sum_sale(api, false);
            }
        });

        function datatable_sum_sale(dt_selector, is_calling_first) {
            if (dt_selector.rows('.selected').any() && is_calling_first) {
                var rows = dt_selector.rows('.selected').indexes();

                $(dt_selector.column(5).footer()).html('Rp. '+formatRupiah(dt_selector.cells(rows, 5, {
                    page: 'current'
                }).data().sum().toFixed(0).toString()));
                $(dt_selector.column(6).footer()).html('Rp. '+formatRupiah(dt_selector.cells(rows, 6, {
                    page: 'current'
                }).data().sum().toFixed(0).toString()));
                $(dt_selector.column(7).footer()).html('Rp. '+formatRupiah(dt_selector.cells(rows, 7, {
                    page: 'current'
                }).data().sum().toFixed(0).toString()));
            } else {

                $(dt_selector.column(5).footer()).html('Rp. '+formatRupiah(dt_selector.column(5, {
                    page: 'current'
                }).data().sum().toFixed(0).toString()));
                $(dt_selector.column(6).footer()).html('Rp. '+formatRupiah(dt_selector.cells(rows, 6, {
                    page: 'current'
                }).data().sum().toFixed(0).toString()));
                $(dt_selector.column(7).footer()).html('Rp. '+formatRupiah(dt_selector.cells(rows, 7, {
                    page: 'current'
                }).data().sum().toFixed(0).toString()));
            }
        }

        $('#purchase-table').DataTable({
            "order": [],
            'columnDefs': [{
                    "orderable": false,
                    'targets': 0
                },
                {
                    'render': function(data, type, row, meta) {
                        if (type === 'display') {
                            data =
                                '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                        }

                        return data;
                    },
                    'checkboxes': {
                        'selectRow': true,
                        'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                    },
                    'targets': [0]
                },
                {
                    'targets': [5,6,7],
                    'render': function(data, type, row, meta) {
                        return 'Rp. '+formatRupiah((data !== null) ? data.toString() : '0')
                    },
                }
            ],
            'select': {
                style: 'multi',
                selector: 'td:first-child'
            },
            'lengthMenu': [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            dom: '<"row"lfB>rtip',
            buttons: [{
                    extend: 'pdf',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported-quotation)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_purchase(dt, true);
                        $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                        datatable_sum_purchase(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_purchase(dt, true);
                        $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                        datatable_sum_purchase(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_purchase(dt, true);
                        $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                        datatable_sum_purchase(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'colvis',
                    columns: ':gt(0)'
                }
            ],
            drawCallback: function() {
                var api = this.api();
                datatable_sum_purchase(api, false);
            }
        });

        function datatable_sum_purchase(dt_selector, is_calling_first) {
            if (dt_selector.rows('.selected').any() && is_calling_first) {
                var rows = dt_selector.rows('.selected').indexes();

                $(dt_selector.column(5).footer()).html('Rp. '+formatRupiah(dt_selector.cells(rows, 5, {
                    page: 'current'
                }).data().sum().toFixed(0).toString()));
                $(dt_selector.column(6).footer()).html('Rp. '+formatRupiah(dt_selector.cells(rows, 6, {
                    page: 'current'
                }).data().sum().toFixed(0).toString()));
                $(dt_selector.column(7).footer()).html('Rp. '+formatRupiah(dt_selector.cells(rows, 7, {
                    page: 'current'
                }).data().sum().toFixed(0).toString()));
            } else {
                $(dt_selector.column(5).footer()).html('Rp. '+formatRupiah(dt_selector.column(5, {
                    page: 'current'
                }).data().sum().toFixed(0).toString()));
                $(dt_selector.column(6).footer()).html('Rp. '+formatRupiah(dt_selector.column(6, {
                    page: 'current'
                }).data().sum().toFixed(0).toString()));
                $(dt_selector.column(7).footer()).html('Rp. '+formatRupiah(dt_selector.column(7, {
                    page: 'current'
                }).data().sum().toFixed(0).toString()));
            }
        }

        $('#payment-table').DataTable({
            "order": [],
            'columnDefs': [{
                    "orderable": false,
                    'targets': 0
                },
                {
                    'render': function(data, type, row, meta) {
                        if (type === 'display') {
                            data =
                                '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                        }

                        return data;
                    },
                    'checkboxes': {
                        'selectRow': true,
                        'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                    },
                    'targets': [0]
                },
                {
                    'targets': [3],
                    'render': function(data, type, row, meta) {
                        return 'Rp. '+formatRupiah((data !== null) ? data.toString() : '0')
                    },
                }
            ],
            'select': {
                style: 'multi',
                selector: 'td:first-child'
            },
            'lengthMenu': [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            dom: '<"row"lfB>rtip',
            buttons: [{
                    extend: 'pdf',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported-payment)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_payment(dt, true);
                        $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                        datatable_sum_payment(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_payment(dt, true);
                        $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                        datatable_sum_payment(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_payment(dt, true);
                        $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                        datatable_sum_payment(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'colvis',
                    columns: ':gt(0)'
                }
            ],
            drawCallback: function() {
                var api = this.api();
                datatable_sum_payment(api, false);
            }
        });

        function datatable_sum_payment(dt_selector, is_calling_first) {
            if (dt_selector.rows('.selected').any() && is_calling_first) {
                var rows = dt_selector.rows('.selected').indexes();

                $(dt_selector.column(3).footer()).html('Rp. '+formatRupiah(dt_selector.cells(rows, 3, {
                    page: 'current'
                }).data().sum().toFixed(0).toString()));
            } else {
                $(dt_selector.column(3).footer()).html('Rp. '+formatRupiah(dt_selector.column(3, {
                    page: 'current'
                }).data().sum().toFixed(0).toString()));
            }
        }

        $('#expense-table').DataTable({
            "order": [],
            'columnDefs': [{
                    "orderable": false,
                    'targets': 0
                },
                {
                    'render': function(data, type, row, meta) {
                        if (type === 'display') {
                            data =
                                '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                        }

                        return data;
                    },
                    'checkboxes': {
                        'selectRow': true,
                        'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                    },
                    'targets': [0]
                },
                {
                    'targets': [4],
                    'render': function(data, type, row, meta) {
                        return 'Rp. '+formatRupiah((data !== null) ? data.toString() : '0')
                    },
                }
            ],
            'select': {
                style: 'multi',
                selector: 'td:first-child'
            },
            'lengthMenu': [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            dom: '<"row"lfB>rtip',
            buttons: [{
                    extend: 'pdf',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported-expense)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_expense(dt, true);
                        $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                        datatable_sum_expense(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_expense(dt, true);
                        $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                        datatable_sum_expense(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_expense(dt, true);
                        $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                        datatable_sum_expense(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'colvis',
                    columns: ':gt(0)'
                }
            ],
            drawCallback: function() {
                var api = this.api();
                datatable_sum_expense(api, false);
            }
        });

        function datatable_sum_expense(dt_selector, is_calling_first) {
            if (dt_selector.rows('.selected').any() && is_calling_first) {
                var rows = dt_selector.rows('.selected').indexes();

                $(dt_selector.column(4).footer()).html('Rp. '+formatRupiah(dt_selector.cells(rows, 4, {
                    page: 'current'
                }).data().sum().toFixed(0).toString()));
            } else {
                $(dt_selector.column(4).footer()).html('Rp. '+formatRupiah(dt_selector.column(4, {
                    page: 'current'
                }).data().sum().toFixed(0).toString()));
            }
        }

        $('#payroll-table').DataTable({
            "order": [],
            'columnDefs': [{
                    "orderable": false,
                    'targets': 0
                },
                {
                    'render': function(data, type, row, meta) {
                        if (type === 'display') {
                            data =
                                '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                        }

                        return data;
                    },
                    'checkboxes': {
                        'selectRow': true,
                        'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                    },
                    'targets': [0]
                },
                {
                    'targets': [4],
                    'render': function(data, type, row, meta) {
                        return 'Rp. '+formatRupiah((data !== null) ? data.toString() : '0')
                    },
                }
            ],
            'select': {
                style: 'multi',
                selector: 'td:first-child'
            },
            'lengthMenu': [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            dom: '<"row"lfB>rtip',
            buttons: [{
                    extend: 'pdf',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported-payroll)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_payroll(dt, true);
                        $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                        datatable_sum_payroll(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_payroll(dt, true);
                        $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                        datatable_sum_payroll(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_payroll(dt, true);
                        $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                        datatable_sum_payroll(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'colvis',
                    columns: ':gt(0)'
                }
            ],
            drawCallback: function() {
                var api = this.api();
                datatable_sum_payroll(api, false);
            }
        });

        function datatable_sum_payroll(dt_selector, is_calling_first) {
            if (dt_selector.rows('.selected').any() && is_calling_first) {
                var rows = dt_selector.rows('.selected').indexes();

                $(dt_selector.column(4).footer()).html('Rp. '+formatRupiah(dt_selector.cells(rows, 4, {
                    page: 'current'
                }).data().sum().toFixed(0).toString()));
            } else {
                $(dt_selector.column(4).footer()).html('Rp. '+formatRupiah(dt_selector.column(4, {
                    page: 'current'
                }).data().sum().toFixed(0).toString()));
            }
        }

        $(".daterangepicker-field").daterangepicker({
            callback: function(startDate, endDate, period) {
                var start_date = startDate.format('YYYY-MM-DD');
                var end_date = endDate.format('YYYY-MM-DD');
                var title = start_date + ' To ' + end_date;
                $(this).val(title);
                $('input[name="start_date"]').val(start_date);
                $('input[name="end_date"]').val(end_date);
            }
        });
    </script>
@endpush
