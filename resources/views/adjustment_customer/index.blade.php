@extends('layout.main')
@section('content')
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
    <section>
        <div class="container-fluid">
            <a href="/adjustment-customer/create" class="btn btn-info"><i class="dripicons-plus"></i> Tambah Data Perusahaan</a>
        </div>
        <div class="table-responsive">
            <table id="customer-grp-table" class="table">
                <thead>
                    <tr>
                        <th class="not-exported" style="width: 30px">
                            Tanggal
                        </th>
                        <th>No Ref</th>
                        <th>Product</th>
                        <th>Catatan</th>
                        <th class="not-exported">{{ trans('file.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($adjustments as $adjustment)
                        <tr>
                            <td>{{ date('d-m-Y', strtotime($adjustment->created_at->toDateString())) . ' ' . $adjustment->created_at->toTimeString() }}
                            </td>
                            <td>{{ $adjustment->reference_no }}</td>
                            <td>
                                @foreach ($adjustment->details as $details)
                                    {{ $details->product->name }} [{{ $details->group->name }}]
                                    <br>
                                @endforeach
                            </td>
                            <td>{{ $adjustment->note }}</td>
                            <td>
                                <div class="d-flex" style="width: 50%">
                                    <a href="{{ route('adjustment-customer.edit', $adjustment->id) }}"
                                        class=" btn btn-outline-info mr-2"><i
                                            class="dripicons-document-edit"></i>
                                        {{ trans('file.edit') }}
                                    </a>
                                    {{ Form::open(['route' => ['adjustment-customer.destroy', $adjustment->id], 'method' => 'DELETE']) }}
                                    <button type="submit" class="btn btn-outline-danger mr-2"
                                        onclick="return confirmDelete()"><i class="dripicons-trash"></i> Hapus</button>
                                    {{ Form::close() }}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
@push('scripts')
    <script type="text/javascript">
        $("ul#people").siblings('a').attr('aria-expanded', 'true');
        $("ul#people").addClass("show");
        $("ul#people #adjustment-customer").addClass("active");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function confirmDelete() {
            if (confirm("Anda yakin ingin menghapus??")) {
                return true;
            }
            return false;
        };

        $('#customer-grp-table').DataTable({
            order: [
                [0, 'asc']
            ]
        });
    </script>
@endpush
