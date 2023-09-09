@extends('layout.main') @section('content')

    @if (empty($product_name))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert"
                aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ 'No Data exist between this date range!' }}</div>
    @endif

    <section class="forms">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header mt-2">
                    <h3 class="text-center">{{ trans('file.Sale Report') }}</h3>
                </div>
                {!! Form::open(['route' => 'report.sale', 'method' => 'post']) !!}
                <div class="row mb-3 product-report-filter">
                    <div class="col-md-10 offset-md-1 mt-3">
                        <div class="form-group">
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
                    <div class="col-md-4 mt-3 d-none">
                        <div class="form-group row">
                            <label class="d-tc mt-2"><strong>{{ trans('file.Choose Warehouse') }}</strong> &nbsp;</label>
                            <div class="d-tc">
                                <select name="warehouse_id" class="selectpicker form-control" data-live-search="true"
                                    data-live-search-style="begins">
                                    <option value="0">{{ trans('file.All Warehouse') }}</option>
                                    @foreach ($lims_warehouse_list as $warehouse)
                                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 offset-md-1 mt-3">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">{{ trans('file.submit') }}</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="table-responsive">
            <table id="report-table" class="table table-hover">
                <thead>
                    <tr>
                        <th class="not-exported"></th>
                        <th>{{ trans('file.Product Name') }}</th>
                        <th>{{ trans('file.Sold Amount') }}</th>
                        <th>{{ trans('file.Sold Qty') }}</th>
                        <th>{{ trans('file.In Stock') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($product_name))
                        @foreach ($product_id as $key => $pro_id)
                            <tr>
                                <td>{{ $key }}</td>
                                <td>{{ $product_name[$key] }}</td>
                                <?php
                                if ($warehouse_id == 0) {
                                    if ($variant_id[$key]) {
                                        $sold_price = DB::table('product_sales')
                                            ->where([['product_id', $pro_id], ['variant_id', $variant_id[$key]]])
                                            ->whereDate('created_at', '>=', $start_date)
                                            ->whereDate('created_at', '<=', $end_date)
                                            ->sum('total');

                                        $product_sale_data = DB::table('product_sales')
                                            ->where([['product_id', $pro_id], ['variant_id', $variant_id[$key]]])
                                            ->whereDate('created_at', '>=', $start_date)
                                            ->whereDate('created_at', '<=', $end_date)
                                            ->get();
                                    } else {
                                        $sold_price = DB::table('product_sales')
                                            ->where('product_id', $pro_id)
                                            ->whereDate('created_at', '>=', $start_date)
                                            ->whereDate('created_at', '<=', $end_date)
                                            ->sum('total');

                                        $product_sale_data = DB::table('product_sales')
                                            ->where('product_id', $pro_id)
                                            ->whereDate('created_at', '>=', $start_date)
                                            ->whereDate('created_at', '<=', $end_date)
                                            ->get();
                                    }
                                } else {
                                    if ($variant_id[$key]) {
                                        $sold_price = DB::table('sales')
                                            ->join('product_sales', 'sales.id', '=', 'product_sales.sale_id')
                                            ->where([['product_sales.product_id', $pro_id], ['variant_id', $variant_id[$key]], ['sales.warehouse_id', $warehouse_id]])
                                            ->whereDate('sales.created_at', '>=', $start_date)
                                            ->whereDate('sales.created_at', '<=', $end_date)
                                            ->sum('total');
                                        $product_sale_data = DB::table('sales')
                                            ->join('product_sales', 'sales.id', '=', 'product_sales.sale_id')
                                            ->where([['product_sales.product_id', $pro_id], ['variant_id', $variant_id[$key]], ['sales.warehouse_id', $warehouse_id]])
                                            ->whereDate('sales.created_at', '>=', $start_date)
                                            ->whereDate('sales.created_at', '<=', $end_date)
                                            ->get();
                                    } else {
                                        $sold_price = DB::table('sales')
                                            ->join('product_sales', 'sales.id', '=', 'product_sales.sale_id')
                                            ->where([['product_sales.product_id', $pro_id], ['sales.warehouse_id', $warehouse_id]])
                                            ->whereDate('sales.created_at', '>=', $start_date)
                                            ->whereDate('sales.created_at', '<=', $end_date)
                                            ->sum('total');
                                        $product_sale_data = DB::table('sales')
                                            ->join('product_sales', 'sales.id', '=', 'product_sales.sale_id')
                                            ->where([['product_sales.product_id', $pro_id], ['sales.warehouse_id', $warehouse_id]])
                                            ->whereDate('sales.created_at', '>=', $start_date)
                                            ->whereDate('sales.created_at', '<=', $end_date)
                                            ->get();
                                    }
                                }
                                $sold_qty = 0;
                                foreach ($product_sale_data as $product_sale) {
                                    $unit = DB::table('units')->find($product_sale->sale_unit_id);
                                    if ($unit) {
                                        if ($unit->operator == '*') {
                                            $sold_qty += $product_sale->qty * $unit->operation_value;
                                        } elseif ($unit->operator == '/') {
                                            $sold_qty += $product_sale->qty / $unit->operation_value;
                                        }
                                    } else {
                                        $sold_qty += $product_sale->qty;
                                    }
                                }
                                ?>
                                <td>{{ $sold_price }}</td>
                                {{--  <td>{{ number_format((float) $sold_price, 0, '.', '.') }}</td>  --}}
                                <td>{{ $sold_qty }}</td>
                                <td>{{ $product_qty[$key] }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <th></th>
                    <th>Total</th>
                    <th>0.00</th>
                    <th>0</th>
                    <th>0</th>
                </tfoot>
            </table>
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
        $("ul#report #sale-report-menu").addClass("active");

        $('#warehouse_id').val($('input[name="warehouse_id_hidden"]').val());
        $('.selectpicker').selectpicker('refresh');

        $('#report-table').DataTable({
            "order": [],
            'language': {
                'lengthMenu': '_MENU_ {{ trans('file.records per page') }}',
                "info": '<small>{{ trans('file.Showing') }} _START_ - _END_ (_TOTAL_)</small>',
                "search": '{{ trans('file.Search') }}',
                'paginate': {
                    'previous': '<i class="dripicons-chevron-left"></i>',
                    'next': '<i class="dripicons-chevron-right"></i>'
                }
            },
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
                    'targets': [3,4],
                    'render': function(data, type, row, meta) {
                        return formatRupiah(data.toString())
                    },
                },
                {
                    'targets': [2],
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
                    text: '<i title="export to pdf" class="fa fa-file-pdf-o"></i>',
                    exportOptions: {
                        columns: ':visible:not(.not-exported)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum(dt, true);
                        $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                        datatable_sum(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'csv',
                    text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
                    exportOptions: {
                        columns: ':visible:not(.not-exported)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum(dt, true);
                        $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                        datatable_sum(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'print',
                    text: '<i title="print" class="fa fa-print"></i>',
                    exportOptions: {
                        columns: ':visible:not(.not-exported)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum(dt, true);
                        $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                        datatable_sum(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'colvis',
                    text: '<i title="column visibility" class="fa fa-eye"></i>',
                    columns: ':gt(0)'
                }
            ],
            drawCallback: function() {
                var api = this.api();
                datatable_sum(api, false);
            }
        });

        function datatable_sum(dt_selector, is_calling_first) {
            if (dt_selector.rows('.selected').any() && is_calling_first) {
                var rows = dt_selector.rows('.selected').indexes();

                $(dt_selector.column(2).footer()).html('Rp. '+formatRupiah(dt_selector.cells(rows, 2, {
                    page: 'current'
                }).data().sum().toFixed(0).toString()));
                $(dt_selector.column(3).footer()).html(formatRupiah(dt_selector.cells(rows, 3, {
                    page: 'current'
                }).data().sum().toString()));
                $(dt_selector.column(4).footer()).html(formatRupiah(dt_selector.cells(rows, 4, {
                    page: 'current'
                }).data().sum().toFixed(0).toString()));
            } else {
                $(dt_selector.column(2).footer()).html('Rp. '+formatRupiah(dt_selector.column(2, {
                    page: 'current'
                }).data().sum().toFixed(0).toString()));
                $(dt_selector.column(3).footer()).html(formatRupiah(dt_selector.column(3, {
                    page: 'current'
                }).data().sum().toString()));
                $(dt_selector.column(4).footer()).html(formatRupiah(dt_selector.column(4, {
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