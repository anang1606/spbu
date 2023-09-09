<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $general_setting->site_title }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto+Slab:wght@500&display=swap"
        rel="stylesheet">

    <style>
        @page {
            margin: 20px 15px 10px 15px !important;
            font-size: 16px;
            line-height: 18px;
        }

        @font-face {
            font-family: sans-serif;
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: sans-serif;
            background-color: #606060;
            margin: 0;
        }

        h3 {
            font-size: 1.75rem;
        }

        h4 {
            font-size: 1.3rem;
        }

        h1,
        h2,
        h3,
        h4,
        h5 {
            margin: .5rem 0 .5rem 0;
            font-weight: 500;
            line-height: 1.2;
            font-family: sans-serif;
        }

        .topnav {
            overflow: hidden;
            background-color: #333;
            position: fixed;
            top: 0px;
            width: 100%;
            z-index: 1;
        }

        .topnav a {
            float: left;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        .nav-right {
            float: right !important;
        }

        .order-box {
            font-size: 12px;
            line-height: 15px;
            font-family: sans-serif;
            width: 216mm;
            margin: 20px auto;
            padding: 20px;
            margin-top: 60px;
            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
            min-height: 297mm;
            background-color: #fff;
            position: relative;
        }

        @media print {
            .order-box {
                font-size: 12px;
                line-height: 15px;
                font-family: sans-serif;
                padding: 0px;
                margin-top: 0px;
                box-shadow: 0 0 0 rgba(0, 0, 0, 0);
                background-color: unset;
            }

            .topnav {
                display: none;
            }

            .addreess {
                border: none !important;
            }
        }

        .addreess {
            border: none;
            width: 57px;
            border-bottom: 1px dashed;
            outline: none;
            text-align: end;
        }

        .gr {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .gr-r {
            border-right: 1px solid black !important;
            border-collapse: collapse;
        }

        .order-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .order-box table td,
        .order-box table th {
            padding: 5px;
            vertical-align: top;
        }

        .header-surat {
            display: flex;
            justify-content: space-between;
            gap: 2.2rem;
        }

        .body-surat {
            margin-top: 14px;
            min-height: 207mm;
        }
    </style>

</head>

<?php
function sum($sumData, $operator)
{
    $total = 0;
    $sum = explode(',', $sumData);
    $operator = explode(',', $operator);
    foreach ($sum as $key => $sm) {
        $query = DB::select('SELECT SUM(amount) as amount FROM laba_rugi WHERE type = "0" AND id = "' . $sm . '"');
        if ($operator[$key] === '+') {
            $total += $query[0]->amount;
        } elseif ($operator[$key] === '-') {
            $total -= $query[0]->amount;
        } else {
            $total *= $query[0]->amount;
        }
    }
    return $total;
}
?>

<body>
    <div class="topnav">
        <a href="#">SPT PPh BADAN {{ $tahun }}</a>
        <a href="#"> </a>
        <a href="#" class="nav-right" onclick="window.print()">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="5px" viewBox="0 0 512 450"
                style="width:20px;" xml:space="preserve">
                <g>
                    <path style="fill:#fff"
                        d="M433.231,124.718V45.949H78.769v78.769H0v262.564h78.769v78.769h354.462v-78.769H512V124.718H433.231z M118.154,85.333 h275.692v39.385H118.154V85.333z M393.846,426.667H118.154V321.641h275.692V426.667z M472.615,347.897h-39.385v-65.641H78.769    v65.641H39.385V164.103h433.231V347.897z" />
                </g>
            </svg>
            Print
        </a>
    </div>
    <div style="text-align:center">
        <div class="order-box">
            <div class="header-surat">
                <div style="text-align: left;width: 100%;display: flex;flex-direction: column;">
                    <h4 style="text-transform: uppercase;font-weight: 600;font-size: 13.8px;margin-bottom: 5px;">
                        {{ $general_setting->site_title }}
                    </h4>
                    <span style="text-transform: capitalize;font-weight: 600;font-size: 13.8px;margin-bottom: 5px;">
                        Laporan Laba Rugi dan
                    </span>
                    <span style="text-transform: capitalize;font-weight: 600;font-size: 13.8px;margin-bottom: 5px;">
                        Penghasilan Komprehensif Lain
                    </span>
                    <span style="text-transform: capitalize;font-weight: 600;font-size: 13.8px;margin-bottom: 5px;">
                        Untuk Tahun-Tahun yang Berakhir pada
                    </span>
                    <span style="font-weight: 600;font-size: 13.8px;margin-bottom: 12px;">
                        @if ($tahun !== date('Y'))
                            31 Desember {{ $tahun }}
                        @else
                            {{ date('d F Y') }}
                        @endif
                    </span>
                    <span style="font-weight: 300;font-size: 11.5px;">
                        (Dalam jutaan Rupiah, kecuali dinyatakan lain)
                    </span>
                </div>
                <div style="text-align: right;width: 100%;display: flex;flex-direction: column;font-style:italic;">
                    <h4 style="text-transform: uppercase;font-weight: 600;font-size: 13.8px;margin-bottom: 5px;">
                        {{ $general_setting->site_title }}
                    </h4>
                    <span style="text-transform: capitalize;font-weight: 600;font-size: 13.8px;margin-bottom: 5px;">
                        Statement of Profit or Loss and
                    </span>
                    <span style="text-transform: capitalize;font-weight: 600;font-size: 13.8px;margin-bottom: 5px;">
                        Other Comprehensive Income
                    </span>
                    <span style="text-transform: capitalize;font-weight: 600;font-size: 13.8px;margin-bottom: 5px;">
                        For The Years Ended
                    </span>
                    <span style="font-weight: 600;font-size: 13.8px;margin-bottom: 12px;">
                        @if ($tahun !== date('Y'))
                            31 December {{ $tahun }}
                        @else
                            {{ date('d F Y') }}
                        @endif
                    </span>
                    <span style="font-weight: 300;font-size: 11.5px;">
                        (Expressed in millions of Rupiah, unless otherwise stated)
                    </span>
                </div>
            </div>
            <div
                style="width: 100%;background: transparent;margin-top: 23px;border-bottom: 3px solid black;padding: 1px 0;">
            </div>
            <div
                style="width: 100%;background: transparent;margin-top: 23px;border-bottom: 3px solid black;padding: 1px 0;">
            </div>
            <div class="body-surat">
                <table>
                    <tbody>
                        @foreach ($data as $data)
                            <tr style="line-height: 14px;">
                                @if ($data->type === 2)
                                    <td style="padding: 4px 15px;" width="350">
                                        @if ($data->bold === 0)
                                            <h4
                                                style="margin:0;font-size: 13px;font-weight: 500;text-transform: capitalize;">
                                                {{ $data->keterangan }}
                                            </h4>
                                        @else
                                            <h4
                                                style="margin:0;font-size: 13px;font-weight: 600;text-transform: capitalize;">
                                                {{ $data->keterangan }}
                                            </h4>
                                        @endif
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td style="padding: 4px 15px;" width="250">
                                        @if ($data->bold === 0)
                                            <h4
                                                style="margin:0;font-size: 13px;font-weight: 500;text-transform: capitalize; text-align:right;font-style:italic;">
                                                {{ $data->translate }}
                                            </h4>
                                        @else
                                            <h4
                                                style="margin:0;font-size: 13px;font-weight: 600;text-transform: capitalize; text-align:right;font-style:italic;">
                                                {{ $data->translate }}
                                            </h4>
                                        @endif
                                    </td>
                                @else
                                    <td style="padding: 4px 15px;padding-bottom:{{ $data->type === 1 || $data->type === 6 || $data->type === 4 || $data->type === 5 || $data->type === 7 ? '15px' : '' }};padding-top:{{ $data->type === 4 || $data->type === 5 ? '15px' : '' }}"
                                        width="300">
                                        @if ($data->type === 0 || $data->type === 3 || $data->type === 7)
                                            <h4
                                                style="margin:0;font-size: 13px;font-weight: 500;text-transform: capitalize;">
                                                {{ $data->keterangan }}
                                            </h4>
                                        @elseif($data->type === 5)
                                            <h4
                                                style="margin:0;font-size: 13px;font-weight: 600;text-transform: capitalize;">
                                                {{ $data->keterangan }}
                                            </h4>
                                        @else
                                            <h4
                                                style="margin:0;font-size: 13px;font-weight: 600;text-transform: uppercase;">
                                                {{ $data->keterangan }}
                                            </h4>
                                        @endif
                                    </td>
                                    <td
                                        style="padding: 4px 10px;padding-top:{{ $data->type === 4 || $data->type === 5 || $data->type === 6 ? '15px' : '' }}">
                                        @if ($data->type === 0)
                                            <h4
                                                style="margin:0;font-size: 14px;font-weight: 500;font-family: 'Open Sans', sans-serif;text-align:center">
                                                @if ($data->plus_min === 0)
                                                    {{ number_format($data->amount, 0, '.', '.') }}
                                                @else
                                                    ({{ number_format($data->amount, 0, '.', '.') }})
                                                @endif
                                            </h4>
                                        @elseif ($data->type === 1)
                                            <h4
                                                style="margin:0;font-size: 14px;font-weight: 500;font-family: 'Open Sans', sans-serif;text-align:center;display: flex;justify-content: center;">
                                                <div
                                                    style="width: 120px;border-top:2px solid #000;display: block;font-weight: 600;font-family: 'Open Sans', sans-serif;">
                                                    {{ number_format(sum($data->sum, $data->operator), 0, '.', '.') }}
                                                </div>
                                            </h4>
                                        @elseif ($data->type === 5)
                                            <h4
                                                style="margin:0;font-size: 14px;font-weight: 500;font-family: 'Open Sans', sans-serif;text-align:center;display: flex;justify-content: center;">
                                                <div
                                                    style="width: 120px;border-bottom:2px solid #000;display: block;font-weight: 600;font-family: 'Open Sans', sans-serif;">
                                                    {{ number_format(sum($data->sum, $data->operator), 0, '.', '.') }}
                                                </div>
                                            </h4>
                                        @elseif ($data->type === 6)
                                            <h4
                                                style="margin:0;font-size: 14px;font-weight: 500;font-family: 'Open Sans', sans-serif;text-align:center;display: flex;justify-content: center;">
                                                <div
                                                    style="width: 120px;border-bottom:3px double #000;display: block;font-weight: 600;font-family: 'Open Sans', sans-serif;">
                                                    {{ number_format(sum($data->sum, $data->operator), 0, '.', '.') }}
                                                </div>
                                            </h4>
                                        @elseif ($data->type === 3)
                                            <h4
                                                style="margin:0;font-size: 14px;font-weight: 500;font-family: 'Open Sans', sans-serif;text-align:center;display: flex;justify-content: center;">
                                                <div
                                                    style="width: 120px;border-bottom:3px double #000;display: block;font-weight: 600;font-family: 'Open Sans', sans-serif;">
                                                    {{ number_format($data->amount, 0, '.', '.') }}
                                                </div>
                                            </h4>
                                        @elseif ($data->type === 7)
                                            <h4
                                                style="margin:0;font-size: 14px;font-weight: 500;font-family: 'Open Sans', sans-serif;text-align:center;display: flex;justify-content: center;">
                                                <div
                                                    style="width: 120px;border-bottom:4px solid #000;display: block;font-weight: 600;font-family: 'Open Sans', sans-serif;">
                                                    {{ number_format($data->amount, 0, '.', '.') }}
                                                </div>
                                            </h4>
                                        @elseif ($data->type === 4)
                                            <h4
                                                style="margin:0;font-size: 14px;font-weight: 500;font-family: 'Open Sans', sans-serif;text-align:center;display: flex;justify-content: center;">
                                                <div
                                                    style="width: 120px;border-bottom:2px solid #000;border-top:2px solid #000;display: block;font-weight: 600;font-family: 'Open Sans', sans-serif;padding:4px 0;">
                                                    {{ number_format(sum($data->sum, $data->operator), 0, '.', '.') }}
                                                </div>
                                            </h4>
                                        @endif
                                    </td>
                                    <td style="padding: 4px 10px;" width="200">
                                        <h4
                                            style="margin:0;font-size: 14px;font-weight: 500;font-family: 'Open Sans', sans-serif;text-align:center;">
                                            {{ $data->catatan }}
                                        </h4>
                                    </td>
                                    <td style="padding: 4px 15px;padding-bottom:{{ $data->type === 1 || $data->type === 6 || $data->type === 4 || $data->type === 5 || $data->type === 7 ? '20px' : '' }};padding-top:{{ $data->type === 4 || $data->type === 5 ? '20px' : '' }}"
                                        width="250">
                                        @if ($data->type === 0 || $data->type === 3 || $data->type === 7)
                                            <h4
                                                style="margin:0;font-size: 13px;font-style:italic;font-weight: 500;text-transform: capitalize;text-align:right;">
                                                {{ $data->translate }}
                                            </h4>
                                        @elseif($data->type === 5)
                                            <h4
                                                style="margin:0;font-size: 13px;font-style:italic;font-weight: 700;text-transform: capitalize;text-align:right;">
                                                {{ $data->translate }}
                                            </h4>
                                        @else
                                            <h4
                                                style="margin:0;font-size: 13px;font-style:italic;font-weight: 700;text-transform: uppercase;text-align:right;">
                                                {{ $data->translate }}
                                            </h4>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="display: flex;margin-top:30px;">
                <div style="text-align: center;width: 100%;display: flex;flex-direction: column;margin-top:30px">
                    <span style="font-weight: 300;font-size: 11.5px;">
                        Catatan atas laporan keuangan terlampir
                        <br>
                        merupakan bagian yang tidak terpisahkan
                        <br>
                        dari laporan keuangan ini.
                    </span>
                </div>
                <div style="text-align: center;width: 100%;display: flex;flex-direction: column;margin-top:30px">
                    <span style="font-weight: 300;font-size: 11.5px;">
                        The accompanying notes to the
                        <br>
                        financial statements form an integral part
                        <br>
                        of these financial statements.
                    </span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
