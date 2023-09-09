<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="{{ url('public/logo', $general_setting->site_logo) }}" />
    <title>{{ $general_setting->site_title }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">

    <style type="text/css">
        * {
            font-size: 7.5pt !important;
            line-height: 12.4px;
            font-family: 'Ubuntu', sans-serif;
            text-transform: capitalize;
        }

        .btn {
            padding: 7px 10px;
            text-decoration: none;
            border: none;
            display: block;
            text-align: center;
            margin: 7px;
            cursor: pointer;
        }

        .btn-info {
            background-color: #999;
            color: #FFF;
        }

        .btn-primary {
            background-color: #6449e7;
            color: #FFF;
            width: 100%;
        }

        td,
        th,
        tr,
        table {
            border: none;
        }

        tr {
            border-bottom: 1px dotted #ddd;
        }

        td,
        th {
            padding: 0;
            line-height: 12.4px;
            width: 50%;
        }

        table {
            width: 100%;
        }

        tfoot tr th:first-child {
            text-align: left;
        }

        .centered {
            text-align: center;
            align-content: center;
        }

        small {
            font-size: 11px;
        }

        @media print {
           * {
                font-size: 7.5pt !important;
                line-height: 12.4px;
                font-family: 'Ubuntu', sans-serif;
                text-transform: capitalize;
            }

            td,
            th {
                padding: 0;
            }

            #receipt-data{
                height: 3cm;
            }

            .hidden-print {
                display: none !important;
            }

            @page {
                margin: 1.5cm 0.3cm;
            }

            @page: first {
                margin-top: 0.5cm;
            }

            @page{
                margin-bottom: 4vh;
            }

            tbody::after {
                content: '';
                display: block;
                page-break-after: always;
                page-break-inside: avoid;
                page-break-before: avoid;
            }
        }
    </style>
</head>

<?php
    function terbilang($angka) {
        $nominal = array(
        '',
        'satu',
        'dua',
        'tiga',
        'empat',
        'lima',
        'enam',
        'tujuh',
        'delapan',
        'sembilan',
        'sepuluh',
        'sebelas'
    );

    if ($angka < 12) {
        return $nominal[$angka];
    } else if ($angka < 20) {
        return $nominal[$angka - 10] . ' belas';
    } else if ($angka < 100) {
        return $nominal[floor($angka / 10)] . ' puluh ' . $nominal[$angka % 10];
    } else if ($angka < 200) {
        return 'seratus ' . terbilang($angka - 100);
    } else if ($angka < 1000) {
        return $nominal[floor($angka / 100)] . ' ratus ' . terbilang($angka % 100);
    } else if ($angka < 2000) {
        return 'seribu ' . terbilang($angka - 1000);
    } else if ($angka < 1000000) {
        return terbilang(floor($angka / 1000)) . ' ribu ' . terbilang($angka % 1000);
    } else if ($angka < 1000000000) {
        return terbilang(floor($angka / 1000000)) . ' juta ' . terbilang($angka % 1000000);
    } else if ($angka < 1000000000000) {
        return terbilang(floor($angka / 1000000000)) . ' milyar ' . terbilang(fmod($angka, 1000000000));
    } else if ($angka < 1000000000000000) {
        return terbilang(floor($angka / 1000000000000)) . ' trilyun ' . terbilang(fmod($angka, 1000000000000));
    } else if ($angka < 1000000000000000000) {
        return terbilang(floor($angka / 1000000000000000)) . ' kuadriliun ' . terbilang(fmod($angka, 1000000000000000));
    } else {
        return 'Nominal terlalu besar';
    }
}
?>

