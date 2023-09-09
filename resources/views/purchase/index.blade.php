@extends('layout.main') @section('content')
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
    @endif
    @if (session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert"
                aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}
        </div>
    @endif

    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header mt-2">
                    <h3 class="text-center">{{ trans('file.Purchase List') }}</h3>
                </div>
                {!! Form::open(['route' => 'purchases.index', 'method' => 'get']) !!}
                <div class="row ml-1 mt-2">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>{{ trans('file.Date') }}</strong></label>
                            <input type="text" class="daterangepicker-field form-control"
                                value="{{ $starting_date }} To {{ $ending_date }}" required />
                            <input type="hidden" name="starting_date" value="{{ $starting_date }}" />
                            <input type="hidden" name="ending_date" value="{{ $ending_date }}" />
                        </div>
                    </div>
                    <div class="col-md-3 d-none">
                        <div class="form-group">
                            <label><strong>{{ trans('file.Warehouse') }}</strong></label>
                            <select id="warehouse_id" name="warehouse_id" class="selectpicker form-control"
                                data-live-search="true" data-live-search-style="begins">
                                <option value="0">{{ trans('file.All Warehouse') }}</option>
                                @foreach ($lims_warehouse_list as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>{{ trans('file.Purchase Status') }}</strong></label>
                            <select id="purchase-status" class="form-control" name="purchase_status">
                                <option value="0">{{ trans('file.All') }}</option>
                                <option value="1">{{ trans('file.Recieved') }}</option>
                                <option value="2">{{ trans('file.Partial') }}</option>
                                <option value="3">{{ trans('file.Pending') }}</option>
                                <option value="4">{{ trans('file.Ordered') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>{{ trans('file.Payment Status') }}</strong></label>
                            <select id="payment-status" class="form-control" name="payment_status">
                                <option value="0">{{ trans('file.All') }}</option>
                                <option value="1">{{ trans('file.Due') }}</option>
                                <option value="2">{{ trans('file.Paid') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 mt-3">
                        <div class="form-group">
                            <button class="btn btn-primary" id="filter-btn"
                                type="submit">{{ trans('file.submit') }}</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            @if (in_array('purchases-add', $all_permission))
                <a href="{{ route('purchases.create') }}" class="btn btn-info"><i class="dripicons-plus"></i>
                    {{ trans('file.Add Purchase') }}</a>&nbsp;
                {{-- <a href="{{ url('purchases/purchase_by_csv') }}" class="btn btn-primary"><i class="dripicons-copy"></i>
                    {{ trans('file.Import Purchase') }}</a> --}}
            @endif
        </div>
        <div class="table-responsive">
            <table id="purchase-table" class="table purchase-list" style="width: 100%">
                <thead>
                    <tr>
                        <th class="not-exported"></th>
                        <th>{{ trans('file.Date') }}</th>
                        <th>{{ trans('file.reference') }}</th>
                        <th>{{ trans('file.Purchase Status') }}</th>
                        <th>{{ trans('file.grand total') }}</th>
                        <th>{{ trans('file.Paid') }}</th>
                        <th>{{ trans('file.Payment Status') }}</th>
                        <th class="not-exported">{{ trans('file.action') }}</th>
                    </tr>
                </thead>

                <tfoot class="tfoot active">
                    <th></th>
                    <th>{{ trans('file.Total') }}</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tfoot>
            </table>
        </div>
    </section>

    <div id="purchase-details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        class="modal fade text-left">
        <div role="document" class="modal-dialog modal-lg">
            <div class="modal-content table-responsive">
                <div class="container mt-3 pb-2 border-bottom">
                    <div class="row">
                        <div class="col-md-6 d-print-none">
                            <button id="print-btn" type="button" class="btn btn-default btn-sm"><i
                                    class="dripicons-print"></i> {{ trans('file.Print') }}</button>
                        </div>
                        <div class="col-md-6 d-print-none">
                            <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close"
                                class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                        </div>
                        <div class="col-md-12">
                            <h3 id="exampleModalLabel" class="modal-title text-center container-fluid">
                                {{ $general_setting->site_title }}</h3>
                        </div>
                        <div class="col-md-12 text-center">
                            <i style="font-size: 15px;">{{ trans('file.Purchase Details') }}</i>
                        </div>
                    </div>
                </div>
                <div id="purchase-content" class="modal-body"></div>
                <br>
                <table class="table table-bordered product-purchase-list">
                    <thead>
                        <th>#</th>
                        <th>{{ trans('file.product') }}</th>
                        <th>Qty</th>
                        <th>{{ trans('file.Unit Cost') }}</th>
                        <th>{{ trans('file.Discount') }}</th>
                        <th>{{ trans('file.Subtotal') }}</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div id="purchase-footer" class="modal-body"></div>
            </div>
        </div>
    </div>

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
        $(".daterangepicker-field").daterangepicker({
            callback: function(startDate, endDate, period) {
                var starting_date = startDate.format('YYYY-MM-DD');
                var ending_date = endDate.format('YYYY-MM-DD');
                var title = starting_date + ' To ' + ending_date;
                $(this).val(title);
                $('input[name="starting_date"]').val(starting_date);
                $('input[name="ending_date"]').val(ending_date);
            }
        });

        $("#purchase-list-menu").addClass("active");

        var public_key = <?php echo json_encode($lims_pos_setting_data->stripe_public_key); ?>;
        var all_permission = <?php echo json_encode($all_permission); ?>;

        var purchase_id = [];
        var user_verified = <?php echo json_encode(env('USER_VERIFIED')); ?>;
        var starting_date = <?php echo json_encode($starting_date); ?>;
        var ending_date = <?php echo json_encode($ending_date); ?>;
        var warehouse_id = <?php echo json_encode($warehouse_id); ?>;
        var purchase_status = <?php echo json_encode($purchase_status); ?>;
        var payment_status = <?php echo json_encode($payment_status); ?>;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#warehouse_id").val(warehouse_id);
        $("#purchase-status").val(purchase_status);
        $("#payment-status").val(payment_status);

        $('.selectpicker').selectpicker('refresh');

        function confirmDelete() {
            if (confirm("Are you sure want to delete?")) {
                return true;
            }
            return false;
        }

        function confirmDeletePayment() {
            if (confirm("Are you sure want to delete? If you delete this money will be refunded")) {
                return true;
            }
            return false;
        }

        $(document).on("click", "tr.purchase-link td:not(:first-child, :last-child)", function() {
            var purchases = $(this).parent().data('purchase').replaceAll('[', '').replaceAll(']', '');
            var purchaseData = purchases.split(',');
            purchaseDetails(purchaseData);
        });

        $(document).on("click", ".view", function() {
            var purchase = $(this).parent().parent().parent().parent().parent().data('purchase').replaceAll('[', '').replaceAll(']', '');
            var purchaseData = purchase.split(',');
            purchaseDetails(purchaseData);
        });

        $("#print-btn").on("click", function() {
            var divContents = document.getElementById("purchase-details").innerHTML;
            var a = window.open('');
            a.document.write('<html>');
            a.document.write(
                '<body><style>body{font-family: sans-serif;line-height: 1.15;-webkit-text-size-adjust: 100%;}.d-print-none{display:none}.text-center{text-align:center}.row{width:100%;margin-right: -15px;margin-left: -15px;}.col-md-12{width:100%;display:block;padding: 5px 15px;}.col-md-6{width: 50%;float:left;padding: 5px 15px;}table{width:100%;margin-top:30px;}th{text-aligh:left;}td{padding:10px}table, th, td{border: 1px solid black; border-collapse: collapse;}</style><style>@media print {.modal-dialog { max-width: 1000px;} }</style>'
            );
            a.document.write(divContents);
            a.document.write('</body></html>');
            a.document.close();
            setTimeout(function() {
                a.close();
            }, 10);
            a.print();
        });

        $(document).on("click", "table.purchase-list tbody .add-payment", function(event) {
            $("#cheque").hide();
            $(".card-element").hide();
            $('select[name="paid_by_id"]').val(1);
            rowindex = $(this).closest('tr').index();
            var purchase_id = $(this).data('id').toString();
            var balance = $('table.purchase-list tbody tr:nth-child(' + (rowindex + 1) + ')').find(
                'td:nth-child(8)').text().replaceAll('Rp. ','');
            balance = parseFloat(balance.replaceAll(/[,.]/g, ''));
            $('input[name="amount"]').val(formatRupiah(balance.toString()));
            $('input[name="balance"]').val(formatRupiah(balance.toString()));
            $('input[name="paying_amount"]').val(formatRupiah(balance.toString()));
            $('input[name="purchase_id"]').val(purchase_id);
        });

        $(document).on('input','.format-rupiah',function(e){
            $(this).val(formatRupiah($(this).val().toString()))
        })

        $(document).on("click", "table.purchase-list tbody .get-payment", function(event) {
            var id = $(this).data('id').toString();
            $.get('purchases/getpayment/' + id, function(data) {
                $(".payment-list tbody").remove();
                var newBody = $("<tbody>");
                payment_date = data[0];
                payment_reference = data[1];
                paid_amount = data[2];
                paying_method = data[3];
                payment_id = data[4];
                payment_note = data[5];
                cheque_no = data[6];
                change = data[7];
                paying_amount = data[8];
                account_name = data[9];
                account_id = data[10];

                $.each(payment_date, function(index) {
                    var newRow = $("<tr>");
                    var cols = '';

                    cols += '<td>' + payment_date[index] + '</td>';
                    cols += '<td>' + payment_reference[index] + '</td>';
                    cols += '<td>' + account_name[index] + '</td>';
                    cols += '<td>' + 'Rp. '+formatRupiah(paid_amount[index].toString()) + '</td>';
                    cols += '<td>' + paying_method[index] + '</td>';
                    cols +=
                        '<td><div class="btn-group"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button><ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">';
                    if (all_permission.indexOf("purchase-payment-edit") != -1)
                        cols +=
                        '<li><button type="button" class="btn btn-link edit-btn" data-id="' +
                        payment_id[index] +
                        '" data-clicked=false data-toggle="modal" data-target="#edit-payment"><i class="dripicons-document-edit"></i> Edit</button></li><li class="divider"></li>';
                    if (all_permission.indexOf("purchase-payment-delete") != -1)
                        cols +=
                        '{{ Form::open(['route' => 'purchase.delete-payment', 'method' => 'post']) }}<li><input type="hidden" name="id" value="' +
                        payment_id[index] +
                        '" /> <button type="submit" class="btn btn-link" onclick="return confirmDeletePayment()"><i class="dripicons-trash"></i> Delete</button></li>{{ Form::close() }}';
                    cols += '</ul></div></td>';
                    newRow.append(cols);
                    newBody.append(newRow);
                    $("table.payment-list").append(newBody);
                });
                $('#view-payment').modal('show');
            });
        });

        $(document).on("click", "table.payment-list .edit-btn", function(event) {
            $(".edit-btn").attr('data-clicked', true);
            $(".card-element").hide();
            $("#edit-cheque").hide();
            $('#edit-payment select[name="edit_paid_by_id"]').prop('disabled', false);
            var id = $(this).data('id').toString();
            $.each(payment_id, function(index) {
                if (payment_id[index] == parseFloat(id)) {
                    $('input[name="payment_id"]').val(payment_id[index]);
                    $('#edit-payment select[name="account_id"]').val(account_id[index]);
                    if (paying_method[index] == 'Cash')
                        $('select[name="edit_paid_by_id"]').val(1);
                    else if (paying_method[index] == 'Credit Card') {
                        $('select[name="edit_paid_by_id"]').val(3);
                        $.getScript("public/vendor/stripe/checkout.js");
                        $(".card-element").show();
                        $("#edit-cheque").hide();
                        $('#edit-payment select[name="edit_paid_by_id"]').prop('disabled', true);
                    } else {
                        $('select[name="edit_paid_by_id"]').val(4);
                        $("#edit-cheque").show();
                        $('input[name="edit_cheque_no"]').val(cheque_no[index]);
                        $('input[name="edit_cheque_no"]').attr('required', true);
                    }
                    $('input[name="edit_date"]').val(payment_date[index]);
                    $("#payment_reference").html(payment_reference[index]);
                    $('input[name="edit_amount"]').val(formatRupiah(paid_amount[index].toString()));
                    $('input[name="edit_paying_amount"]').val(formatRupiah(paying_amount[index].toString()));
                    $('.change').text(formatRupiah(change[index].toString()));
                    $('textarea[name="edit_payment_note"]').val(payment_note[index]);
                    return false;
                }
            });
            $('.selectpicker').selectpicker('refresh');
            $('#view-payment').modal('hide');
        });

        $('select[name="paid_by_id"]').on("change", function() {
            var id = $('select[name="paid_by_id"]').val();
            $('input[name="cheque_no"]').attr('required', false);
            $(".payment-form").off("submit");
            if (id == 3) {
                $.getScript("public/vendor/stripe/checkout.js");
                $(".card-element").show();
                $("#cheque").hide();
            } else if (id == 4) {
                $("#cheque").show();
                $(".card-element").hide();
                $('input[name="cheque_no"]').attr('required', true);
            } else {
                $(".card-element").hide();
                $("#cheque").hide();
            }
        });

        $('input[name="paying_amount"]').on("input", function() {
            const change = $(this).val().replaceAll('.','') - $('#amount').val().replaceAll('.','')
            let displayTotal = (change < 0) ? '-' + formatRupiah(change.toString()) : formatRupiah(change.toString())

            $(".change").text(displayTotal);
            $(this).val(formatRupiah($(this).val().toString()))
        });

        $('input[name="amount"]').on("input", function() {
            if ($(this).val() > parseFloat($('input[name="paying_amount"]').val())) {
                alert('Jumlah pembayaran tidak boleh lebih besar dari jumlah yang diterima');
                $(this).val('');
            } else if ($(this).val() > parseFloat($('input[name="balance"]').val())) {
                alert('Paying amount cannot be bigger than due amount');
                $(this).val('');
            }
            $(".change").text(parseFloat($('input[name="paying_amount"]').val() - $(this).val()).toFixed(0));
        });

        $('select[name="edit_paid_by_id"]').on("change", function() {
            var id = $('select[name="edit_paid_by_id"]').val();
            $('input[name="edit_cheque_no"]').attr('required', false);
            $(".payment-form").off("submit");
            if (id == 3) {
                $(".edit-btn").attr('data-clicked', true);
                $.getScript("public/vendor/stripe/checkout.js");
                $(".card-element").show();
                $("#edit-cheque").hide();
            } else if (id == 4) {
                $("#edit-cheque").show();
                $(".card-element").hide();
                $('input[name="edit_cheque_no"]').attr('required', true);
            } else {
                $(".card-element").hide();
                $("#edit-cheque").hide();
            }
        });

        $('input[name="edit_amount"]').on("input", function() {
            if ($(this).val().replaceAll('.','') > parseFloat($('input[name="edit_paying_amount"]').val().replaceAll('.',''))) {
                alert('Jumlah pembayaran tidak boleh lebih besar dari jumlah yang diterima');
            }
            $(".change").text(formatRupiah(parseFloat($('input[name="edit_paying_amount"]').val().replaceAll('.','') - $(this).val().replaceAll('.','')).toFixed(0).toString()));
        });

        $('input[name="edit_paying_amount"]').on("input", function() {
            $(".change").text(formatRupiah(parseFloat($(this).val().replaceAll('.','') - $('input[name="edit_amount"]').val().replaceAll('.','')).toFixed(0).toString()));
        });

        $('#purchase-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "purchases/purchase-data",
                data: {
                    all_permission: all_permission,
                    starting_date: starting_date,
                    ending_date: ending_date,
                    warehouse_id: warehouse_id,
                    purchase_status: purchase_status,
                    payment_status: payment_status
                },
                dataType: "json",
                type: "get",
                /*success:function(data){
                    console.log(data);
                }*/
            },
            "createdRow": function(row, data, dataIndex) {
                $(row).addClass('purchase-link');
                $(row).attr('data-purchase', data['purchase']);
            },
            "columns": [{
                    "data": "key"
                },
                {
                    "data": "date"
                },
                {
                    "data": "reference_no"
                },
                {
                    "data": "purchase_status"
                },
                {
                    "data": "grand_total",
                },
                {
                    "data": "paid_amount",
                },
                {
                    "data": "payment_status"
                },
                {
                    "data": "options"
                },
            ],
            'language': {
                /*'searchPlaceholder': "{{ trans('file.Type date or purchase reference...') }}",*/
                'lengthMenu': '_MENU_ {{ trans('file.records per page') }}',
                "info": '<small>{{ trans('file.Showing') }} _START_ - _END_ (_TOTAL_)</small>',
                "search": '{{ trans('file.Search') }}',
                'paginate': {
                    'previous': '<i class="dripicons-chevron-left"></i>',
                    'next': '<i class="dripicons-chevron-right"></i>'
                }
            },
            order: [
                ['1', 'desc']
            ],
            'columnDefs': [{
                    "orderable": false,
                    'targets': [0, 3, 4, 6, 7]
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
                    'render': function(data, type, row, meta) {
                        return 'Rp. '+formatRupiah(data.toString())
                    },
                    'targets': [4,5]
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
                        columns: ':visible:Not(.not-exported)',
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
                    text: '<i title="delete" class="dripicons-cross"></i>',
                    className: 'buttons-delete',
                    action: function(e, dt, node, config) {
                        if (user_verified == '1') {
                            purchase_id.length = 0;
                            $(':checkbox:checked').each(function(i) {
                                if (i) {
                                    var purchase = $(this).closest('tr').data('purchase');
                                    purchase_id[i - 1] = purchase[3];
                                }
                            });
                            if (purchase_id.length && confirm("Are you sure want to delete?")) {
                                $.ajax({
                                    type: 'POST',
                                    url: 'purchases/deletebyselection',
                                    data: {
                                        purchaseIdArray: purchase_id
                                    },
                                    success: function(data) {
                                        alert(data);
                                        //dt.rows({ page: 'current', selected: true }).deselect();
                                        dt.rows({
                                            page: 'current',
                                            selected: true
                                        }).remove().draw(false);
                                    }
                                });
                            } else if (!purchase_id.length)
                                alert('Nothing is selected!');
                        } else
                            alert('This feature is disable for demo!');
                    }
                },
                {
                    extend: 'colvis',
                    text: '<i title="column visibility" class="fa fa-eye"></i>',
                    columns: ':gt(0)'
                },
            ],
            drawCallback: function() {
                var api = this.api();
                datatable_sum(api, false);
            }
        });

        function datatable_sum(dt_selector, is_calling_first) {
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

        function purchaseDetails(purchase) {
            var htmltext = '<strong>{{ trans('file.Date') }}: </strong>' + purchase[0] +
                '<br><strong>{{ trans('file.reference') }}: </strong>' + purchase[1] +
                '<br><strong>{{ trans('file.Purchase Status') }}: </strong>' + purchase[2]

            $.get('purchases/product_purchase/' + purchase[3], function(data) {
                $(".product-purchase-list tbody").remove();
                var name_code = data[0];
                var qty = data[1];
                var unit_code = data[2];
                var tax = data[3];
                var tax_rate = data[4];
                var discount = data[5];
                var subtotal = data[6];
                var batch_no = data[7];
                var newBody = $("<tbody>");
                $.each(name_code, function(index) {
                    var newRow = $("<tr>");
                    var cols = '';
                    cols += '<td><strong>' + (index + 1) + '</strong></td>';
                    cols += '<td>' + name_code[index] + '</td>';
                    cols += '<td>' + formatRupiah(qty[index].toString()) + ' ' + unit_code[index] + '</td>';
                    cols += '<td>' + 'Rp. '+formatRupiah((subtotal[index] / qty[index]).toString()) + '</td>';
                    cols += '<td>' + 'Rp. '+formatRupiah(discount[index].toString()) + '</td>';
                    cols += '<td>' + 'Rp. '+formatRupiah(subtotal[index].toString()) + '</td>';
                    newRow.append(cols);
                    newBody.append(newRow);
                });

                var newRow = $("<tr>");
                cols = '';
                cols += '<td colspan=3><strong>{{ trans('file.Total') }}:</strong></td>';
                cols += '<td>' + 'Rp. '+formatRupiah(purchase[14].toString()) + '</td>';
                cols += '<td>' + 'Rp. '+formatRupiah(purchase[15].toString()) + '</td>';
                cols += '<td>' + 'Rp. '+formatRupiah(purchase[16].toString()) + '</td>';
                newRow.append(cols);
                newBody.append(newRow);

                var newRow = $("<tr>");
                cols = '';
                cols += '<td colspan="5"><strong>{{ trans('file.Order Discount') }}:</strong></td>';
                cols += '<td>' + 'Rp. '+formatRupiah(purchase[19].toString()) + '</td>';
                newRow.append(cols);
                newBody.append(newRow);

                var newRow = $("<tr>");
                cols = '';
                cols += '<td colspan="5"><strong>{{ trans('file.Shipping Cost') }}:</strong></td>';
                cols += '<td>' + 'Rp. '+formatRupiah(purchase[20].toString()) + '</td>';
                newRow.append(cols);
                newBody.append(newRow);

                var newRow = $("<tr>");
                cols = '';
                cols += '<td colspan="5"><strong>{{ trans('file.grand total') }}:</strong></td>';
                cols += '<td>' + 'Rp. '+formatRupiah(purchase[21].toString()) + '</td>';
                newRow.append(cols);
                newBody.append(newRow);

                var newRow = $("<tr>");
                cols = '';
                cols += '<td colspan="5"><strong>{{ trans('file.Paid Amount') }}:</strong></td>';
                cols += '<td>' + 'Rp. '+formatRupiah(purchase[22].toString()) + '</td>';
                newRow.append(cols);
                newBody.append(newRow);


                $("table.product-purchase-list").append(newBody);
            });

            var htmlfooter = '<p><strong>{{ trans('file.Note') }}:</strong> ' + purchase[23] +
                '</p><strong>{{ trans('file.Created By') }}:</strong><br>' + purchase[24] + '<br>' + purchase[25];

            $('#purchase-content').html(htmltext);
            $('#purchase-footer').html(htmlfooter);
            $('#purchase-details').modal('show');
        }

        $(document).on('submit', '.payment-form', function(e) {
            if ($('input[name="paying_amount"]').val().replaceAll('.','') < $('#amount').val().replaceAll('.','')) {
                alert('Jumlah pembayaran tidak boleh lebih besar dari jumlah yang diterima');
                e.preventDefault();
            } else if ($('input[name="edit_paying_amount"]').val().replaceAll('.','') < parseFloat($('input[name="edit_amount"]').val().replaceAll('.',''))) {
                alert('Jumlah pembayaran tidak boleh lebih besar dari jumlah yang diterima');
                e.preventDefault();
            }

            $('#edit-payment select[name="edit_paid_by_id"]').prop('disabled', false);
        });

        if (all_permission.indexOf("purchases-delete") == -1)
            $('.buttons-delete').addClass('d-none');
    </script>
    <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
@endpush
