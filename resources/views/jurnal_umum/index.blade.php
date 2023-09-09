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

    <section>
        <div class="content-box row">
            <div class="col-sm-12 offset-md-1 col-md-10 offset-lg-2 col-lg-8 offset-xxl-3 col-xxl-6">
                <div class="element-wrapper">
                    <div class="element-box">
                        <div class="element-info">
                            <div class="row align-items-center">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="mb-2">Jurnal Umum</h4>
                                            <span>
                                                Filter Jurnal Umum
                                            </span>
                                        </div>
                                        <div class="card-body">
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active show" href="#daily" role="tab"
                                                        data-toggle="tab" aria-selected="true">Harian</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#monhtly" role="tab" data-toggle="tab"
                                                        aria-selected="false">Bulanan</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#yearly" role="tab" data-toggle="tab"
                                                        aria-selected="false">Tahunan</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div role="tabpanel" class="tab-pane fade active show pt-4" id="daily">
                                                    <div class="row form-group">
                                                        <div class="col col-sm-2 pt-1 text-right">
                                                            <label for="a1">Tanggal</label>
                                                        </div>
                                                        <div class="col-12 col-sm-4">
                                                            <input id="a1" type="date" class="form-control"
                                                                value="{{ date('Y-m-d') }}">
                                                        </div>
                                                        <div class="col col-sm-2 pt-1 text-right">
                                                            <label for="a2">Akun</label>
                                                        </div>
                                                        <div class="col col-12 col-sm-4">
                                                            <select name="akun" id="a2" class="form-control">
                                                                <option value="">-- Pilih Akun --
                                                                </option>
                                                                @foreach ($coa as $row)
                                                                    <option value="{{ $row->account_no }}">
                                                                        {{ $row->account_no }}
                                                                        | {{ $row->name }} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mt-3 text-right">
                                                        <button id="btn1" type="button"
                                                            class="btn btn-primary">Laporan</button>
                                                    </div>
                                                </div>
                                                <div role="tabpanel" class="tab-pane fade pt-4" id="monhtly">
                                                    <div class="row form-group">
                                                        <div class="col col-sm-2 pt-1 text-right">
                                                            <label for="b1">Bulan</label>
                                                        </div>
                                                        <div class="col col-12 col-sm-4">
                                                            <select name="bulan" id="b1" class="form-control">
                                                                <option value="01"
                                                                    {{ date('m') == '01' ? 'selected' : '' }}>Januari
                                                                </option>
                                                                <option value="02"
                                                                    {{ date('m') == '02' ? 'selected' : '' }}>Februari
                                                                </option>
                                                                <option value="03"
                                                                    {{ date('m') == '03' ? 'selected' : '' }}>Maret</option>
                                                                <option value="04"
                                                                    {{ date('m') == '04' ? 'selected' : '' }}>April
                                                                </option>
                                                                <option value="05"
                                                                    {{ date('m') == '05' ? 'selected' : '' }}>Mei</option>
                                                                <option value="06"
                                                                    {{ date('m') == '06' ? 'selected' : '' }}>Juni</option>
                                                                <option value="07"
                                                                    {{ date('m') == '07' ? 'selected' : '' }}>Juli</option>
                                                                <option value="08"
                                                                    {{ date('m') == '08' ? 'selected' : '' }}>Agustus
                                                                </option>
                                                                <option value="09"
                                                                    {{ date('m') == '09' ? 'selected' : '' }}>September
                                                                </option>
                                                                <option value="10"
                                                                    {{ date('m') == '10' ? 'selected' : '' }}>Oktober
                                                                </option>
                                                                <option value="11"
                                                                    {{ date('m') == '11' ? 'selected' : '' }}>November
                                                                </option>
                                                                <option value="12"
                                                                    {{ date('m') == '12' ? 'selected' : '' }}>Desember
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="col col-sm-2 pt-1 text-right">
                                                            <label for="b2">Tahun</label>
                                                        </div>
                                                        <div class="col col-12 col-sm-4">
                                                            <select name="tahun" id="b2" class="form-control">
                                                                @foreach ($tahun as $thn)
                                                                    <option value="{{ $thn }}"
                                                                        {{ date('Y') == $thn ? 'selected' : '' }}>
                                                                        {{ $thn }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col col-sm-2 pt-1 text-right">
                                                            <label for="b3">Akun</label>
                                                        </div>
                                                        <div class="col col-12 col-sm-4">
                                                            <select name="akun" id="b3" class="form-control">
                                                                <option value="">-- Pilih Akun --
                                                                </option>
                                                                @foreach ($coa as $row)
                                                                    <option value="{{ $row->account_no }}">
                                                                        {{ $row->account_no }}
                                                                        | {{ $row->name }} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                    </div>
                                                    <div class="mt-3 text-right">
                                                        <button id="btn2" type="button"
                                                            class="btn btn-primary">Laporan</button>
                                                    </div>
                                                </div>
                                                <div role="tabpanel" class="tab-pane fade pt-4" id="yearly">
                                                    <div class="row form-group">
                                                        <div class="col col-sm-2 pt-1 text-right">
                                                            <label for="c1">Tahun</label>
                                                        </div>
                                                        <div class="col-12 col-sm-4">
                                                            <select name="bulan" id="c1" class="form-control">
                                                                @foreach ($tahun as $thn)
                                                                    <option value="{{ $thn }}"
                                                                        {{ date('Y') == $thn ? 'selected' : '' }}>
                                                                        {{ $thn }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col col-sm-2 pt-1 text-right">
                                                            <label for="c2">Akun</label>
                                                        </div>
                                                        <div class="col-12 col-sm-4">
                                                            <select name="akun" id="c2" class="form-control">
                                                                <option value="">-- Pilih Akun --
                                                                </option>
                                                                @foreach ($coa as $row)
                                                                    <option value="{{ $row->account_no }}">
                                                                        {{ $row->account_no }}
                                                                        | {{ $row->name }} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mt-3 text-right">
                                                        <button id="btn3" type="button"
                                                            class="btn btn-primary">Laporan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

        var url = '{{ url('jurnal-umum') }}';

        $('#btn1').click(function() {
            var harian = $('#a1').val();
            var akun = $('#a2').val();
            window.location.href = url + '/harian/' + harian + ';' + akun;
        });
        $('#btn2').click(function() {
            var bulan = $('#b1').val();
            var tahun = $('#b2').val();
            var akun = $('#b3').val();
            window.location.href = url + '/bulanan/' + tahun + '-' + bulan + ';' + akun;
        });
        $('#btn3').click(function() {
            var tahun = $('#c1').val();
            var akun = $('#c2').val();
            window.location.href = url + '/tahunan/' + tahun + ';' + akun;
        });
        $('#btn4').click(function() {
            var harian1 = $('#d1').val();
            var harian2 = $('#d2').val();
            var akun = $('#d3').val();
            window.location.href = url + '/range/' + harian1 + ';' + harian2 + ';' + akun;
        });
    </script>
@endpush
