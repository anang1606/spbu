@extends('layout.main') @section('content')
    @if (session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert"
                aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
    @endif
    <section class="forms">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4>{{ trans('file.Update User') }}</h4>
                        </div>
                        <div class="card-body">
                            <p class="italic">
                                <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                            </p>
                            {!! Form::open(['route' => ['user.update', $lims_user_data->id], 'method' => 'put', 'files' => true]) !!}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>{{ trans('file.UserName') }} *</strong> </label>
                                        <input type="text" name="name" required class="form-control"
                                            value="{{ $lims_user_data->name }}">
                                        @if ($errors->has('name'))
                                            <span>
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div id="admin-section">
                                        <div class="form-group">
                                            <label><strong>{{ trans('file.Change Password') }} *</strong> </label>
                                            <div class="input-group">
                                                <input type="password" name="password" required class="form-control">
                                                <div class="input-group-append">
                                                    <button id="genbutton" type="button"
                                                        class="btn btn-default">{{ trans('file.Generate') }}</button>
                                                </div>
                                                @if ($errors->has('password'))
                                                    <span>
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label><strong>{{ trans('file.Email') }} *</strong></label>
                                            <input type="email" name="email" placeholder="example@example.com" required
                                                class="form-control" value="{{ $lims_user_data->email }}">
                                            @if ($errors->has('email'))
                                                <span>
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div id="operator-section" style="display: none;">
                                        <div class="form-group">
                                            <label><strong>Ganti PIN *</strong> </label>
                                            <div class="input-group">
                                                <input type="password" name="pin" minlength="6" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label><strong>PIN Lama *</strong> </label>
                                            <div class="input-group">
                                                <input type="password" name="old_pin" minlength="6" class="form-control">
                                            </div>
                                            @if ($errors->has('pin'))
                                                <span>
                                                    <strong>{{ $errors->first('pin') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label><strong>{{ trans('file.Phone Number') }} *</strong></label>
                                        <input type="text" name="phone" required class="form-control"
                                            value="{{ $lims_user_data->phone }}">
                                    </div>
                                    <div class="form-group">
                                        @if ($lims_user_data->is_active)
                                            <input class="mt-2" type="checkbox" name="is_active" value="1" checked>
                                        @else
                                            <input class="mt-2" type="checkbox" name="is_active" value="1">
                                        @endif
                                        <label class="mt-2"><strong>{{ trans('file.Active') }}</strong></label>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="{{ trans('file.submit') }}" class="btn btn-primary">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>{{ trans('file.Role') }} *</strong></label>
                                        <input type="hidden" name="company_name" class="form-control">
                                        <input type="hidden" name="role_id_hidden" value="{{ $lims_user_data->role_id }}">
                                        <select name="role_id" id="role_id" required class="selectpicker form-control"
                                            data-live-search="true" data-live-search-style="begins" title="Select Role...">
                                            @foreach ($lims_role_list as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script type="text/javascript">
        $("ul#people").siblings('a').attr('aria-expanded', 'true');
        $("ul#people").addClass("show");
        $("ul#people #user-list-menu").addClass("active");

        $('select[name=role_id]').val($("input[name='role_id_hidden']").val());
        if ($('select[name=role_id]').val() == 3) {
            $('input[name="password"]').prop('required', false);
            $('input[name="email"]').prop('required', false);
            $('#admin-section').hide(300);
            $('#operator-section').show(300);
        } else {
            $('input[name="password"]').prop('required', true);
            $('input[name="email"]').prop('required', true);
            $('#admin-section').show(300);
            $('#operator-section').hide(300);
        }
        $('.selectpicker').selectpicker('refresh');

        $('select[name="role_id"]').on('change', function() {
            if ($(this).val() == 3) {
                $('input[name="password"]').prop('required', false);
                $('input[name="email"]').prop('required', false);
                $('#admin-section').hide(300);
                $('#operator-section').show(300);
            } else {
                $('input[name="password"]').prop('required', true);
                $('input[name="email"]').prop('required', true);
                $('#admin-section').show(300);
                $('#operator-section').hide(300);
            }
        });

        $('#genbutton').on("click", function() {
            $.get('../genpass', function(data) {
                $("input[name='password']").val(data);
            });
        });
    </script>
@endpush
