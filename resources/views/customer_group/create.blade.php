@extends('layout.main')
@section('content')
    <section>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Add Customer Group') }}</h5>
                        </div>
                        <div class="card-body">
                            {!! Form::open(['route' => 'customer_group.store', 'method' => 'post']) !!}
                            <div class="form-group">
                                <label>Nama *</label>
                                <input type="text" name="name" required="required" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Produk *</label>
                                <div class="search-box input-group">
                                    <input type="text" name="product_code_name" id="lims_productcodeSearch"
                                        placeholder="Please type product code and select..." class="form-control" />
                                </div>
                            </div>
                            {{ Form::close() }}
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
        $("ul#people #customer-group-menu").addClass("active");

        var lims_productcodeSearch = $('#lims_productcodeSearch');
        var lims_product_array = [];
        var product_code = [];
        var product_name = [];
        var product_qty = [];

        $(document).ready(function() {
            $.get('/qty_adjustment/getproduct/1', function(data) {
                lims_product_array = [];
                product_code = data[0];
                product_name = data[1];
                product_qty = data[2];
                $.each(product_code, function(index) {
                    lims_product_array.push(product_code[index] + ' (' + product_name[index] + ')');
                });
            });
        });

        lims_productcodeSearch.autocomplete({
            source: function(request, response) {
                var matcher = new RegExp(".?" + $.ui.autocomplete.escapeRegex(request.term), "i");
                response($.grep(lims_product_array, function(item) {
                    return matcher.test(item);
                }));
            },
            response: function(event, ui) {
                if (ui.content.length == 1) {
                    var data = ui.content[0].value;
                    $(this).autocomplete("close");
                    productSearch(data);
                };
            },
            select: function(event, ui) {
                var data = ui.item.value;
                productSearch(data);
            }
        });

        function productSearch(data) {
            $.ajax({
                type: 'GET',
                url: '/qty_adjustment/lims_product_search',
                data: {
                    data: data
                },
                success: function(data) {
                    var flag = 1;
                    $(".product-code").each(function(i) {
                        if ($(this).val() == data[1]) {
                            rowindex = i;
                            var qty = parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex +
                                1) + ') .qty').val()) + 1;
                            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(
                                qty);
                            checkQuantity(qty);
                            flag = 0;
                        }
                    });
                    $("input[name='product_code_name']").val('');
                    if (flag) {
                        var newRow = $("<tr>");
                        var cols = '';
                        cols += '<td>' + data[0] + '</td>';
                        cols += '<td>' + data[1] + '</td>';
                        cols +=
                            '<td><input type="number" class="form-control qty" name="qty[]" value="1" required step="any" /></td>';
                        cols +=
                            '<td class="action"><select name="action[]" class="form-control act-val"><option value="-">{{ trans('file.Subtraction') }}</option><option value="+">{{ trans('file.Addition') }}</option></select></td>';
                        cols +=
                            '<td><button type="button" class="ibtnDel btn btn-md btn-danger">{{ trans('file.delete') }}</button></td>';
                        cols += '<input type="hidden" class="product-code" name="product_code[]" value="' +
                            data[1] + '"/>';
                        cols += '<input type="hidden" class="product-id" name="product_id[]" value="' + data[
                            2] + '"/>';

                        newRow.append(cols);
                        $("table.order-list tbody").append(newRow);
                        rowindex = newRow.index();
                    }
                }
            });
        }
    </script>
@endpush
