@extends('layout.main') @section('content')
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
    @endif
    @if (session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert"
                aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}
        </div>
    @endif
    @if ($errors->has('account_no'))
        <div class="alert alert-danger alert-dismissible text-center">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ $errors->first('account_no') }}
        </div>
    @endif
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
                        <a href="{{ url('jurnal-umum') }}" class="btn btn-outline-warning">
                            <i class="fa fa-chevron-left"></i>
                        </a>
                        <div class="card-title" style="margin: 0">
                            <h4 style="font-weight:600" class="mb-2">Jurnal Umum {{ $akun }} {{ $coaname }}
                            </h4>
                            <span>
                                {{ $rangeFilter }}
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
                        <a href="{{ url('jurnal-umum/cetak/' . strtolower($variable) . '/' . $priode) }}" target="blank"
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
                                            Jurnal Umum {{ $akun }} {{ $coaname }} <br>
                                            {{ $rangeFilter }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>{{ __('No') }}</th>
                                        <th>{{ __('Tanggal') }}</th>
                                        <th>{{ __('No Reff') }}</th>
                                        <th>{{ __('Keterangan') }}</th>
                                        <th>{{ __('Akun Debit') }}</th>
                                        <th>{{ __('Akun Kredit') }}</th>
                                        <th>{{ __('Saldo') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($acc->count() > 0)
                                        @foreach ($acc as $row)
                                            <tr>
                                                <td class="nowrap">{{ $loop->iteration }}</td>
                                                <td class="nowrap">
                                                    {{ translateDay(date_format(date_create($row->tanggal), 'd F Y')) }}
                                                </td>
                                                <td class="nowrap">{{ $row->kode_reff }}</td>
                                                <td class="nowrap">
                                                    {{ $row->keterangan == null ? 'Tidak ada Keterangan' : $row->keterangan }}
                                                </td>
                                                <td class="nowrap">{{ $row->coadebit }}</th>
                                                <td class="nowrap">{{ $row->coakredit }}</th>
                                                <td class="nowrap" align="right">{{ format_number($row->saldo) }}&nbsp;
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
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
        $("ul#account #jurnal-umum").addClass("active");
    </script>
@endpush
