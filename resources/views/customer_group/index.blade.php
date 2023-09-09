@extends('layout.main')
@section('content')
    @if ($errors->has('name'))
        <div class="alert alert-danger alert-dismissible text-center">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ $errors->first('name') }}
        </div>
    @endif
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
    @endif
    @if (session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
    @endif

    <section>
        <div class="container-fluid">
            <a href="#" data-toggle="modal" data-target="#createModal" class="btn btn-info"><i
                    class="dripicons-plus"></i> Tambah Data Perusahaan</a>
        </div>
        <div class="table-responsive">
            <table id="customer-grp-table" class="table">
                <thead>
                    <tr>
                        <th class="not-exported" style="width: 30px">
                            No.
                        </th>
                        <th>Nama</th>
                        <th class="not-exported">{{ trans('file.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lims_customer_group_all as $key => $customer_group)
                        <tr>
                            <td style="width: 30px">{{ $key + 1 }}</td>
                            <td>{{ $customer_group->name }}</td>
                            <td style="width: 30%;">
                                <div class="d-flex" style="width: 50%">
                                    <button type="button" data-id="{{ $customer_group->id }}"
                                        class="open-EditCustomerGroupDialog btn btn-outline-info mr-2" data-toggle="modal"
                                        data-target="#editModal"><i class="dripicons-document-edit"></i>
                                        {{ trans('file.edit') }}
                                    </button>
                                    <button type="button" data-id="{{ $customer_group->id }}"
                                        data-title="{{ $customer_group->name }}"
                                        data-get="{{ base64_encode(json_encode($customer_group->details)) }}"
                                        class="open-DetailsCustomerGroupDialog btn btn-outline-warning mr-2" data-toggle="modal"
                                        data-target="#viewModal"><i class="fa fa-eye"></i>
                                        Views
                                    </button>
                                    {{ Form::open(['route' => ['customer_group.destroy', $customer_group->id], 'method' => 'DELETE']) }}
                                    <button type="submit" class="btn btn-outline-danger mr-2" onclick="return confirmDelete()"><i
                                            class="dripicons-trash"></i> Hapus</button>
                                    {{ Form::close() }}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <div id="viewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title"></h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                            aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table" id="customer-grp-details">
                                    <thead>
                                        <tr>
                                            <th>Nama Produk</th>
                                            <th>Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['route' => 'customer_group.store', 'method' => 'post']) !!}
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">Tambah data perusahaan</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                            aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                    <p class="italic">
                        <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                    </p>
                    <form>
                        <div class="form-group">
                            <label>Nama *</label>
                            <input type="text" name="name" required="required" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Produk *</label>
                            <select class="form-control" name="products[]" multiple="multiple">
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="{{ trans('file.submit') }}" class="btn btn-primary">
                        </div>
                    </form>
                </div>

                {{ Form::close() }}
            </div>
        </div>
    </div>

    <div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['route' => ['customer_group.update', 1], 'method' => 'put']) !!}
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">Update data perusahaan</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                            aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                    <p class="italic">
                        <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                    </p>
                    <div class="form-group">
                        <input type="hidden" name="customer_group_id">
                        <label>{{ trans('file.name') }} *</label>
                        <input type="text" name="name" required="required" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Produk *</label>
                        <select class="form-control" name="products[]" multiple="multiple">
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="{{ trans('file.submit') }}" class="btn btn-primary">
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $("ul#people").siblings('a').attr('aria-expanded', 'true');
        $("ul#people").addClass("show");
        $("ul#people #customer-group-menu").addClass("active");

        var customer_group_id = [];
        var user_verified = <?php echo json_encode(env('USER_VERIFIED')); ?>;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function confirmDelete() {
            if (confirm("Anda yakin ingin menghapus??")) {
                return true;
            }
            return false;
        };
        $(document).ready(function() {

            $(document).on('click', '.open-EditCustomerGroupDialog', function() {
                var url = "customer_group/"
                var id = $(this).data('id').toString();
                url = url.concat(id).concat("/edit");

                $.get(url, function(data) {
                    // console.log(data)
                    $("input[name='name']").val(data['name']);
                    const selectedProducts = data['products'];

                    $("select[name='products[]']").selectpicker("val", selectedProducts);
                    $("input[name='customer_group_id']").val(data['id']);
                });
            });
            $(document).on('click', '.open-DetailsCustomerGroupDialog', function() {
                const elem = $(this)
                const data = JSON.parse(atob(elem.data('get')))

                $('#viewModal #exampleModalLabel').text('Details Perusahaan ' + elem.data('title'))
                $('#customer-grp-details tbody').html('')
                data.map((datas, index) => {
                    const newRow = `
                        <tr>
                            <td>${datas.product.name}</td>
                            <td>${datas.stock}</td>
                        </tr>
                    `;
                    $('#customer-grp-details tbody').append(newRow);
                })
            });
        });

        $('#customer-grp-table').DataTable({
            order: [
                [0, 'asc']
            ]
        });
    </script>
@endpush
