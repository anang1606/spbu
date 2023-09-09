@extends('layout.main') @section('content')
    <section class="container-fluid">
        <div class="content-box row">
            <div class="col-sm-12">
                <div style="width:100%;background-color: transparent;min-height: 100vh;position: relative;">
                    <iframe src="{{ url('posisi-keuangan/data') }}"
                        style="width: 100%; height: 100vh; padding: 0; margin: 0;border:none;"></iframe>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script type="text/javascript">
        $("ul#account").siblings('a').attr('aria-expanded', 'true');
        $("ul#account").addClass("show");
        $("ul#account #posisi-keuangan").addClass("active");
    </script>
@endpush
