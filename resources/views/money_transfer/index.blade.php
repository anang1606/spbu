@extends('layout.main') @section('content')
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif

<section>
    <div class="container-fluid">
        <button class="btn btn-info" data-toggle="modal" data-target="#create-money-transfer-modal"><i class="dripicons-plus"></i> {{trans('file.Add Money Transfer')}}</button>
    </div>
    <div class="table-responsive">
        <table id="money-transfer-table" class="table">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.Date')}}</th>
                    <th>{{trans('file.Reference No')}}</th>
                    <th>{{trans('file.From Account')}}</th>
                    <th>{{trans('file.To Account')}}</th>
                    <th>{{trans('file.Amount')}}</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lims_money_transfer_all as $key=>$money_transfer)
                <tr data-id="{{$money_transfer->id}}">
                    <td>{{$key}}</td>
                    <td>{{date($general_setting->date_format, strtotime($money_transfer->created_at->toDateString())) . ' '. $money_transfer->created_at->toTimeString() }}</td>
                    <td>{{ $money_transfer->reference_no }}</td>
                    <td>{{ $money_transfer->fromAccount->name }}</td>
                    <td>{{ $money_transfer->toAccount->name }}</td>
                    <td>{{ $money_transfer->amount }}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                <li><button type="button" id="edit-btn" data-id="{{$money_transfer->id}}" data-from_id="{{$money_transfer->from_account_id}}" data-to_id="{{$money_transfer->to_account_id}}" data-amount="{{$money_transfer->amount}}" class="edit-btn btn btn-link" data-toggle="modal" data-target="#edit-money-transfer-modal"><i class="dripicons-document-edit"></i> {{trans('file.edit')}}</button></li>
                                <li class="divider"></li>
                                {{ Form::open(['route' => ['money-transfers.destroy', $money_transfer->id], 'method' => 'DELETE'] ) }}
                                <li>
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="dripicons-trash"></i> {{trans('file.delete')}}</button>
                                </li>
                                {{ Form::close() }}
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="tfoot active">
                <th></th>
                <th>{{trans('file.Total')}}</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tfoot>
        </table>
    </div>
</section>

<!-- Create Money Transfer modal -->
<div id="create-money-transfer-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Add Money Transfer')}}</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
            </div>
            <div class="modal-body">
              <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                {!! Form::open(['route' => 'money-transfers.store', 'method' => 'post']) !!}
                  <div class="row">
                      <div class="col-md-6 form-group">
                          <label> {{trans('file.From Account')}} *</label>
                          <select class="form-control selectpicker" name="from_account_id" data-live-search="true" data-live-search-style="begins" title="Select from account..." required>
                          @foreach($lims_account_list as $account)
                              <option value="{{$account->id}}">{{$account->name}} [{{$account->account_no}}]</option>
                          @endforeach
                          </select>
                      </div>
                      <div class="col-md-6 form-group">
                          <label> {{trans('file.To Account')}} *</label>
                          <select class="form-control selectpicker" name="to_account_id" data-live-search="true" data-live-search-style="begins" title="Select to account..." required>
                          @foreach($lims_account_list as $account)
                              <option value="{{$account->id}}">{{$account->name}} [{{$account->account_no}}]</option>
                          @endforeach
                          </select>
                      </div>

                      <div class="col-md-6 form-group">
                          <label>{{trans('file.Amount')}} *</label>
                          <input type="text" name="amount" class="form-control format-rupiah" step="any" required>
                      </div>
                  </div>
                  <div class="form-group">
                      <button type="submit" class="btn btn-primary">{{trans('file.submit')}}</button>
                  </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

<!-- Edit Money Transfer modal -->
<div id="edit-money-transfer-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Update Money Transfer')}}</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
            </div>
            <div class="modal-body">
                <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                {!! Form::open(['route' => ['money-transfers.update', 1], 'method' => 'put']) !!}
                  <div class="row">
                        <input type="hidden" name="id">
                      <div class="col-md-6 form-group">
                          <label> {{trans('file.From Account')}} *</label>
                          <select class="form-control selectpicker" name="from_account_id" data-live-search="true" data-live-search-style="begins" title="Select from account..." required>
                          @foreach($lims_account_list as $account)
                              <option value="{{$account->id}}">{{$account->name}} [{{$account->account_no}}]</option>
                          @endforeach
                          </select>
                      </div>
                      <div class="col-md-6 form-group">
                          <label> {{trans('file.To Account')}} *</label>
                          <select class="form-control selectpicker" name="to_account_id" data-live-search="true" data-live-search-style="begins" title="Select to account..." required>
                          @foreach($lims_account_list as $account)
                              <option value="{{$account->id}}">{{$account->name}} [{{$account->account_no}}]</option>
                          @endforeach
                          </select>
                      </div>

                      <div class="col-md-6 form-group">
                          <label>{{trans('file.Amount')}} *</label>
                          <input type="text" name="amount" id="edit-amount" class="form-control format-rupiah" step="any" required>
                      </div>
                  </div>
                  <div class="form-group">
                      <button type="submit" class="btn btn-primary">{{trans('file.submit')}}</button>
                  </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>



