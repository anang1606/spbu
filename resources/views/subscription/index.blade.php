@extends('layout.subscription')
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
    <!-- Counts Section -->
    <section class="dashboard-counts">
        <iframe src="http://billing.aturuangpos.com/api/view_invoice?id={{ getBackOffice()['invoice']['id'] }}" style="width: 100%;height: 85vh;"
            frameborder="0"></iframe>
    </section>
@endsection

@push('scripts')
@endpush
