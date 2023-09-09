@extends('layout.main') @section('content')
    @if (session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert"
                aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
    @endif
    <section class="forms">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4>{{ trans('file.Update Customer') }}</h4>
                        </div>
                        <div class="card-body">
                            <p class="italic">
                                <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                            </p>
                            {!! Form::open(['route' => ['customer.update', $lims_customer_data->id], 'method' => 'put', 'files' => true]) !!}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>
                                            Perusahaan *
                                        </label>
                                        <select class="form-control" name="customer_group_id" id="customer_group_id"
                                            required>
                                            @foreach ($lims_customer_group_all as $lcp)
                                                <option {{-- {{ (int)$lcp->id === (int)$lims_customer_data->customer_group_id ? 'selected' : '' }} --}} value="{{ $lcp->id }}">
                                                    {{ $lcp->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
                                        <label>Produk *</strong> </label>
                                        <select name="product_id" id="product_id" class="form-control">
                                            <option value="" disabled selected>
                                                Silahkan pilih perusahaan dahulu
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
                                        <label>Plat Nomor *</strong> </label>
                                        <input type="text" name="customer_name" value="{{ $lims_customer_data->name }}"
                                            required class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
                                        <label>{{ trans('file.Phone Number') }} *</label>
                                        <input type="text" name="phone_number" required
                                            value="{{ $lims_customer_data->phone_number }}" class="form-control">
                                        @if ($errors->has('phone_number'))
                                            <span>
                                                <strong>{{ $errors->first('phone_number') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
                                        <label>{{ trans('file.City') }} *</label>
                                        <input type="text" name="city" required
                                            value="{{ $lims_customer_data->city }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
                                        <label>{{ trans('file.State') }}</label>
                                        <input type="text" name="state" value="{{ $lims_customer_data->state }}"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
                                        <label>{{ trans('file.Postal Code') }}</label>
                                        <input type="text" name="postal_code"
                                            value="{{ $lims_customer_data->postal_code }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="form-group">
                                        <label>{{ trans('file.Address') }} *</label>
                                        <textarea name="address" rows="4" required class="form-control">{{ $lims_customer_data->address }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mt-3">
                                        <input type="submit" value="{{ trans('file.submit') }}" class="btn btn-primary">
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script type="text/javascript">
        $("ul#people").siblings('a').attr('aria-expanded', 'true');
        $("ul#people").addClass("show");

        $(".user-input").hide();

        $('input[name="user"]').on('change', function() {
            if ($(this).is(':checked')) {
                $('.user-input').show(300);
                $('input[name="name"]').prop('required', true);
                $('input[name="password"]').prop('required', true);
            } else {
                $('.user-input').hide(300);
                $('input[name="name"]').prop('required', false);
                $('input[name="password"]').prop('required', false);
            }
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            const val = {{ $lims_customer_data->customer_group_id }}
            $('[name="customer_group_id"]').selectpicker('val',
                '{{ $lims_customer_data->customer_group_id }}')
            $('[name="customer_group_id"]').selectpicker("refresh")
            setTimeout(() => {
                $.ajax({
                    method: "POST",
                    url: '/customer/find-product',
                    data: {
                        _val: val
                    },
                    dataType: "json",
                    success: function(response) {
                        const result = response

                        const productId = $("select[name='product_id']")
                        $("#product_id").empty()
                        $("#product_id").selectpicker('val', '')
                        $("#product_id").selectpicker("refresh")
                        result.details.forEach(function(product) {
                            productId.append($("<option>", {
                                value: product.product.id,
                                text: product.product.name
                            }));
                        });
                        $("#product_id").selectpicker('val',
                            '{{ $lims_customer_data->product_id }}')
                        $("#product_id").selectpicker("refresh")
                    },
                    error: function(xhr, status, error) {
                        console.error("Terjadi kesalahan:", status, error);
                    }
                })
            }, 250);
        })

        $(document).on('change', '[name="customer_group_id"]', function() {
            const val = $(this).val()
            $.ajax({
                method: "POST",
                url: '/customer/find-product',
                data: {
                    _val: val
                },
                dataType: "json",
                success: function(response) {
                    const result = response

                    const productId = $("select[name='product_id']")
                    $("#product_id").selectpicker('val', '')
                    $("#product_id").empty()
                    $("#product_id").selectpicker("refresh")
                    result.details.forEach(function(product) {
                        productId.append($("<option>", {
                            value: product.product.id,
                            text: product.product.name
                        }));
                    });
                    $("#product_id").selectpicker("refresh")
                },
                error: function(xhr, status, error) {
                    console.error("Terjadi kesalahan:", status, error);
                }
            })
        })

        var customer_group = $("input[name='customer_group']").val();
        $('select[name=customer_group_id]').val(customer_group);
    </script>
@endpush
