<?php $general_setting = DB::table('general_settings')->find(1); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$general_setting->site_title}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <link rel="manifest" href="{{url('manifest.json')}}">
    <link rel="icon" type="image/png" href="{{url('public/images/asset-icons.png')}}" />
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?php echo asset('vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css">
    <!-- Google fonts - Roboto -->
    <link rel="preload" href="https://fonts.googleapis.com/css?family=Nunito:400,500,700" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,500,700" rel="stylesheet"></noscript>
    <!-- login stylesheet-->
    <link rel="stylesheet" href="<?php echo asset('css/auth.css') ?>" id="theme-stylesheet" type="text/css">
</head>
<body>
    <div class="page login-page">
        <div class="container">
            <div class="form-outer {{ ($general_setting->usaha_type === NULL) ? '' : 'text-center' }} d-flex align-items-center">
                @if ($general_setting->usaha_type === NULL)
                <div class="form-inner">
                    <h3 class="text-center">
                        Informasi Bisnis
                    </h3>
                    <form method="POST" action="{{ route('bisnis') }}" id="bisnis-form">
                        @csrf
                        <div class="form-group">
                            <label>Tipe Bisnis</label>
                            <select name="bisnis_tipe" id="bisnis_tipe" class="form-control">
                                {{--  <option value="1">Bakery</option>
                                <option value="1">Coffee Shop</option>
                                <option value="1">Quick Service Restaurant</option>
                                <option value="1">Full Service Restaurant</option>
                                <option value="1">F & B - Other</option>
                                <option value="2">Retail - Apparel & Accessories</option>
                                <option value="2">Retail - Baby</option>
                                <option value="2">Retail - Electronics</option>
                                <option value="2">Retail - F & B</option>
                                <option value="2">Retail - Furniture, Home, & Garden</option>
                                <option value="2">Retail - Health & Beauty</option>
                                <option value="2">Retail - Other</option>
                                <option value="3">Hair Salon</option>
                                <option value="4">Other</option>  --}}
                                <option value="" disabled selected>Silahkan Pilih</option>
                                <option value="2">Retail / Grosir</option>
                                <option value="1">Makanan & Minuman</option>
                                <option value="3">Jasa</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <h5 class="text-muted text-center" id="jenis_usaha">

                            </h5>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">{{trans('file.LogIn')}}</button>
                    </form>
                </div>
                @else
                <div class="form-inner">
                    <div class="logo">
                        <img src="{{ url('public/logo/83b3b0af660cf981ddcd9f61d9bf780d.svg') }}" style="width: 500px;" width="110">
                    </div>
                    @if(session()->has('delete_message'))
                    <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('delete_message') }}</div>
                    @endif
                    <form method="POST" action="{{ route('login') }}" id="login-form">
                        @csrf
                        <div class="form-group-material">
                            <input id="login-username" type="text" name="name" required class="input-material" value="">
                            <label for="login-username" class="label-material">Email</label>
                            @if(session()->has('error'))
                            <p>
                                <strong>{{ session()->get('error') }}</strong>
                            </p>
                            @endif
                        </div>

                        <div class="form-group-material">
                            <input id="login-password" type="password" name="password" required class="input-material" value="">
                            <label for="login-password" class="label-material">{{trans('file.Password')}}</label>
                            @if(session()->has('error'))
                            <p>
                                <strong>{{ session()->get('error') }}</strong>
                            </p>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">{{trans('file.LogIn')}}</button>
                    </form>
                    <!-- This three button for demo only-->
                    <!-- <button type="submit" class="btn btn-success admin-btn">LogIn as Admin</button>
                <button type="submit" class="btn btn-info staff-btn">LogIn as Staff</button>
                <button type="submit" class="btn btn-dark customer-btn">LogIn as Customer</button>
                <br><br> -->
                    <a href="{{ route('password.request') }}" class="forgot-pass">{{trans('file.Forgot Password?')}}</a>
                    <!-- <p>{{trans('file.Do not have an account?')}}</p><a href="{{url('register')}}" class="signup">{{trans('file.Register')}}</a> -->
                </div>
                @endif
                <div class="copyrights text-center">
                    <p>{{trans('file.Developed By')}} <span class="external">{{$general_setting->developed_by}}</span></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script type="text/javascript" src="<?php echo asset('vendor/jquery/jquery.min.js') ?>"></script>
<script>
    //switch theme code
    var theme = < ? php echo json_encode($theme); ? > ;
    if (theme == 'dark') {
        $('body').addClass('dark-mode');
        $('#switch-theme i').addClass('dripicons-brightness-low');
    } else {
        $('body').removeClass('dark-mode');
        $('#switch-theme i').addClass('dripicons-brightness-max');
    }
    $('.admin-btn').on('click', function() {
        $("input[name='name']").focus().val('admin');
        $("input[name='password']").focus().val('admin');
    });

    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/salepro/service-worker.js').then(function(registration) {
                // Registration was successful
                console.log('ServiceWorker registration successful with scope: ', registration.scope);
            }, function(err) {
                // registration failed :(
                console.log('ServiceWorker registration failed: ', err);
            });
        });
    }

</script>
<script type="text/javascript">
    $('.admin-btn').on('click', function() {
        $("input[name='name']").focus().val('admin');
        $("input[name='password']").focus().val('admin');
    });
    $('#bisnis_tipe').on('change', function(e) {
        var jenis_usaha = ''
        console.log(e.target.value)
        if(e.target.value === '1'){
            jenis_usaha = 'Rumah Makan,Coffe Shop, UMKM'
        }else if(e.target.value === '2'){
            jenis_usaha = 'Sembako, Elektronik, Fashion, Apotek, Obat, ATK, Mas, Pupuk, Bahan Bangunan, Mainan, Dll Sejenis'
        }else{
            jenis_usaha = 'Laundry, Salon, Cuci Kendaraan, Cleaning Service, Service Handphone, Service AC, Bekam, Foto Copy'
        }
        $("#jenis_usaha").text(jenis_usaha);
    });

    $('.staff-btn').on('click', function() {
        $("input[name='name']").focus().val('staff');
        $("input[name='password']").focus().val('staff');
    });

    $('.customer-btn').on('click', function() {
        $("input[name='name']").focus().val('shakalaka');
        $("input[name='password']").focus().val('shakalaka');
    });
    // ------------------------------------------------------- //
    // Material Inputs
    // ------------------------------------------------------ //

    var materialInputs = $('input.input-material');

    // activate labels for prefilled values
    materialInputs.filter(function() {
        return $(this).val() !== "";
    }).siblings('.label-material').addClass('active');

    // move label on focus
    materialInputs.on('focus', function() {
        $(this).siblings('.label-material').addClass('active');
    });

    // remove/keep label on blur
    materialInputs.on('blur', function() {
        $(this).siblings('.label-material').removeClass('active');

        if ($(this).val() !== '') {
            $(this).siblings('.label-material').addClass('active');
        } else {
            $(this).siblings('.label-material').removeClass('active');
        }
    });

</script>
