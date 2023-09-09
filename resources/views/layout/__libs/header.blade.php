<?php
$role = DB::table('roles')->find(Auth::user()->role_id);
$sale_index_permission_active = DB::table('permissions')
    ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
    ->where([['permissions.name', 'sales-index'], ['role_id', $role->id]])
    ->first();

$gift_card_permission_active = DB::table('permissions')
    ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
    ->where([['permissions.name', 'gift_card'], ['role_id', $role->id]])
    ->first();

$coupon_permission_active = DB::table('permissions')
    ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
    ->where([['permissions.name', 'coupon'], ['role_id', $role->id]])
    ->first();

$delivery_permission_active = DB::table('permissions')
    ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
    ->where([['permissions.name', 'delivery'], ['role_id', $role->id]])
    ->first();

$sale_add_permission_active = DB::table('permissions')
    ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
    ->where([['permissions.name', 'sales-add'], ['role_id', $role->id]])
    ->first();
$product_qty_alert_active = DB::table('permissions')
    ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
    ->where([['permissions.name', 'product-qty-alert'], ['role_id', $role->id]])
    ->first();
$general_setting_permission_active = DB::table('permissions')
    ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
    ->where([['permissions.name', 'general_setting'], ['role_id', $role->id]])
    ->first();
?>
<style>
    .msg {
        position: relative;
        padding: 0.75rem 1.25rem;
        text-align: center;
        {{--  margin-bottom: 1rem;  --}} border: 1px solid transparent;
        border-radius: 0.25rem;
        margin-left: -25px;
        margin-right: -25px;
    }

    .msg-warning {
        color: #856404;
        background-color: #fff3cd;
        border-color: #ffeeba;
    }

    header {
        top: -51px !important;
    }
</style>
<header class="container-fluid">

    <nav class="navbar">
        <a id="toggle-btn" href="#" class="menu-btn"><i class="fa fa-bars"> </i></a>

        <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
            <?php
            $empty_database_permission_active = DB::table('permissions')
                ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                ->where([['permissions.name', 'empty_database'], ['role_id', $role->id]])
                ->first();
            ?>
            <li class="nav-item"><a id="btnFullscreen" data-toggle="tooltip" title="{{ trans('file.Full Screen') }}"><i
                        class="dripicons-expand"></i></a></li>
            @if (\Auth::user()->role_id <= 2)
                <li class="nav-item"><a href="{{ route('cashRegister.index') }}" data-toggle="tooltip"
                        title="{{ trans('file.Cash Register List') }}"><i class="dripicons-archive"></i></a>
                </li>
            @endif
            @if ($product_qty_alert_active && $alert_product + $dso_alert_product_no + count(\Auth::user()->unreadNotifications) > 0)
                <li class="nav-item" id="notification-icon">
                    <a rel="nofollow" data-toggle="tooltip" title="{{ __('Notifications') }}"
                        class="nav-link dropdown-item"><i class="dripicons-bell"></i><span
                            class="badge badge-danger notification-number">{{ $alert_product + $dso_alert_product_no + count(\Auth::user()->unreadNotifications) }}</span>
                    </a>
                    <ul class="right-sidebar">
                        <li class="notifications">
                            <a href="{{ route('report.qtyAlert') }}" class="btn btn-link">
                                {{ $alert_product }} product exceeds alert quantity</a>
                        </li>
                        @if ($dso_alert_product_no)
                            <li class="notifications">
                                <a href="{{ route('report.dailySaleObjective') }}" class="btn btn-link">
                                    {{ $dso_alert_product_no }} product could not fulfill daily sale
                                    objective</a>
                            </li>
                        @endif
                        @foreach (\Auth::user()->unreadNotifications as $key => $notification)
                            <li class="notifications">
                                @if ($notification->data['document_name'])
                                    <a target="_blank"
                                        href="{{ url('public/documents/notification', $notification->data['document_name']) }}"
                                        class="btn btn-link">{{ $notification->data['message'] }}</a>
                                @else
                                    <a href="#" class="btn btn-link">{{ $notification->data['message'] }}</a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
            @if (count(\Auth::user()->unreadNotifications) > 0)
                <li class="nav-item" id="notification-icon">
                    <a rel="nofollow" data-toggle="tooltip" title="{{ __('Notifications') }}"
                        class="nav-link dropdown-item"><i class="dripicons-bell"></i><span
                            class="badge badge-danger notification-number">{{ count(\Auth::user()->unreadNotifications) }}</span>
                    </a>
                    <ul class="right-sidebar">
                        @foreach (\Auth::user()->unreadNotifications as $key => $notification)
                            <li class="notifications">
                                @if ($notification->data['document_name'])
                                    <a target="_blank"
                                        href="{{ url('public/documents/notification', $notification->data['document_name']) }}"
                                        class="btn btn-link">{{ $notification->data['message'] }}</a>
                                @else
                                    <a href="#" class="btn btn-link">{{ $notification->data['message'] }}</a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
            <li class="nav-item">
                <a rel="nofollow" data-toggle="tooltip" class="nav-link dropdown-item"><i class="dripicons-user"></i>
                    <span>{{ ucfirst(Auth::user()->name) }}</span> <i class="fa fa-angle-down"></i>
                </a>
                <ul class="right-sidebar">
                    <li>
                        <a href="{{ route('user.profile', ['id' => Auth::id()]) }}"><i class="dripicons-user"></i>
                            {{ trans('file.profile') }}</a>
                    </li>
                    @if ($general_setting_permission_active)
                        <li>
                            <a href="{{ route('setting.general') }}"><i class="dripicons-gear"></i>
                                {{ trans('file.settings') }}</a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ url('my-transactions/' . date('Y') . '/' . date('m')) }}"><i
                                class="dripicons-swap"></i> {{ trans('file.My Transaction') }}</a>
                    </li>
                    @if (Auth::user()->role_id != 5)
                        <li>
                            <a href="{{ url('holidays/my-holiday/' . date('Y') . '/' . date('m')) }}"><i
                                    class="dripicons-vibrate"></i> {{ trans('file.My Holiday') }}</a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"><i
                                class="dripicons-power"></i>
                            {{ trans('file.logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</header>
