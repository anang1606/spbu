@extends('layout.main')
@section('content')
    <section class="forms">
        <div class="container-fluid">
            {!! Form::open([
                'route' => 'adjustment-customer.store',
                'method' => 'post',
                'files' => true,
                'id' => 'adjustment-form',
            ]) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4>{{ trans('file.Add Adjustment') }}</h4>
                        </div>
                        <div class="card-body">
                            <p class="italic">
                                <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                            </p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>
                                            Perusahaan *
                                        </label>
                                        <select class="form-control" name="customer_group_id" id="customer_group_id">
                                            <option value="" disabled selected>Silahkan Pilih</option>
                                            @foreach ($lims_customer_group_all as $lcp)
                                                <option value="{{ $lcp->id }}">{{ $lcp->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <label>{{ trans('file.Select Product') }}</label>
                                    <div class="search-box input-group">
                                        <button type="button" class="btn btn-secondary btn-lg"><i
                                                class="fa fa-barcode"></i></button>
                                        <input type="text" name="product_code_name" id="lims_productcodeSearch"
                                            placeholder="Silahkan pilih perusahaan dulu..." class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-1">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4>{{ trans('file.Order Table') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive mt-3">
                                        <table id="myTable" class="table table-hover order-list">
                                            <thead>
                                                <tr>
                                                    <th>{{ trans('file.name') }}</th>
                                                    <th>Perusahaan</th>
                                                    <th>{{ trans('file.Code') }}</th>
                                                    <th>{{ trans('file.Quantity') }}</th>
                                                    <th>{{ trans('file.action') }}</th>
                                                    <th><i class="dripicons-trash"></i></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot class="tfoot active">
                                                <th colspan="2">{{ trans('file.Total') }}</th>
                                                <th id="total-qty" colspan="2">0</th>
                                                <th></th>
                                                <th><i class="dripicons-trash"></i></th>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="hidden" name="total_qty" />
                                        <input type="hidden" name="item" />
                                    </div>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <div class="form-group">
                                        <label>{{ trans('file.Note') }}</label>
                                        <textarea rows="5" class="form-control" name="note"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div class="form-group">
                                        <input type="submit" value="{{ trans('file.submit') }}" class="btn btn-primary"
                                            id="submit-button">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </section>
@endsection

@push('scripts')
    <script type="text/javascript">
        $("ul#people").siblings('a').attr('aria-expanded', 'true');
        $("ul#people").addClass("show");
        $("ul#people #adjustment-customer").addClass("active");
        var lims_product_array = []

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(window).keydown(function(e) {
            if (e.which == 13) {
                var $targ = $(e.target);
                if (!$targ.is("textarea") && !$targ.is(":button,:submit")) {
                    var focusNext = false;
                    $(this).find(":input:visible:not([disabled],[readonly]), a").each(function() {
                        if (this === e.target) {
                            focusNext = true;
                        } else if (focusNext) {
                            $(this).focus();
                            return false;
                        }
                    });
                    return false;
                }
            }
        });

        $('#adjustment-form').on('submit', function(e) {
            var rownumber = $('table.order-list tbody tr:last').index();
            if (rownumber < 0) {
                alert("Please insert product to order table!")
                e.preventDefault();
            }
        });

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
                    lims_product_array = []
                    $.each(result.details, function(index) {
                        lims_product_array.push(result.name + ' (' + result.details[index]
                            .product.name + ')' + '[' + btoa(result.details[index].product
                                .id) + ']');
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Terjadi kesalahan:", status, error);
                }
            })
        })

        var lims_productcodeSearch = $('#lims_productcodeSearch');
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

        $("#myTable").on('input', '.qty', function() {
            rowindex = $(this).closest('tr').index();
            checkQuantity($(this).val(), true);
        });

        $("table.order-list tbody").on("click", ".ibtnDel", function(event) {
            rowindex = $(this).closest('tr').index();
            $(this).closest("tr").remove();
            calculateTotal();
        });

        function productSearch(data) {
            $.ajax({
                type: 'POST',
                url: '/adjustment-customer/lims_product_search',
                data: {
                    data: data,
                    _uuid: $('[name="customer_group_id"]').val()
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
                        cols += '<td>' + data[4] + '</td>';
                        cols += '<td>' + data[1] + '</td>';
                        cols +=
                            '<td><input type="number" class="form-control qty" name="qty[]" value="1" required step="any" /></td>';
                        cols +=
                            '<td class="action"><select name="action[]" class="form-control act-val"><option value="-">{{ trans('file.Subtraction') }}</option><option value="+">{{ trans('file.Addition') }}</option></select></td>';
                        cols +=
                            '<td><button type="button" class="ibtnDel btn btn-md btn-danger">Hapus</button></td>';
                        cols += '<input type="hidden" class="product-code" name="product_code[]" value="' +
                            data[1] + '"/>';
                        cols += '<input type="hidden" class="product-id" name="product_id[]" value="' + data[
                            2] + '"/>';
                        cols += '<input type="hidden" class="group-id" name="group_id[]" value="' + data[
                            3] + '"/>';

                        newRow.append(cols);
                        $("table.order-list tbody").append(newRow);
                        rowindex = newRow.index();
                        calculateTotal()
                    }
                }
            });
        }

        function checkQuantity(qty) {
            var row_product_id = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find(
                '[name="product_id[]"]').val();
            var row_group_id = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('[name="group_id[]"]')
                .val();
            var action = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('select.act-val').val();

            $.ajax({
                type: 'POST',
                url: '/adjustment-customer/check_qty',
                data: {
                    _rpdi: row_product_id,
                    _rgpi: row_group_id
                },
                success: function(data) {
                    if ((qty > data) && (action == '-')) {
                        alert('Quantity exceeds stock quantity!');
                        var row_qty = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find(
                            '.qty').val();
                        row_qty = row_qty.substring(0, row_qty.length - 1);
                        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val(
                            row_qty);
                    } else {
                        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val(qty);
                    }
                }
            })
            calculateTotal();
        }

        function calculateTotal() {
            var total_qty = 0;
            $(".qty").each(function() {

                if ($(this).val() == '') {
                    total_qty += 0;
                } else {
                    total_qty += parseFloat($(this).val());
                }
            });
            $("#total-qty").text(formatRupiah(total_qty.toString()));
            $('input[name="total_qty"]').val(total_qty);
            $('input[name="item"]').val($('table.order-list tbody tr:last').index() + 1);
        }
    </script>
@endpush