<body>

    <div style="max-width:58mm;margin:0 auto">
        @if (preg_match('~[0-9]~', url()->previous()))
            @php $url = '../../pos'; @endphp
        @else
            @php $url = url()->previous(); @endphp
        @endif
        <div class="hidden-print">
            <table>
                <tr>
                    <td><a href="{{ $url }}" class="btn btn-info"><i class="fa fa-arrow-left"></i>
                            {{ trans('file.Back') }}</a> </td>
                    <td><button onclick="window.print();" class="btn btn-primary"><i class="dripicons-print"></i>
                            {{ trans('file.Print') }}</button></td>
                </tr>
            </table>
            <br>
        </div>

        <div id="receipt-data">
            <div class="centered">
                @if ($general_setting->site_logo)
                    <img src="{{ url('logo', $general_setting->site_logo) }}" height="42" width="50"
                        style="margin:10px 0;filter: brightness(0);width: 180px;">
                @endif
                <p style="font-weight: 500;text-transform: uppercase;line-height: 12.4px;">
                    {{ $general_setting->site_title }} <br> {{ $lims_warehouse_data->phone }}
                    <br>
                    {{ $lims_warehouse_data->address }}
                </p>
                <div style="border-top: 0.05pt dashed #aeaeae;border-bottom: 0.05pt dashed #aeaeae;">
                    <div style="font-size: 7.2pt !important">
                        {{ date('d.m.y-H:i', strtotime($lims_sale_data->created_at)) }}/{{ $lims_sale_data->reference_no }}
                    </div>
                    <div style="font-size: 7.2pt !important">
                        {{ $lims_customer_data->name }}
                    </div>
                    <div style="font-size: 7.2pt !important">
                        {{ str_replace('-','/',$lims_sale_data->reference_no) }}/{{ $lims_user_data->name }}
                    </div>
                </div>
            </div>
            <table class="table-data">
                <tbody>
                    <?php
                        $total_product_tax = 0;
                        $total_product_discount = 0;
                        $harga_jual = 0;
                    ?>
                    @foreach ($lims_product_sale_data as $key => $product_sale_data)
                        <?php
                            $product_price = 0;
                            $lims_product_data = \App\Product::find($product_sale_data->product_id);
                            if ($product_sale_data->variant_id) {
                                $variant_data = \App\Variant::find($product_sale_data->variant_id);
                                $product_name = $lims_product_data->name . ' [' . $variant_data->name . ']';
                            } elseif ($product_sale_data->product_batch_id) {
                                $product_batch_data = \App\ProductBatch::select('batch_no')->find($product_sale_data->product_batch_id);
                                $product_name = $lims_product_data->name . ' [' . trans('file.Batch No') . ':' . $product_batch_data->batch_no . ']';
                            } else {
                                $product_name = $lims_product_data->name;
                            }

                            if ($product_sale_data->imei_number) {
                                $product_name .= '<br>' . trans('IMEI or Serial Numbers') . ': ' . $product_sale_data->imei_number;
                            }
                            $product_price = $lims_product_data->price;
                        ?>
                    <tr>
                        <td colspan="3">
                            {{ $product_sale_data->qty }} {!! $product_name !!}
                        </td>
                        {{--  <td style="text-align: center;width:13.2% !important">
                            {{ $product_sale_data->qty }}
                        </td>  --}}
                        <td style="text-align:right;padding-right:10px;font-size:7.8pt">
                            {{ number_format($product_price, 0, ',', ',') }}
                        </td>
                        <td style="text-align:right;">
                            <?php $harga_jual += $product_price; ?>
                            {{ number_format($product_price * $product_sale_data->qty, 0, ',', ',') }}
                        </td>
                    </tr>
                    @if ((int)$product_sale_data->discount !== 0)
                        <tr>
                            <td colspan="4" style="text-align:right;padding-right:10px;font-size:7.8pt">DISKON : </td>
                            <td style="text-align:right;">
                                <?php $total_product_discount += $product_sale_data->discount; ?>
                                ({{ number_format($product_sale_data->discount,0,',',',') }})
                            </td>
                        </tr>
                    @endif
                    @if ($product_sale_data->tax_rate)
                        <tr>
                            <td colspan="4" style="text-align:right;padding-right:10px;font-size:7.8pt">PAJAK : </td>
                            <td style="text-align:right;">
                                <?php $total_product_tax += $product_sale_data->tax; ?>
                                {{ number_format($product_sale_data->tax,0,',',',') }}
                            </td>
                        </tr>
                    @endif
                    @endforeach
                    <tr>
                        <td colspan="4" style="text-align:right;padding-right:10px;border-top: 0.05pt dashed #aeaeae;border-bottom: 0.05pt dashed #aeaeae;font-size:7.8pt">
                            HARGA JUAL :
                        </td>
                        <td style="text-align:right;border-top: 0.05pt dashed #aeaeae;border-bottom: 0.05pt dashed #aeaeae;">
                            {{ number_format((float) $lims_sale_data->total_price, 0, ',', ',') }}
                        </td>
                    </tr>
                    @if ($lims_sale_data->order_tax)
                        <tr>
                           <td colspan="3"></td>
                            <td style="text-align:right;padding-right:10px;font-size:7.8pt">
                                PPN :
                            </td>
                            <TD style="text-align:right">
                                {{ number_format((float) $lims_sale_data->order_tax, 0, ',', ',') }}</TD>
                        </tr>
                    @endif
                    @if ($lims_sale_data->order_discount)
                        <tr>
                            <td colspan="3"></td>
                            <td style="text-align:right;padding-right:10px;font-size:7.8pt">
                                DISKON :
                            </td>
                            <td style="text-align:right">
                                ({{ number_format((float) $lims_sale_data->order_discount, 0, ',', ',') }})
                            </td>
                        </tr>
                    @endif
                    @if ($lims_sale_data->coupon_discount)
                        <tr>
                            <td colspan="3"></td>
                            <td style="text-align:right;padding-right:10px;font-size:7.8pt">
                                VC DISKON :
                            </td>
                            <td style="text-align:right">
                                ({{ number_format((float) $lims_sale_data->coupon_discount, 0, '.', '.') }})
                            </td>
                        </tr>
                    @endif
                    @if ($lims_sale_data->shipping_cost)
                        <tr>
                            <td colspan="4" style="text-align:right;padding-right:10px;font-size:7.8pt">
                                PENGIRIMAN :
                            </td>
                            <td style="text-align:right">
                                {{ number_format((float) $lims_sale_data->shipping_cost, 0, '.', '.') }}
                            </td>
                        </tr>
                    @endif
                    @foreach ($lims_payment_data as $payment_data)
                        <tr>
                            <td colspan="4" style="text-align:right;padding-right:10px;border-top: 0.05pt dashed #aeaeae;border-bottom: 0.05pt dashed #aeaeae;font-size:7.8pt">
                                TOTAL :
                            </td>
                            <td style="text-align:right;border-top: 0.05pt dashed #aeaeae;border-bottom: 0.05pt dashed #aeaeae;">
                                {{ number_format((float) $payment_data->amount, 0, ',', ',') }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td style="text-align:right;padding-right:10px;font-size:7.8pt">
                                {{ ($payment_data->paying_method === 'Cash') ? 'TUNAI' : 'NON TUNAI' }} :
                            </td>
                            <td style="text-align:right;">
                                {{ number_format((float) ($payment_data->amount + $payment_data->change), 0, ',', ',') }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align:right;padding-right:10px;font-size:7.8pt">
                                KEMBALIAN :
                            </td>
                            <td style="text-align:right;">
                                {{ number_format((float) $payment_data->change, 0, ',', ',') }}
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="centered" colspan="5">
                            {{ trans('file.Thank you for shopping with us. Please come again') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="centered" colspan="5">
                            <?php echo '<img style="margin-top:10px;" src="data:image/png;base64,' . DNS2D::getBarcodePNG($lims_sale_data->reference_no, 'QRCODE') . '" alt="barcode"   />'; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <div class="centered" style="margin:10px 0 50px">
                                <small>
                                    {{ $general_setting->site_title }}.
                                    <br>
                                    <strong>Powered By AturUang</strong>
                                </small>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script type="text/javascript">
        localStorage.clear();

        function auto_print() {
            var mediaQuery = 'print';
            var stylesheet = document.createElement('style');
            stylesheet.setAttribute('media', mediaQuery);
            stylesheet.textContent = '@page { size: auto; margin: 0; }';
            document.head.appendChild(stylesheet);

            window.print()
        }
        setTimeout(auto_print, 1000);
    </script>

</body>

</html>
