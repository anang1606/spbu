@extends('layout.main') @section('content')
    @if (session()->has('create_message'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{!! session()->get('create_message') !!}
        </div>
    @endif
    @if (session()->has('edit_message'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ session()->get('edit_message') }}</div>
    @endif
    @if (session()->has('import_message'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{!! session()->get('import_message') !!}</div>
    @endif
    @if (session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
    @endif

    <section>
        <div class="container-fluid">
            @if (in_array('customers-add', $all_permission))
                <a href="{{ route('customer.create') }}" class="btn btn-info"><i class="dripicons-plus"></i>
                    {{ trans('file.Add Customer') }}</a>&nbsp;
                <a href="customer/generate-qr" class="btn btn-primary">
                    <i class="dripicons-copy"></i>
                    Generate QR Code
                </a>
            @endif
        </div>
        <div class="table-responsive">
            <table id="customer-table" class="table">
                <thead>
                    <tr>
                        <th class="not-exported"></th>
                        <th>Plat Nomor</th>
                        <th>No. Hp</th>
                        <th>Perusahaan</th>
                        <th>Produk</th>
                        <th>Alamat</th>
                        <th class="not-exported">{{ trans('file.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lims_customer_all as $key => $customer)
                        <?php
                        $saleData = App\Sale::where([['customer_id', $customer->id], ['payment_status', '!=', 4]])
                            ->selectRaw('SUM(grand_total) as grand_total,SUM(paid_amount) as paid_amount')
                            ->first();
                        ?>
                        <tr data-id="{{ $customer->id }}">
                            <td>{{ $key }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->phone_number }}</td>
                            <td>{{ $customer->customerGroup->name }}</td>
                            <td>{{ $customer->product->name }}</td>
                            <td>{{ $customer->address }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">{{ trans('file.action') }}
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                        user="menu">
                                        @if (in_array('customers-edit', $all_permission))
                                            <li>
                                                <a href="{{ route('customer.edit', $customer->id) }}"
                                                    class="btn btn-link"><i class="dripicons-document-edit"></i>
                                                    {{ trans('file.edit') }}</a>
                                            </li>
                                        @endif
                                        <li class="divider"></li>
                                        @if (in_array('customers-delete', $all_permission))
                                            {{ Form::open(['route' => ['customer.destroy', $customer->id], 'method' => 'DELETE']) }}
                                            <li>
                                                <button type="submit" class="btn btn-link"
                                                    onclick="return confirmDelete()"><i class="dripicons-trash"></i>
                                                    {{ trans('file.delete') }}</button>
                                            </li>
                                            {{ Form::close() }}
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <div id="importCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['route' => 'customer.import', 'method' => 'post', 'files' => true]) !!}
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Import Customer') }}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                            aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                    <p class="italic">
                        <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                    </p>
                    <p>{{ trans('file.The correct column order is') }} (customer_group*, name*, company_name, email,
                        phone_number*, address*, city*, state, postal_code, country)
                        {{ trans('file.and you must follow this') }}.</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('file.Upload CSV File') }} *</label>
                                {{ Form::file('file', ['class' => 'form-control', 'required']) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label> {{ trans('file.Sample File') }}</label>
                                <a href="public/sample_file/sample_customer.csv" class="btn btn-info btn-block btn-md"><i
                                        class="dripicons-download"></i> {{ trans('file.Download') }}</a>
                            </div>
                        </div>
                    </div>
                    <input type="submit" value="{{ trans('file.submit') }}" class="btn btn-primary"
                        id="submit-button">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div id="clearDueModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['route' => 'customer.clearDue', 'method' => 'post']) !!}
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Clear Due') }}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                            aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                    <p class="italic">
                        <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                    </p>
                    <div class="form-group">
                        <input type="hidden" name="customer_id">
                        <label>{{ trans('file.Amount') }} *</label>
                        <input type="number" name="amount" step="any" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('file.Note') }}</label>
                        <textarea name="note" rows="4" class="form-control"></textarea>
                    </div>
                    <input type="submit" value="{{ trans('file.submit') }}" class="btn btn-primary"
                        id="submit-button">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div id="depositModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['route' => 'customer.addDeposit', 'method' => 'post']) !!}
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Add Deposit') }}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                            aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                    <p class="italic">
                        <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                    </p>
                    <div class="form-group">
                        <input type="hidden" name="customer_id">
                        <label>{{ trans('file.Amount') }} *</label>
                        <input type="number" name="amount" step="any" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('file.Note') }}</label>
                        <textarea name="note" rows="4" class="form-control"></textarea>
                    </div>
                    <input type="submit" value="{{ trans('file.submit') }}" class="btn btn-primary"
                        id="submit-button">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div id="view-deposit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.All Deposit') }}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                            aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover deposit-list">
                        <thead>
                            <tr>
                                <th>{{ trans('file.date') }}</th>
                                <th>{{ trans('file.Amount') }}</th>
                                <th>{{ trans('file.Note') }}</th>
                                <th>{{ trans('file.Created By') }}</th>
                                <th>{{ trans('file.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="edit-deposit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Update Deposit') }}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                            aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => 'customer.updateDeposit', 'method' => 'post']) !!}
                    <div class="form-group">
                        <label>{{ trans('file.Amount') }} *</label>
                        <input type="number" name="amount" step="any" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('file.Note') }}</label>
                        <textarea name="note" rows="4" class="form-control"></textarea>
                    </div>
                    <input type="hidden" name="deposit_id">
                    <button type="submit" class="btn btn-primary">{{ trans('file.update') }}</button>
                    {{ Form::close() }}
                </div>
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
        $("ul#people").siblings('a').attr('aria-expanded', 'true');
        $("ul#people").addClass("show");
        $("ul#people #customer-list-menu").addClass("active");

        function confirmDelete() {
            if (confirm("Are you sure want to delete?")) {
                return true;
            }
            return false;
        }

        var customer_id = [];
        var user_verified = <?php echo json_encode(env('USER_VERIFIED')); ?>;
        var all_permission = <?php echo json_encode($all_permission); ?>;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#customer-table').DataTable({
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
                    'targets': [0, 6]
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
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        if (all_permission.indexOf("customers-delete") == -1)
            $('.buttons-delete').addClass('d-none');
    </script>
@endpush
