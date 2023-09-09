@extends('layout.main') @section('content')
    @if (session()->has('create_message'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ session()->get('create_message') }}</div>
    @endif
    @if (session()->has('edit_message'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ session()->get('edit_message') }}</div>
    @endif
    @if (session()->has('import_message'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ session()->get('import_message') }}</div>
    @endif
    @if (session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
    @endif
    @if (session()->has('message'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
    @endif

    <section>
        <div class="container-fluid">
            @if (in_array('products-add', $all_permission))
                <a href="{{ route('products.create') }}" class="btn btn-info"><i class="dripicons-plus"></i>
                    {{ __('file.add_product') }}
                </a>
                    {{--  <a href="#" data-toggle="modal" data-target="#importProduct" class="btn btn-primary"><i
                        class="dripicons-copy"></i> {{ __('file.import_product') }}</a>  --}}
            @endif
        </div>
        <div class="table-responsive">
            <table id="product-data-table" class="table" style="width: 100%">
                <thead>
                    <tr>
                        <th class="not-exported"></th>
                        <th>{{ trans('file.Code') }}</th>
                        <th>Nama</th>
                        <th>{{ trans('file.Quantity') }}</th>
                        <th>{{ trans('file.Unit') }}</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        @if ($general_setting->type !== 'KbPeShVmYq3t6w9yBEHMcQfTjWnZ')
                            <th>{{ trans('file.Stock Worth (Price/Cost)') }}</th>
                        @endif
                        <th class="not-exported">{{ trans('file.action') }}</th>
                    </tr>
                </thead>

            </table>
        </div>
    </section>

    <div id="importProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['route' => 'product.import', 'method' => 'post', 'files' => true]) !!}
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">Import Product</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                            aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                    <p class="italic">
                        <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                    </p>
                    <p>{{ trans('file.The correct column order is') }} (image, name*, code*, type*, brand, category*,
                        unit_code*, cost*, price*, product_details, variant_name, item_code, additional_price)
                        {{ trans('file.and you must follow this') }}.</p>
                    <p>{{ trans('file.To display Image it must be stored in') }} public/images/product
                        {{ trans('file.directory') }}. {{ trans('file.Image name must be same as product name') }}</p>
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
                                <a href="sample_file/sample_products.csv" class="btn btn-info btn-block btn-md"><i
                                        class="dripicons-download"></i> {{ trans('file.Download') }}</a>
                            </div>
                        </div>
                    </div>
                    {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
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
        @if($ingredients)
            $("#ingredients").addClass("active");
        @else
            $("ul#product").siblings('a').attr('aria-expanded', 'true');
            $("ul#product").addClass("show");
            $("ul#product #product-list-menu").addClass("active");
        @endif

        function confirmDelete() {
            if (confirm("Are you sure want to delete?")) {
                return true;
            }
            return false;
        }

        var warehouse = [];
        var variant = [];
        var qty = [];
        var htmltext;
        var slidertext;
        var product_id = [];
        var all_permission = <?php echo json_encode($all_permission); ?>;
        var user_verified = <?php echo json_encode(env('USER_VERIFIED')); ?>;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#select_all").on("change", function() {
            if ($(this).is(':checked')) {
                $("tbody input[type='checkbox']").prop('checked', true);
            } else {
                $("tbody input[type='checkbox']").prop('checked', false);
            }
        });

        $(document).ready(function() {
            var table = $('#product-data-table').DataTable({
                responsive: true,
                fixedHeader: {
                    header: true,
                    footer: true
                },
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: "products/product-data",
                    data: {
                        status: '{{ $ingredients }}',
                        all_permission: all_permission
                    },
                    dataType: "json",
                    type: "post"
                },
                "createdRow": function(row, data, dataIndex) {
                    $(row).addClass('product-link');
                    $(row).attr('data-product', data['product']);
                    $(row).attr('data-imagedata', data['imagedata']);
                },
                "columns": [{
                        "data": "key"
                    },
                    {
                        "data": "code"
                    },
                    {
                        "data": "name"
                    },
                    {
                        "data": "qty"
                    },
                    {
                        "data": "unit"
                    },
                    {
                        "data": "cost",
                        render: function(data) {
                            return 'Rp. '+formatRupiah(data.toString())
                        }
                    },
                    {
                        "data": "price",
                        render: function(data) {
                            return 'Rp. '+formatRupiah(data.toString())
                        }
                    },
                    {
                        "data": "options"
                    },
                ],
                'language': {
                    /*'searchPlaceholder': "{{ trans('file.Type Product Name or Code...') }}",*/
                    'lengthMenu': '_MENU_ {{ trans('file.records per page') }}',
                    "info": '<small>{{ trans('file.Showing') }} _START_ - _END_ (_TOTAL_)</small>',
                    "search": '{{ trans('file.Search') }}',
                    'paginate': {
                        'previous': '<i class="dripicons-chevron-left"></i>',
                        'next': '<i class="dripicons-chevron-right"></i>'
                    }
                },
                order: [
                    ['2', 'asc']
                ],
                'columnDefs': [{
                        "orderable": false,
                        'targets': [0]
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

        });

        if (all_permission.indexOf("products-delete") == -1)
            $('.buttons-delete').addClass('d-none');

        $('select').selectpicker();
    </script>
@endpush
