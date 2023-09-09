<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $general_setting->site_title }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="manifest" href="{{ url('manifest.json') }}">

    <link rel="preload" href="https://fonts.googleapis.com/css?family=Nunito:400,500,700" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <link rel="stylesheet" href="<?php echo asset('vendor/font-awesome/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('vendor/dripicons/webfont.css'); ?>">
    <!-- Bootstrap CSS-->
    <link rel="icon" type="image/png" href="{{ url('images/asset-icons.png') }}" />
    <link rel="stylesheet" href="<?php echo asset('vendor/bootstrap/css/bootstrap.min.css'); ?>" type="text/css">

    <link rel="stylesheet" href="<?php echo asset('css/style.default.css'); ?>" id="theme-stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('css/custom-' . $general_setting->theme); ?>" type="text/css" id="custom-style">
</head>

<body>
    @if ($general_setting->type === 'KbPeShVmYq3t6w9yBEHMcQfTjWnZ')
        @include('layout/__libs/standard_sidebar')
    @else
        @include('layout/__libs/premium_sidebar')
    @endif
    <div class="page">
        @include('layout/__libs/header')
        <div id="content" class="animate-bottom">
            @yield('content')
        </div>
        <footer class="main-footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <p>&copy; {{ $general_setting->site_title }} | {{ trans('file.Developed') }}
                            {{ trans('file.By') }} <span class="external">Cidigi Inovasi</span> | V 3.7
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script type="text/javascript" src="<?php echo asset('vendor/jquery/jquery.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/jquery/jquery-ui.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/jquery/bootstrap-datepicker.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/jquery/jquery.timepicker.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/popper.js/umd/popper.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/bootstrap-toggle/js/bootstrap-toggle.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/bootstrap/js/bootstrap-select.min.js'); ?>"></script>

    <script type="text/javascript" src="<?php echo asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>

    <script type="text/javascript" src="<?php echo asset('js/front.js'); ?>"></script>
</body>

</html>
