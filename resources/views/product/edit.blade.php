@extends('layout.main')

@section('content')
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>{{trans('file.Update Product')}}</h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                        <form method="POST" action="{{ route('products.update',$lims_product_data->id) }}">
                            @csrf
                            <input type="hidden" name="id" value="{{$lims_product_data->id}}" />
                            <input type="hidden" name="type_hidden" value="{{$lims_product_data->type}}">
                            <div class="row">
                                @if($general_setting->type === 'KbPeShVmYq3t6w9yBEHMcQfTjWnZ')
                                    @if($general_setting->usaha_type === '2' || $general_setting->usaha_type === '1')
                                        <input name="type" type="hidden" value="standard" />
                                    @elseif($general_setting->usaha_type === '3')
                                        <input name="type" type="hidden" value="service" />
                                    @endif
                                @endif
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{trans('file.Product Name')}} *</strong> </label>
                                        <input type="text" name="name" value="{{$lims_product_data->name}}" required class="form-control">
                                        <span class="validation-msg" id="name-error"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{trans('file.Product Code')}} *</strong> </label>
                                        <div class="input-group">
                                            <input type="text" name="code" id="code" value="{{$lims_product_data->code}}" class="form-control" required>
                                            <div class="input-group-append">
                                                <button id="genbutton" type="button" class="btn btn-sm btn-default" title="{{trans('file.Generate')}}"><i class="fa fa-refresh"></i></button>
                                            </div>
                                        </div>
                                        <span class="validation-msg" id="code-error"></span>
                                    </div>
                                </div>
                                <div id="unit" class="col-md-4">
                                    <div class="row ">
                                        <div class="col-md-12">
                                                <label>{{trans('file.Product Unit')}} *</strong> </label>
                                                <div class="input-group">
                                                  <select required class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title="Select unit..." name="unit_id">
                                                    @foreach($lims_unit_list as $unit)
                                                        @if($unit->base_unit==null)
                                                            <option {{ ($lims_product_data->unit_id === $unit->id) ? 'selected' : '' }} value="{{$unit->id}}">{{$unit->unit_name}}</option>
                                                        @endif
                                                    @endforeach
                                                  </select>
                                                  <input type="hidden" name="unit" value="{{ $lims_product_data->unit_id}}">
                                              </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="cost" class="col-md-4">
                                    <div class="form-group">
                                        <label>{{trans('file.Product Cost')}} *</strong> </label>
                                        <input type="text" name="cost" value="{{number_format($lims_product_data->cost,0,'.','.')}}" required class="form-control format-rupiah" step="any">
                                        <span class="validation-msg"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{trans('file.Product Price')}} *</strong> </label>
                                        <input type="text" name="price" value="{{number_format($lims_product_data->price,0,'.','.')}}" required class="form-control format-rupiah" step="any">
                                        <span class="validation-msg"></span>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="qty" value="{{ $lims_product_data->qty }}" class="form-control">
                                    </div>
                                </div>
                                <div id="alert-qty" class="col-md-4">
                                    <div class="form-group">
                                        <label>{{trans('file.Alert Quantity')}}</strong> </label>
                                        <input type="number" name="alert_quantity" value="{{$lims_product_data->alert_quantity}}" class="form-control" step="any">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <a href="{{ route('products.index') }}" class="btn btn-success" type="button">
                                            Kembali
                                        </a>
                                        <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary" id="submit-btn">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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

    const inputFormat = document.querySelectorAll('.format-rupiah')
    if(inputFormat.length > 0){
        inputFormat.forEach((input) => {
            input.addEventListener('keyup',(e) => {
                e.target.value = formatRupiah(e.target.value.toString())
            })
        })
    }

    $('[data-toggle="tooltip"]').tooltip();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#genbutton').on("click", function(){
      $.get('../gencode', function(data){
        $("input[name='code']").val(data);
      });
    });

</script>
@endpush
