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
                    <h3 class="text-center">{{ trans('file.Expense List') }}</h3>
                </div>
                {!! Form::open(['route' => 'expenses.index', 'method' => 'get']) !!}
                <div class="row mb-3">
                    <div class="col-md-10 offset-md-1 mt-3">
                        <div class="form-group">
                            <label class="d-tc mt-2"><strong>{{ trans('file.Choose Your Date') }}</strong> &nbsp;</label>
                            <div class="d-tc">
                                <div class="input-group">
                                    <input type="text" class="daterangepicker-field form-control"
                                        value="{{ $starting_date }} To {{ $ending_date }}" required />
                                    <input type="hidden" name="starting_date" value="{{ $starting_date }}" />
                                    <input type="hidden" name="ending_date" value="{{ $ending_date }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3 d-none">
                        <div class="form-group row">
                            <label class="d-tc mt-2"><strong>{{ trans('file.Choose Warehouse') }}</strong> &nbsp;</label>
                            <div class="d-tc">
                                <select id="warehouse_id" name="warehouse_id" class="selectpicker form-control"
                                    data-live-search="true" data-live-search-style="begins">
                                    <option value="0">{{ trans('file.All Warehouse') }}</option>
                                    @foreach ($lims_warehouse_list as $warehouse)
                                        @if ($warehouse->id == $warehouse_id)
                                            <option selected value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                        @else
                                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                        @endif
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
            @if (in_array('expenses-add', $all_permission))
                <button class="btn btn-info" data-toggle="modal" data-target="#expense-modal"><i class="dripicons-plus"></i>
                    {{ trans('file.Add Expense') }}</button>
            @endif
        </div>
        <div class="table-responsive">
            <table id="expense-table" class="table expense-list" style="width: 100%">
                <thead>
                    <tr>
                        <th class="not-exported"></th>
                        <th>{{ trans('file.Date') }}</th>
                        <th>{{ trans('file.reference') }} No</th>
                        @if ($general_setting->type !== 'KbPeShVmYq3t6w9yBEHMcQfTjWnZ')
                            <th>{{ trans('file.category') }}</th>
                        @endif
                        <th>{{ trans('file.Amount') }}</th>
                        <th>{{ trans('file.Note') }}</th>
                        <th>Lampiran</th>
                        <th class="not-exported">{{ trans('file.action') }}</th>
                    </tr>
                </thead>
                <tfoot class="tfoot active">
                    <th></th>
                    <th>{{ trans('file.Total') }}</th>
                    <th></th>
                    @if ($general_setting->type !== 'KbPeShVmYq3t6w9yBEHMcQfTjWnZ')
                        <th></th>
                    @endif
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tfoot>
            </table>
        </div>
    </section>

    <div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Update Expense') }}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                            aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                    <p class="italic">
                        <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                    </p>
                    {!! Form::open(['route' => ['expenses.update', 1], 'files' => true,'method' => 'put']) !!}
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
                    ?>
                    <div class="form-group">
                        <input type="hidden" name="expense_id">
                        <label>{{ trans('file.reference') }}</label>
                        <p id="reference">{{ 'er-' . date('Ymd') . '-' . date('his') }}</p>
                    </div>
                    <div class="row">
                            <div class="col-md-6 form-group">
                                <label>{{ trans('file.Date') }}</label>
                                <input type="text" name="created_at" class="form-control" readonly disabled />
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
                             <input type="hidden" name="expense_category_id" value="{{ $lims_expense_category_list[0]->id }}">
                             <input type="hidden" name="account_id" value="{{ $lims_account_list[0]->id }}">
                             @endif
                             <div class="col-md-6 form-group">
                                <label>{{ trans('file.Amount') }} *</label>
                                <input type="text" name="amount" step="any" required class="form-control format-rupiah">
                            </div>
                            <input type="hidden" name="old_document">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ trans('file.Attach Document') }}</label>
                                    <i class="dripicons-question" data-toggle="tooltip" title="Only images file is supported"></i>
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

    <div id="imageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Lampiran</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                            aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                    <img src="" id="image-preview" alt="lampiran" style="width: 100%;height:100%;" />
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $("ul#expense").siblings('a').attr('aria-expanded', 'true');
        $("ul#expense").addClass("show");
        $("ul#expense #exp-list-menu").addClass("active");

        var expense_id = [];
        var user_verified = <?php echo json_encode(env('USER_VERIFIED')); ?>;
        var all_permission = <?php echo json_encode($all_permission); ?>;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

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

        $(document).ready(function() {
            $(document).on('click', 'button.open-Editexpense_categoryDialog', function() {
                var url = "expenses/";
                var id = $(this).data('id').toString();
                url = url.concat(id).concat("/edit");
                $.get(url, function(data) {
                    $('#editModal #reference').text(data['reference_no']);
                    $("#editModal input[name='created_at']").val(data['date']);
                    $("#editModal select[name='warehouse_id']").val(data['warehouse_id']);
                    $("#editModal select[name='expense_category_id']").val(data[
                        'expense_category_id']);
                    $("#editModal select[name='account_id']").val(data['account_id']);
                    $("#editModal input[name='amount']").val(formatRupiah(data['amount'].toString()));
                    $("#editModal input[name='expense_id']").val(data['id']);
                    $("#editModal input[name='old_document']").val(data['document']);
                    $("#editModal textarea[name='note']").val(data['note']);
                    $('.selectpicker').selectpicker('refresh');
                });
            });
        });

        function confirmDelete() {
            if (confirm("Are you sure want to delete?")) {
                return true;
            }
            return false;
        }

        $(document).on('input','.format-rupiah',function(e){
            $(this).val(formatRupiah($(this).val().toString()))
        })

        var starting_date = $("input[name=starting_date]").val();
        var ending_date = $("input[name=ending_date]").val();
        var warehouse_id = $("#warehouse_id").val();
        $('#expense-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "expenses/expense-data",
                data: {
                    all_permission: all_permission,
                    starting_date: starting_date,
                    ending_date: ending_date,
                    warehouse_id: warehouse_id
                },
                dataType: "json",
                type: "post"
            },
            // "createdRow": function( row, data, dataIndex ) {
            // },
            "columns": [{
                    "data": "key"
                },
                {
                    "data": "date"
                },
                {
                    "data": "reference_no"
                },
                @if ($general_setting->type !== 'KbPeShVmYq3t6w9yBEHMcQfTjWnZ')
                    {
                        "data": "expenseCategory"
                    },
                @endif
                {
                    "data": "amount",
                },
                {
                    "data": "note"
                },
                {
                    "data": null,
                    render:function(data){
                        if(data.document){
                            return `<a href="javascript:void(0)" onclick="seeImage(this)" data-image="${btoa(data.document)}" class="text-info" style="text-decoration:underline;">Lihat</a>`
                        }
                        return ''
                    }
                },
                {
                    "data": "options"
                }
            ],
            'language': {

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
                    @if ($general_setting->type !== 'KbPeShVmYq3t6w9yBEHMcQfTjWnZ')
                    'targets': [0, 3, 4, 6,7]
                    @else
                    'targets': [0, 3, 5,6]
                    @endif
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
                    @if ($general_setting->type !== 'KbPeShVmYq3t6w9yBEHMcQfTjWnZ')
                        'targets': [4]
                    @else
                        'targets': [3]
                    @endif
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
            rowId: 'ObjectID',
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
                        columns: ':visible:Not(.not-exported)',
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
                        columns: ':visible:Not(.not-exported)',
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
                            expense_id.length = 0;
                            $(':checkbox:checked').each(function(i) {
                                if (i) {
                                    var expense = $(this).closest('tr').data('expense');
                                    expense_id[i - 1] = expense[3];
                                }
                            });
                            if (expense_id.length && confirm("Are you sure want to delete?")) {
                                $.ajax({
                                    type: 'POST',
                                    url: 'expenses/deletebyselection',
                                    data: {
                                        expenseIdArray: expense_id
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
                            } else if (!expense_id.length)
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

        const seeImage = (e) => {
            $('#imageModal').modal('show')
            document.getElementById('image-preview').src = "{{ url('expense/documents') }}/"+atob(e.getAttribute('data-image'))
        }

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

        function datatable_sum(dt_selector, is_calling_first) {
            @if ($general_setting->type !== 'KbPeShVmYq3t6w9yBEHMcQfTjWnZ')
                if (dt_selector.rows('.selected').any() && is_calling_first) {
                    var rows = dt_selector.rows('.selected').indexes();
                    const total = dt_selector.cells(rows, 4, {
                        page: 'current'
                    }).data().sum()
                    $(dt_selector.column(4).footer()).html('Rp. '+formatRupiah(total.toString()));
                } else {
                    const total = dt_selector.cells(rows, 4, {
                        page: 'current'
                    }).data().sum()
                    $(dt_selector.column(4).footer()).html('Rp. '+formatRupiah(total.toString()));
                }
            @else
                if (dt_selector.rows('.selected').any() && is_calling_first) {
                    var rows = dt_selector.rows('.selected').indexes();
                    const total = dt_selector.cells(rows, 3, {
                        page: 'current'
                    }).data().sum()
                    $(dt_selector.column(3).footer()).html('Rp. '+formatRupiah(total.toString()));
                } else {
                    const total = dt_selector.cells(rows, 3, {
                        page: 'current'
                    }).data().sum()
                    $(dt_selector.column(3).footer()).html('Rp. '+formatRupiah(total.toString()));
                }
            @endif
        }

        if (all_permission.indexOf("expenses-delete") == -1)
            $('.buttons-delete').addClass('d-none');
    </script>
@endpush
