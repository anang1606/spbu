@extends('layout.main')
@section('content')
    @if (session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert"
                aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
    @endif
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
    @endif
    @php
        $color = '#0a0046';
        $color_rgba = 'rgba(10,0,70, 0.8)';
    @endphp
    <style>
        .date-btn {
            background-color: #447de7;
            border-color: #447de7;
        }

        .date-btn.active,
        .date-btn:hover {
            border-color: #2264dc !important;
            background-color: #2264dc !important;
        }

        .count-title {
            justify-content: flex-start !important;
        }

        .count-title .icon {
            margin-left: 3.4rem;
        }
    </style>
    @php
        function indo_month($month)
        {
            $indo_month = [
                'January' => 'Januari',
                'February' => 'Februari',
                'March' => 'Maret',
                'April' => 'April',
                'May' => 'Mei',
                'June' => 'Juni',
                'July' => 'Juli',
                'August' => 'Agustus',
                'September' => 'September',
                'October' => 'Oktober',
                'November' => 'November',
                'December' => 'Desember',
            ];
            return $indo_month[$month];
        }
    @endphp
    <div class="row">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="brand-text float-left mt-4">
                    <h3>{{ trans('file.welcome') }} <span>{{ Auth::user()->name }}</span> </h3>
                </div>
                @if (in_array('revenue_profit_summary', $all_permission))
                    <div class="filter-toggle btn-group">
                        <button class="btn btn-secondary date-btn" data-start_date="{{ date('Y-m-d') }}"
                            data-end_date="{{ date('Y-m-d') }}">{{ trans('file.Today') }}</button>
                        <button class="btn btn-secondary date-btn"
                            data-start_date="{{ date('Y-m-d', strtotime(' -7 day')) }}"
                            data-end_date="{{ date('Y-m-d') }}">{{ trans('file.Last 7 Days') }}</button>
                        <button class="btn btn-secondary date-btn active"
                            data-start_date="{{ date('Y') . '-' . date('m') . '-' . '01' }}"
                            data-end_date="{{ date('Y-m-d') }}">{{ trans('file.This Month') }}</button>
                        <button class="btn btn-secondary date-btn" data-start_date="{{ date('Y') . '-01' . '-01' }}"
                            data-end_date="{{ date('Y') . '-12' . '-31' }}">{{ trans('file.This Year') }}</button>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Counts Section -->
    <section class="dashboard-counts">
        <div class="container-fluid">
            <div class="row">
                @if (in_array('revenue_profit_summary', $all_permission))
                    <div class="col-md-12 form-group">
                        <div class="row">
                            <!-- Count item widget-->
                            <div class="col-sm-3">
                                <div class="wrapper count-title">
                                    <div class="icon"><i class="dripicons-cart" style="color: #2264dc"></i></div>
                                    <div>
                                        <div class="count-number revenue-data">
                                            {{ number_format((float) $sale, 0, '.', '.') }}</div>
                                        <div class="name"><strong style="color: #2264dc">Penjualan</strong></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="wrapper count-title">
                                    <div class="icon"><i class="dripicons-card" style="color: #01b4d2;"></i></div>
                                    <div>
                                        <div class="count-number pembelian">
                                            {{ number_format((float) $dash_purchase, 0, '.', '.') }}</div>
                                        <div class="name"><strong style="color: #01b4d2">Pembelian</strong></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="wrapper count-title">
                                    <div class="icon"><i class="dripicons-wallet" style="color: #0a0046;"></i></div>
                                    <div>
                                        <div class="count-number expense">
                                            {{ number_format((float) $dash_expense, 0, '.', '.') }}</div>
                                        <div class="name"><strong style="color: #0a0046">Pengeluaran</strong></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="wrapper count-title">
                                    <div class="icon"><i class="dripicons-trophy" style="color: #00c689"></i></div>
                                    <div>
                                        <div class="count-number profit-data">
                                            {{ number_format((float) $dash_profit, 0, '.', '.') }}</div>
                                        <div class="name"><strong
                                                style="color: #00c689">{{ trans('file.profit') }}</strong></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if (in_array('cash_flow', $all_permission))
                    <div class="col-md-12 mt-4">
                        <div class="card line-chart-example">
                            <div class="card-header d-flex align-items-center">
                                <h4>Infografis</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="cashFlow" data-color="{{ $color }}"
                                    data-color_rgba="{{ $color_rgba }}"
                                    data-recieved="{{ json_encode($payment_recieved) }}"
                                    @if ($general_setting->usaha_type === '2' && $general_setting->type === 'KbPeShVmYq3t6w9yBEHMcQfTjWnZ') data-purchase="{{ json_encode($payment_purchase) }}"
                                        data-label3="Pembelian" @endif
                                    data-sent="{{ json_encode($payment_sent) }}" data-month="{{ json_encode($month) }}"
                                    data-label1="{{ trans('file.Payment Recieved') }}"
                                    data-laba="{{ json_encode($yearly_laba_amount) }}" data-label4="Laba"
                                    data-label2="{{ trans('file.Payment Sent') }}">
                                </canvas>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                @if (in_array('yearly_report', $all_permission))
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <h4>{{ trans('file.yearly report') }}</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="saleChart" data-color="{{ $color }}"
                                    data-color_rgba="{{ $color_rgba }}"
                                    data-recieved="{{ json_encode($payment_recieved) }}"
                                    @if ($general_setting->usaha_type === '2' && $general_setting->type === 'KbPeShVmYq3t6w9yBEHMcQfTjWnZ') data-purchase="{{ json_encode($payment_purchase) }}"
                                        data-label3="Pembelian" @endif
                                    data-sent="{{ json_encode($payment_sent) }}" data-month="{{ json_encode($month) }}"
                                    data-label1="{{ trans('file.Payment Recieved') }}"
                                    data-laba="{{ json_encode($yearly_laba_amount) }}" data-label4="Laba"
                                    data-label2="{{ trans('file.Payment Sent') }}">
                                </canvas>
                            </div>
                        </div>
                    </div>
                @endif
                @if (in_array('monthly_summary', $all_permission))
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Laporan Bulanan {{ indo_month(date('F')) }}</h4>
                            </div>
                            <div class="pie-chart mb-2">
                                <canvas id="transactionChart" data-color="{{ $color }}"
                                    data-color_rgba="{{ $color_rgba }}" data-revenue={{ $sale }}
                                    data-expense={{ $dash_expense }}
                                    @if ($general_setting->usaha_type === '2' && $general_setting->type === 'KbPeShVmYq3t6w9yBEHMcQfTjWnZ') data-purchase={{ $dash_purchase }}
                                        data-label1="{{ trans('file.Purchase') }}" @endif
                                    data-label2="Penjualan" data-label3="{{ trans('file.Expense') }}" width="100"
                                    height="95"> </canvas>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>{{ trans('file.Recent Transaction') }}</h4>
                            <div class="right-column">
                                <div class="badge badge-primary">5 Terbaru</div>
                            </div>
                        </div>
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="#sale-latest" role="tab"
                                    data-toggle="tab">{{ trans('file.Sale') }}</a>
                            </li>
                            @if ($general_setting->usaha_type === '2' && $general_setting->type === 'KbPeShVmYq3t6w9yBEHMcQfTjWnZ')
                                <li class="nav-item">
                                    <a class="nav-link" href="#purchase-latest" role="tab"
                                        data-toggle="tab">{{ trans('file.Purchase') }}</a>
                                </li>
                            @endif
                            {{--  <li class="nav-item">
                                <a class="nav-link" href="#quotation-latest" role="tab"
                                    data-toggle="tab">{{ trans('file.Quotation') }}</a>
                            </li>  --}}
                            <li class="nav-item">
                                <a class="nav-link" href="#payment-latest" role="tab"
                                    data-toggle="tab">{{ trans('file.Payment') }}</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade show active" id="sale-latest">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>{{ trans('file.date') }}</th>
                                                <th>{{ trans('file.reference') }}</th>
                                                <th>{{ trans('file.customer') }}</th>
                                                <th>{{ trans('file.status') }}</th>
                                                <th>{{ trans('file.grand total') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($recent_sale as $sale)
                                                <tr>
                                                    <td>{{ date($general_setting->date_format, strtotime($sale->created_at->toDateString())) }}
                                                    </td>
                                                    <td>{{ $sale->reference_no }}</td>
                                                    <td>{{ $sale->customer->name }}</td>
                                                    @if ($sale->sale_status == 1)
                                                        <td>
                                                            <div class="badge badge-success">{{ trans('file.Completed') }}
                                                            </div>
                                                        </td>
                                                    @elseif($sale->sale_status == 2)
                                                        <td>
                                                            <div class="badge badge-danger">{{ trans('file.Pending') }}
                                                            </div>
                                                        </td>
                                                    @elseif($sale->sale_status == 3)
                                                        <td>
                                                            <div class="badge badge-warning">{{ trans('file.Draft') }}
                                                            </div>
                                                        </td>
                                                    @else
                                                        <td>
                                                            <div class="badge badge-danger">Return
                                                            </div>
                                                        </td>
                                                    @endif
                                                    <td>{{ number_format($sale->grand_total, 0, '.', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="purchase-latest">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>{{ trans('file.date') }}</th>
                                                <th>{{ trans('file.reference') }}</th>
                                                <th>{{ trans('file.Supplier') }}</th>
                                                <th>{{ trans('file.status') }}</th>
                                                <th>{{ trans('file.grand total') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($recent_purchase as $purchase)
                                                <tr>
                                                    <td>{{ date($general_setting->date_format, strtotime($purchase->created_at->toDateString())) }}
                                                    </td>
                                                    <td>{{ $purchase->reference_no }}</td>
                                                    @if ($purchase->supplier)
                                                        <td>{{ $purchase->supplier->name }}</td>
                                                    @else
                                                        <td>N/A</td>
                                                    @endif
                                                    @if ($purchase->status == 1)
                                                        <td>
                                                            <div class="badge badge-success">Recieved</div>
                                                        </td>
                                                    @elseif($purchase->status == 2)
                                                        <td>
                                                            <div class="badge badge-success">Partial</div>
                                                        </td>
                                                    @elseif($purchase->status == 3)
                                                        <td>
                                                            <div class="badge badge-danger">Pending</div>
                                                        </td>
                                                    @else
                                                        <td>
                                                            <div class="badge badge-danger">Ordered</div>
                                                        </td>
                                                    @endif
                                                    <td>{{ number_format($purchase->grand_total, 0, '.', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="payment-latest">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>{{ trans('file.date') }}</th>
                                                <th>{{ trans('file.reference') }}</th>
                                                <th>{{ trans('file.Amount') }}</th>
                                                <th>{{ trans('file.Paid By') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($recent_payment as $payment)
                                                <tr>
                                                    <td>{{ date($general_setting->date_format, strtotime($payment->created_at->toDateString())) }}
                                                    </td>
                                                    <td>{{ $payment->payment_reference }}</td>
                                                    <td>{{ number_format($payment->amount, 0, '.', '.') }}</td>
                                                    <td>{{ $payment->paying_method }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>{{ trans('file.Best Seller') . ' ' . indo_month(date('F')) }}</h4>
                            <div class="right-column">
                                <div class="badge badge-primary">5 Teratas</div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>SL No</th>
                                        <th>{{ trans('file.Product Details') }}</th>
                                        <th>{{ trans('file.qty') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($best_selling_qty as $key => $sale)
                                        <?php $images = explode(',', $sale->product_images); ?>
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><img src="{{ url('images/product', $images[0]) }}" height="25"
                                                    width="30"> {{ $sale->product_name }} [{{ $sale->product_code }}]
                                            </td>
                                            <td>{{ number_format($sale->sold_qty, 0, '.', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>{{ trans('file.Best Seller') . ' ' . date('Y') . ' (' . trans('file.qty') . ')' }}</h4>
                            <div class="right-column">
                                <div class="badge badge-primary">5 Teratas</div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>SL No</th>
                                        <th>{{ trans('file.Product Details') }}</th>
                                        <th>{{ trans('file.qty') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($yearly_best_selling_qty as $key => $sale)
                                        <?php $images = explode(',', $sale->product_images); ?>
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><img src="{{ url('images/product', $images[0]) }}" height="25"
                                                    width="30"> {{ $sale->product_name }}
                                                [{{ $sale->product_code }}]</td>
                                            <td>{{ number_format($sale->sold_qty, 0, '.', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>{{ trans('file.Best Seller') . ' ' . date('Y') . ' (' . trans('file.price') . ')' }}</h4>
                            <div class="right-column">
                                <div class="badge badge-primary">5 Teratas</div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>SL No</th>
                                        <th>{{ trans('file.Product Details') }}</th>
                                        <th>{{ trans('file.grand total') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($yearly_best_selling_price as $key => $sale)
                                        <?php $images = explode(',', $sale->product_images); ?>
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><img src="{{ url('images/product', $images[0]) }}" height="25"
                                                    width="30"> {{ $sale->product_name }}
                                                [{{ $sale->product_code }}]</td>
                                            <td>{{ number_format((float) $sale->total_price, 0, '.', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
        // Show and hide color-switcher
        $(".color-switcher .switcher-button").on('click', function() {
            $(".color-switcher").toggleClass("show-color-switcher", "hide-color-switcher", 300);
        });

        // Color Skins
        $('a.color').on('click', function() {
            /*var title = $(this).attr('title');
            $('#style-colors').attr('href', 'css/skin-' + title + '.css');
            return false;*/
            $.get('setting/general_setting/change-theme/' + $(this).data('color'), function(data) {});
            var style_link = $('#custom-style').attr('href').replace(/([^-]*)$/, $(this).data('color'));
            $('#custom-style').attr('href', style_link);
        });

        $(".date-btn").on("click", function() {
            $(".date-btn").removeClass("active");
            $(this).addClass("active");
            var start_date = $(this).data('start_date');
            var end_date = $(this).data('end_date');
            $.get('dashboard-filter/' + start_date + '/' + end_date, function(data) {
                dashboardFilter(data);
            });
        });

        function dashboardFilter(data) {
            $('.revenue-data').hide();
            $('.revenue-data').html(formatRupiah(parseFloat(data[0]).toFixed(0).toString()));
            $('.revenue-data').show(500);

            $('.pembelian').hide();
            $('.pembelian').html(formatRupiah(parseFloat(data[1]).toFixed(0).toString()));
            $('.pembelian').show(500);

            $('.expense').hide();
            $('.expense').html(formatRupiah(parseFloat(data[2]).toFixed(0).toString()));
            $('.expense').show(500);

            $('.return-data').hide();
            $('.return-data').html(formatRupiah(parseFloat(data[3]).toFixed(0).toString()));
            $('.return-data').show(500);

            $('.purchase_return-data').hide();
            $('.purchase_return-data').html(formatRupiah(parseFloat(data[4]).toFixed(0).toString()));
            $('.purchase_return-data').show(500);

            $('.profit-data').hide();
            $('.profit-data').html((parseInt(data[5]) >= 0) ? formatRupiah(parseFloat(data[5]).toFixed(0).toString()) :
                '-' + formatRupiah(parseFloat(data[5]).toFixed(0).toString()));
            $('.profit-data').show(500);
        }
    </script>
@endpush