@endsection

@push('scripts')
<script type="text/javascript">

    $("ul#account").siblings('a').attr('aria-expanded','true');
    $("ul#account").addClass("show");
    $("ul#account #money-transfer-menu").addClass("active");

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

    var money_transfer_id = [];
    var user_verified = <?php echo json_encode(env('USER_VERIFIED')) ?>;


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click','.edit-btn',function(e){
        $("#edit-money-transfer-modal select[name='from_account_id']").val($(this).data('from_id'));
            $("#edit-money-transfer-modal select[name='to_account_id']").val($(this).data('to_id'));
            $("#edit-money-transfer-modal input[name='id']").val($(this).data('id'));
            $("#edit-money-transfer-modal #edit-amount").val(formatRupiah($(this).data('amount').toString()));
            $('.selectpicker').selectpicker('refresh');
    })

    function confirmDelete() {
        if (confirm("Are you sure want to delete?")) {
            return true;
        }
        return false;
    }

    $(document).on('input','.format-rupiah',function(e){
        $(this).val(formatRupiah($(this).val().toString()))
    })

    $('#money-transfer-table').DataTable( {
        "order": [],
        'language': {
            'lengthMenu': '_MENU_ {{trans("file.records per page")}}',
             "info":      '<small>{{trans("file.Showing")}} _START_ - _END_ (_TOTAL_)</small>',
            "search":  '{{trans("file.Search")}}',
            'paginate': {
                    'previous': '<i class="dripicons-chevron-left"></i>',
                    'next': '<i class="dripicons-chevron-right"></i>'
            }
        },
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 6]
            },
            {
                'render': function(data, type, row, meta){
                    if(type === 'display'){
                        data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
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
                'render': function(data, type, row, meta){
                    return 'Rp. '+formatRupiah((data !== null) ? data.toString() : '0')
                },
                'targets': [5]
            }
        ],
        'select': { style: 'multi',  selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: '<"row"lfB>rtip',
        buttons: [
            {
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
                footer:true
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
                footer:true
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
                footer:true
            },
            {
                text: '<i title="delete" class="dripicons-cross"></i>',
                className: 'buttons-delete',
                action: function ( e, dt, node, config ) {
                    if(user_verified == '1') {
                        money_transfer_id.length = 0;
                        $(':checkbox:checked').each(function(i){
                            if(i){
                                money_transfer_id[i-1] = $(this).closest('tr').data('id');
                            }
                        });
                        if(money_transfer_id.length && confirm("Are you sure want to delete?")) {
                            $.ajax({
                                type:'POST',
                                url:'money_transfers/deletebyselection',
                                data:{
                                    money_transferIdArray: money_transfer_id
                                },
                                success:function(data){
                                    alert(data);
                                }
                            });
                            dt.rows({ page: 'current', selected: true }).remove().draw(false);
                        }
                        else if(!money_transfer_id.length)
                            alert('No money_transfer is selected!');
                    }
                    else
                        alert('This feature is disable for demo!');
                }
            },
            {
                extend: 'colvis',
                text: '<i title="column visibility" class="fa fa-eye"></i>',
                columns: ':gt(0)'
            },
        ],
        drawCallback: function () {
            var api = this.api();
            datatable_sum(api, false);
        }
    } );

    function datatable_sum(dt_selector, is_calling_first) {
        if (dt_selector.rows( '.selected' ).any() && is_calling_first) {
            var rows = dt_selector.rows( '.selected' ).indexes();
            $( dt_selector.column( 5 ).footer() ).html('Rp. '+formatRupiah(dt_selector.cells( rows, 5, { page: 'current' } ).data().sum().toFixed(0).toString()));
        }
        else {
            $( dt_selector.column( 5 ).footer() ).html('Rp. '+formatRupiah(dt_selector.cells( rows, 5, { page: 'current' } ).data().sum().toFixed(0).toString()));
        }
    }

    /*if(all_permission.indexOf("money_transfers-delete") == -1)
        $('.buttons-delete').addClass('d-none');*/

</script>
@endpush
