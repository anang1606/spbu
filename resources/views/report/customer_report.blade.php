@extends('layout.main') @section('content')
    <section class="forms">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header mt-2">
                    <h3 class="text-center">{{ trans('file.Customer Report') }}</h3>
                </div>
                {!! Form::open(['route' => 'report.customer', 'method' => 'post']) !!}
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
                            <label class="d-tc mt-2"><strong>{{ trans('file.Choose Customer') }}</strong> &nbsp;</label>
                            <div class="d-tc">
                                <input type="hidden" name="customer_id_hidden" value="{{ $customer_id }}" />
                                <select id="customer_id" name="customer_id" class="selectpicker form-control"
                                    data-live-search="true" data-live-search-style="begins">
                                    @foreach ($lims_customer_list as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}
                                            ({{ $customer->phone_number }})
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
                <input type="hidden" name="customer_id_hidden" value="{{ $customer_id }}" />
                {!! Form::close() !!}
            </div>
        </div>
        <ul class="nav nav-tabs ml-4 mt-3" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" href="#customer-sale" role="tab"
                    data-toggle="tab">{{ trans('file.Sale') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#customer-payments" role="tab"
                    data-toggle="tab">{{ trans('file.Payment') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#customer-return" role="tab" data-toggle="tab">{{ trans('file.return') }}</a>
            </li>
        </ul>

        <div class="tab-content">

            <div role="tabpanel" class="tab-pane fade show active" id="customer-sale">
                <div class="table-responsive mb-4">
                    <table id="sale-table" class="table table-hover">
                        <thead>
                            <tr>
                                <th class="not-exported-sale"></th>
                                <th>{{ trans('file.Date') }}</th>
                                <th>{{ trans('file.reference') }} No</th>
                                <th>{{ trans('file.product') }} ({{ trans('file.qty') }})</th>
                                <th>{{ trans('file.grand total') }}</th>
                                <th>{{ trans('file.Paid') }}</th>
                                {{--  <th>{{ trans('file.Due') }}</th>  --}}
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
                                    <td>{{ $sale->paid_amount }}</td>
                                    {{--  <td>{{ $sale->grand_total - $sale->paid_amount }}  --}}
                                    </td>
                                    @if ($sale->sale_status == 1)
                                        <td>
                                            <div class="badge badge-success">{{ trans('file.Completed') }}</div>
                                        </td>
                                    @elseif($sale->sale_status == 1)
                                        <td>
                                            <div class="badge badge-danger">{{ trans('file.Pending') }}</div>
                                        </td>
                                    @else
                                        <td>
                                            <div class="badge badge-danger">{{ trans('file.Return') }}</div>
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
                                <th>0.00</th>
                                <th>0.00</th>
                                {{--  <th>0.00</th>  --}}
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="customer-payments">
                <div class="table-responsive mb-4">
                    <table id="payment-table" class="table table-hover">
                        <thead>
                            <tr>
                                <th class="not-exported-payment"></th>
                                <th>{{ trans('file.Date') }}</th>
                                <th>{{ trans('file.Payment Reference') }}</th>
                                <th>{{ trans('file.Sale Reference') }}</th>
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
                                    <td>{{ $payment->sale_reference }}</td>
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
                                <th>0.00</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="customer-return">
                <div class="table-responsive mb-4">
                    <table id="return-table" class="table table-hover">
                        <thead>
                            <tr>
                                <th class="not-exported-return"></th>
                                <th>{{ trans('file.Date') }}</th>
                                <th>{{ trans('file.reference') }}</th>
                                <th>{{ trans('file.Biller') }}</th>
                                <th>{{ trans('file.product') }} ({{ trans('file.qty') }})</th>
                                <th>{{ trans('file.grand total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lims_return_data as $key => $return)
                                <tr>
                                    <td>{{ $key }}</td>
                                    <td>{{ date($general_setting->date_format, strtotime($return->created_at->toDateString())) . ' ' . $return->created_at->toTimeString() }}
                                    </td>
                                    <td>{{ $return->reference_no }}</td>
                                    <td>{{ $return->biller->name }}</td>
                                    <td>
                                        @foreach ($lims_product_return_data[$key] as $product_return_data)
                                            <?php
                                            $product = App\Product::select('name')->find($product_return_data->product_id);
                                            if ($product_return_data->variant_id) {
                                                $variant = App\Variant::find($product_return_data->variant_id);
                                                $product->name .= ' [' . $variant->name . ']';
                                            }
                                            $unit = App\Unit::find($product_return_data->sale_unit_id);
                                            ?>
                                            @if ($unit)
                                                {{ $product->name . ' (' . number_format($product_return_data->qty,0,'.','.') . ' ' . $unit->unit_code . ')' }}
                                            @else
                                                {{ $product->name . ' (' . number_format($product_return_data->qty,0,'.','.') . ')' }}
                                            @endif
                                            <br>
                                        @endforeach
                                    </td>
                                    <td>{{ $return->grand_total }}</td>
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
                                <th>0.00</th>
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
        $("ul#report #customer-report-menu").addClass("active");

        $('#customer_id').val($('input[name="customer_id_hidden"]').val());
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
                    'targets': [4, 5],
                    'render': function(data, type, row, meta) {
                        return 'Rp. '+formatRupiah(data.toString())
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

                $(dt_selector.column(4).footer()).html('Rp. '+formatRupiah(dt_selector.cells(rows, 4, {
                    page: 'current'
                }).data().sum().toFixed(0).toString()));
                $(dt_selector.column(5).footer()).html('Rp. '+formatRupiah(dt_selector.cells(rows, 5, {
                    page: 'current'
                }).data().sum().toFixed(0).toString()));
            } else {
                $(dt_selector.column(4).footer()).html('Rp. '+formatRupiah(dt_selector.column(4, {
                    page: 'current'
                }).data().sum().toFixed(0).toString()));
                $(dt_selector.column(5).footer()).html('Rp. '+formatRupiah(dt_selector.column(5, {
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
                    'targets': 4,
                    'render': function(data, type, row, meta) {
                        return 'Rp. '+formatRupiah(data.toString())
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

                $(dt_selector.column(4).footer()).html('Rp. '+formatRupiah(dt_selector.cells(rows, 4, {
                    page: 'current'
                }).data().sum().toFixed(0).toString()));
            } else {
                $(dt_selector.column(4).footer()).html('Rp. '+formatRupiah(dt_selector.column(4, {
                    page: 'current'
                }).data().sum().toFixed(0).toString()));
            }
        }

        $('#return-table').DataTable({
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
                    'targets': 5,
                    'render': function(data, type, row, meta) {
                        return 'Rp. '+formatRupiah(data.toString())
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
                        datatable_sum_return(dt, true);
                        $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                        datatable_sum_return(dt, false);
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
                        datatable_sum_return(dt, true);
                        $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                        datatable_sum_return(dt, false);
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
                        datatable_sum_return(dt, true);
                        $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                        datatable_sum_return(dt, false);
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
                datatable_sum_return(api, false);
            }
        });

        function datatable_sum_return(dt_selector, is_calling_first) {
            if (dt_selector.rows('.selected').any() && is_calling_first) {
                var rows = dt_selector.rows('.selected').indexes();

                $(dt_selector.column(5).footer()).html('Rp. '+formatRupiah(dt_selector.cells(rows, 5, {
                    page: 'current'
                }).data().sum().toFixed(0).toString()));
            } else {
                $(dt_selector.column(5).footer()).html('Rp. '+formatRupiah(dt_selector.column(5, {
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
