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
                            <h4>{{ trans('file.Add Customer') }}</h4>
                        </div>
                        <div class="card-body">
                            <p class="italic">
                                <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                            </p>
                            {!! Form::open(['route' => 'customer.store', 'method' => 'post', 'files' => true]) !!}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>
                                            Perusahaan *
                                        </label>
                                        <select class="form-control" name="customer_group_id" id="customer_group_id" required>
                                            <option value="" disabled selected>Silahkan Pilih</option>
                                            @foreach ($lims_customer_group_all as $lcp)
                                                <option value="{{ $lcp->id }}">{{ $lcp->name }}</option>
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
                                        <input type="text" name="customer_name" required class="form-control">
                                    </div>
                                </div>
                                {{-- <div class="col-md-4 mt-2">
                                <div class="form-group">
                                    <label>{{trans('file.Company Name')}} <span class="asterisk">*</span></label>
                                    <input type="text" name="company_name" class="form-control">
                                    @if ($errors->has('company_name'))
                                   <span>
                                       <strong>{{ $errors->first('company_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div> --}}
                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
                                        <label>{{ trans('file.Phone Number') }} *</label>
                                        <input type="text" name="phone_number" required class="form-control">
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
                                        <input type="text" name="city" required class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
                                        <label>{{ trans('file.State') }}</label>
                                        <input type="text" name="state" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
                                        <label>{{ trans('file.Postal Code') }}</label>
                                        <input type="text" name="postal_code" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="form-group">
                                        <label>{{ trans('file.Address') }} *</label>
                                        <textarea name="address" rows="4" required class="form-control"></textarea>
                                    </div>
                                </div>
                                {{-- <div class="col-md-4 mt-2">
                                <div class="form-group">
                                    <label>{{trans('file.Country')}}</label>
                                    <input type="text" name="country" class="form-control">
                                </div>
                            </div> --}}
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="pos" value="0">
                                <input type="submit" value="{{ trans('file.submit') }}" class="btn btn-primary">
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
        $("ul#people #customer-create-menu").addClass("active");

        $('.asterisk').hide();
        $(".user-input").hide();

        $('input[name="both"]').on('change', function() {
            if ($(this).is(':checked')) {
                $('.asterisk').show();
                $('input[name="company_name"]').prop('required', true);
                $('input[name="email"]').prop('required', true);
            } else {
                $('.asterisk').hide();
                $('input[name="company_name"]').prop('required', false);
                $('input[name="email"]').prop('required', false);
            }
        });

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
    </script>
@endpush
