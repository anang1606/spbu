@extends('layout.main') @section('content')
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
                                            <h4 class="mb-2">Laba Rugi</h4>
                                            <span>
                                                Filter Laba Rugi
                                            </span>
                                        </div>
                                        <div class="card-body">
                                            <div class="row form-group">
                                                <div class="col col-sm-2 pt-1 text-right">
                                                    <label for="c1">Tahun</label>
                                                </div>
                                                <div class="col-12 col-sm-10">
                                                    <select name="bulan" id="c1" class="form-control">
                                                        @foreach ($tahun as $thn)
                                                            <option value="{{ $thn }}"
                                                                {{ date('Y') == $thn ? 'selected' : '' }}>
                                                                {{ $thn }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-12">
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
        $("ul#account #laba-rugi").addClass("active");

        var url = '{{ url('laba-rugi') }}';

        $('#btn3').click(function() {
            var tahun = $('#c1').val();
            window.location.href = url + '/data/' + tahun;
        });
    </script>
@endpush
