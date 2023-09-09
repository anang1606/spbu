@extends('layout.main') @section('content')
    @php
        function translateDay($str)
        {
            $searchVal = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $replaceVal = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $res = str_replace($searchVal, $replaceVal, $str);
            return $res;
        }
        function format_number($angka)
        {
            $hasil = number_format($angka, 0, ',', '.');
            return $hasil;
        }
    @endphp
    <section class="container-fluid mt-5">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-sm-8" style="display: flex;align-items:center;gap:0 20px">
                        <a href="{{ url('neraca-lajur') }}" class="btn btn-outline-warning">
                            <i class="fa fa-chevron-left"></i>
                        </a>
                        <div class="card-title" style="margin: 0">
                            <h4 style="font-weight:600" class="mb-2">Laporan Neraca Lajur
                            </h4>
                            <span>
                                Laporan Neraca Lajur Periode {{ $rangeFilter }}
                            </span>
                        </div>
                    </div>
                    {{--  <div class="col-sm-4 text-right">
                        @php
                            if ($variable == 'Harian') {
                                $priode = $hari;
                            } elseif ($variable == 'Bulanan') {
                                $priode = $bulan;
                            } else {
                                $priode = $tahun;
                            }
                        @endphp
                        <a href="{{ url('neraca-lajur/cetak/' . strtolower($variable) . '/' . $priode) }}" target="blank"
                            class="btn btn-dark mt-1"><i class="fa fa-print mr-2" style="font-size:16pt"></i>
                            Cetak</a>
                    </div>  --}}
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive pb-3">
                            <table class="table table-bordered table-striped table-hover display responsive w-100">
                                <thead>
                                    <tr>
                                        <th colspan="13"
                                            style="background:#FFFFFF;font-size: 18px;border: 1px solid #e4e6fc;font-weight: 400;"
                                            class="text-center">
                                            {{ $general_setting->site_title }} <br>
                                            Neraca Lajur <br>
                                            Periode {{ $rangeFilter }}
                                        </th>
                                    </tr>
                                    <tr style="border: 1px solid #e4e6fc;">
                                        <th rowspan="2" style="width: 3%;background:#FFFFFF; text-align:center;">KODE
                                        </th>
                                        <th rowspan="2" colspan="2"
                                            style="width: 17%;background:#FFFFFF; text-align:center;">NAMA AKUN</th>
                                        <th colspan="2" style="background:#FFFFFF; width:13%; text-align:center;">SALDO
                                            AWAL</th>
                                        <th colspan="2" style="background:#FFFFFF; width:13%; text-align:center;">MUTASI
                                        </th>
                                        <th colspan="2" style="background:#FFFFFF; width:13%; text-align:center;">SALDO
                                            AKHIR</th>
                                        <th colspan="2" style="background:#FFFFFF; width:13%; text-align:center;">LABA
                                            RUGI</th>
                                        <th colspan="2" style="background:#FFFFFF; width:13%; text-align:center;">NERACA
                                        </th>
                                    </tr>
                                    <tr style="border: 1px solid #e4e6fc;">
                                        <th style="width: 8%;background:#FFFFFF; text-align:center;">DEBIT</th>
                                        <th style="width: 8%;background:#FFFFFF; text-align:center;">KREDIT</th>
                                        <th style="width: 8%;background:#FFFFFF; text-align:center;">DEBIT</th>
                                        <th style="width: 8%;background:#FFFFFF; text-align:center;">KREDIT</th>
                                        <th style="width: 8%;background:#FFFFFF; text-align:center;">DEBIT</th>
                                        <th style="width: 8%;background:#FFFFFF; text-align:center;">KREDIT</th>
                                        <th style="width: 8%;background:#FFFFFF; text-align:center;">DEBIT</th>
                                        <th style="width: 8%;background:#FFFFFF; text-align:center;">KREDIT</th>
                                        <th style="width: 8%;background:#FFFFFF; text-align:center;">DEBIT</th>
                                        <th style="width: 8%;background:#FFFFFF; text-align:center;">KREDIT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($neraca as $row)
                                        <tr>
                                            <td style="text-center">{{ $row->idcoa }}</td>
                                            <td colspan="2">
                                                <h6><b> {{ $row->namacoa }} </b></h6>
                                            </td>
                                            <td style="text-align:right">{{ format_number($row->adebit) }}</td>
                                            <td style="text-align:right">{{ format_number($row->akredit) }}</td>
                                            <td style="text-align:right">{{ format_number($row->bdebit) }}</td>
                                            <td style="text-align:right">{{ format_number($row->bkredit) }}</td>
                                            <td style="text-align:right">{{ format_number($row->cdebit) }}</td>
                                            <td style="text-align:right">{{ format_number($row->ckredit) }}</td>
                                            <td style="text-align:right">{{ format_number($row->ddebit) }}</td>
                                            <td style="text-align:right">{{ format_number($row->dkredit) }}</td>
                                            <td style="text-align:right">{{ format_number($row->edebit) }}</td>
                                            <td style="text-align:right">{{ format_number($row->ekredit) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr style="background:#FFFFFF;">
                                        <td colspan="3">
                                            <h6><b> Total : </b></h6>
                                        </td>
                                        <td style="text-align:right">{{ format_number($total1->tadebit) }}</td>
                                        <td style="text-align:right">{{ format_number($total1->takredit) }}</td>
                                        <td style="text-align:right">{{ format_number($total1->tbdebit) }}</td>
                                        <td style="text-align:right">{{ format_number($total1->tbkredit) }}</td>
                                        <td style="text-align:right">{{ format_number($total1->tcdebit) }}</td>
                                        <td style="text-align:right">{{ format_number($total1->tckredit) }}</td>
                                        <td style="text-align:right">{{ format_number($total1->tddebit) }}</td>
                                        <td style="text-align:right">{{ format_number($total1->tdkredit) }}</td>
                                        <td style="text-align:right">{{ format_number($total1->tedebit) }}</td>
                                        <td style="text-align:right">{{ format_number($total1->tekredit) }}</td>
                                    </tr>
                                    <tr style="background:#FFFFFF; text-align:right;">
                                        <td colspan="9">
                                            <h6><b> Laba / Rugi : </b></h6>
                                        </td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                    </tr>
                                    <tr style="background:#FFFFFF; text-align:right;border: 1px solid #e4e6fc;">
                                        <td colspan="11">
                                            <h6><b> Balance : </b></h6>
                                        </td>
                                        <td style="text-align:right">{{ format_number($total1->tedebit) }}</td>
                                        <td style="text-align:right">{{ format_number($total1->tekredit) }}</td>
                                    </tr>
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
        $("ul#account").siblings('a').attr('aria-expanded', 'true');
        $("ul#account").addClass("show");
        $("ul#account #neraca-lajur").addClass("active");
    </script>
@endpush
