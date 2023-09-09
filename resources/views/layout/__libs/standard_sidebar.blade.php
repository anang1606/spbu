<!-- Side Navbar -->
<nav class="side-navbar">
    <span class="brand-big" style="padding: 10px 0;">
        <a style="margin-left: -7px;" href="{{ url('/') }}">
            <img src="{{ url('logo/83b3b0af660cf981ddcd9f61d9bf780d.png') }}" style="width: 185px;" />
        </a>
    </span>
    <ul id="side-main-menu" class="side-menu list-unstyled">
        <li><a href="{{ url('/') }}"> <i class="dripicons-meter"></i><span>{{ __('file.dashboard') }}</span></a>
        </li>
        <?php
        $role = DB::table('roles')->find(Auth::user()->role_id);
        $category_permission_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'category'], ['role_id', $role->id]])
            ->first();

        $index_permission_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'products-index'], ['role_id', $role->id]])
            ->first();

        $print_barcode_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'print_barcode'], ['role_id', $role->id]])
            ->first();

        $stock_count_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'stock_count'], ['role_id', $role->id]])
            ->first();

        $adjustment_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'adjustment'], ['role_id', $role->id]])
            ->first();
        ?>
        @if (
            $category_permission_active ||
                $index_permission_active ||
                $print_barcode_active ||
                $stock_count_active ||
                $adjustment_active)
            @if ($index_permission_active)
                <li id="product-list-menu">
                    <a href="{{ route('products.index') }}">
                        <i class="dripicons-list"></i>
                        <span>
                            {{ __('file.product') }}
                        </span>
                    </a>
                </li>
            @endif
        @endif
        <?php
        $index_permission_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'purchases-index'], ['role_id', $role->id]])
            ->first();
        ?>
        @if ($index_permission_active)
            <li id="purchase-list-menu"><a href="{{ route('purchases.index') }}"> <i
                        class="dripicons-card"></i><span>{{ __('file.Purchase') }}</span></a>
            </li>
        @endif
        <?php
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
        ?>
        @if (
            $sale_index_permission_active ||
                $gift_card_permission_active ||
                $coupon_permission_active ||
                $delivery_permission_active)
            @if ($sale_index_permission_active)
                @if ($sale_add_permission_active)
                    <li>
                        <a href="{{ route('sales.index') }}" style="display: flex;">
                            <i class="dripicons-card"></i>
                            <span style="display: flex;justify-content: space-between;width: 100%;"
                                id="notif-penjualan">
                                {{ trans('file.Sale') }}

                                @if (countNotifPenjualan() > 0)
                                    <div class="badge bg-danger"
                                        style="width: 35px;display: flex;align-items: center;justify-content: center;font-size: 11px;">
                                        {{ countNotifPenjualan() }}
                                    </div>
                                @endif
                            </span>
                        </a>
                    </li>
                @endif
            @endif
        @endif
        <?php
        $index_permission_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'purchases-index'], ['role_id', $role->id]])
            ->first();
        ?>
        @if ($index_permission_active)
            @if ($general_setting->type === 'KbPeShVmYq3t6w9yBEHMcQfTjWnZ')
                @if ($general_setting->usaha_type === '2')
                    <li id="purchase-list-menu"><a href="{{ route('purchases.index') }}"> <i
                                class="dripicons-card"></i><span>{{ __('file.Purchase') }}</span></a>
                    </li>
                @endif
            @endif
        @endif

        {{-- <?php
        $index_permission_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'expenses-index'], ['role_id', $role->id]])
            ->first();
        ?>
        @if ($index_permission_active)
            <li id="exp-list-menu">
                <a href="{{ route('expenses.index') }}">
                    <i class="dripicons-wallet"></i>
                    <span>
                        {{ __('file.Expense') }}
                    </span>
                </a>
            </li>
        @endif --}}
        <?php
        $user_index_permission_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'users-index'], ['role_id', $role->id]])
            ->first();

        $customer_index_permission_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'customers-index'], ['role_id', $role->id]])
            ->first();

        $biller_index_permission_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'billers-index'], ['role_id', $role->id]])
            ->first();

        $supplier_index_permission_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'suppliers-index'], ['role_id', $role->id]])
            ->first();
        ?>
        @if ($customer_index_permission_active || $biller_index_permission_active || $supplier_index_permission_active)
            <li><a href="#people" aria-expanded="false" data-toggle="collapse"> <i
                        class="dripicons-user"></i><span>{{ trans('file.People') }}</span></a>
                <ul id="people" class="collapse list-unstyled ">

                    @if ($customer_index_permission_active)
                        <li id="customer-group-menu"><a href="{{ route('customer_group.index') }}">Perusahaan</a>
                        </li>
                        <li id="adjustment-customer"><a href="/adjustment-customer">Stock Perusahaan</a>
                        </li>
                        <li id="customer-list-menu"><a href="{{ route('customer.index') }}">Kendaraan</a></li>
                    @endif
                </ul>
            </li>
        @endif

        <?php
        $profit_loss_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'profit-loss'], ['role_id', $role->id]])
            ->first();
        $best_seller_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'best-seller'], ['role_id', $role->id]])
            ->first();
        $warehouse_report_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'warehouse-report'], ['role_id', $role->id]])
            ->first();
        $warehouse_stock_report_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'warehouse-stock-report'], ['role_id', $role->id]])
            ->first();
        $product_report_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'product-report'], ['role_id', $role->id]])
            ->first();
        $daily_sale_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'daily-sale'], ['role_id', $role->id]])
            ->first();
        $monthly_sale_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'monthly-sale'], ['role_id', $role->id]])
            ->first();
        $daily_purchase_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'daily-purchase'], ['role_id', $role->id]])
            ->first();
        $monthly_purchase_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'monthly-purchase'], ['role_id', $role->id]])
            ->first();
        $purchase_report_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'purchase-report'], ['role_id', $role->id]])
            ->first();
        $sale_report_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'sale-report'], ['role_id', $role->id]])
            ->first();
        $sale_report_chart_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'sale-report-chart'], ['role_id', $role->id]])
            ->first();
        $payment_report_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'payment-report'], ['role_id', $role->id]])
            ->first();
        $product_expiry_report_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'product-expiry-report'], ['role_id', $role->id]])
            ->first();
        $product_qty_alert_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'product-qty-alert'], ['role_id', $role->id]])
            ->first();
        $dso_report_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'dso-report'], ['role_id', $role->id]])
            ->first();
        $user_report_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'user-report'], ['role_id', $role->id]])
            ->first();
        $customer_report_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'customer-report'], ['role_id', $role->id]])
            ->first();
        $supplier_report_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'supplier-report'], ['role_id', $role->id]])
            ->first();
        $due_report_active = DB::table('permissions')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where([['permissions.name', 'due-report'], ['role_id', $role->id]])
            ->first();
        ?>
        @if (
            $profit_loss_active ||
                $best_seller_active ||
                $warehouse_report_active ||
                $warehouse_stock_report_active ||
                $product_report_active ||
                $daily_sale_active ||
                $monthly_sale_active ||
                $daily_purchase_active ||
                $monthly_purchase_active ||
                $purchase_report_active ||
                $sale_report_active ||
                $sale_report_chart_active ||
                $payment_report_active ||
                $product_expiry_report_active ||
                $product_qty_alert_active ||
                $dso_report_active ||
                $user_report_active ||
                $customer_report_active ||
                $supplier_report_active ||
                $due_report_active)
            <li><a href="#report" aria-expanded="false" data-toggle="collapse"> <i
                        class="dripicons-document-remove"></i><span>{{ trans('file.Reports') }}</span></a>
                <ul id="report" class="collapse list-unstyled ">
                    @if ($profit_loss_active)
                        <li id="profit-loss-report-menu">
                            {!! Form::open(['route' => 'report.profitLoss', 'method' => 'post', 'id' => 'profitLoss-report-form']) !!}
                            <input type="hidden" name="start_date" value="{{ date('Y-m') . '-' . '01' }}" />
                            <input type="hidden" name="end_date" value="{{ date('Y-m-d') }}" />
                            <a id="profitLoss-link" href="">{{ trans('file.Summary Report') }}</a>
                            {!! Form::close() !!}
                        </li>
                    @endif
                    @if ($product_report_active)
                        <li id="product-report-menu">
                            {!! Form::open(['route' => 'report.product', 'method' => 'get', 'id' => 'product-report-form']) !!}
                            <input type="hidden" name="start_date" value="{{ date('Y-m') . '-' . '01' }}" />
                            <input type="hidden" name="end_date" value="{{ date('Y-m-d') }}" />
                            <input type="hidden" name="warehouse_id" value="0" />
                            <a id="report-link" href="">{{ trans('file.Product Report') }}</a>
                            {!! Form::close() !!}
                        </li>
                    @endif
                    @if ($sale_report_active)
                        <li id="sale-report-menu">
                            {!! Form::open(['route' => 'report.sale', 'method' => 'post', 'id' => 'sale-report-form']) !!}
                            <input type="hidden" name="start_date" value="{{ date('Y-m') . '-' . '01' }}" />
                            <input type="hidden" name="end_date" value="{{ date('Y-m-d') }}" />
                            <input type="hidden" name="warehouse_id" value="0" />
                            <a id="sale-report-link" href="">{{ trans('file.Sale Report') }}</a>
                            {!! Form::close() !!}
                        </li>
                    @endif
                    @if ($payment_report_active)
                        <li id="payment-report-menu">
                            {!! Form::open(['route' => 'report.paymentByDate', 'method' => 'post', 'id' => 'payment-report-form']) !!}
                            <input type="hidden" name="start_date" value="{{ date('Y-m') . '-' . '01' }}" />
                            <input type="hidden" name="end_date" value="{{ date('Y-m-d') }}" />
                            <a id="payment-report-link" href="">{{ trans('file.Payment Report') }}</a>
                            {!! Form::close() !!}
                        </li>
                    @endif
                    @if ($purchase_report_active)
                        @if ($general_setting->type === 'KbPeShVmYq3t6w9yBEHMcQfTjWnZ')
                            @if ($general_setting->usaha_type === '4' || $general_setting->usaha_type === '2')
                                <li id="purchase-report-menu">
                                    {!! Form::open(['route' => 'report.purchase', 'method' => 'post', 'id' => 'purchase-report-form']) !!}
                                    <input type="hidden" name="start_date" value="{{ date('Y-m') . '-' . '01' }}" />
                                    <input type="hidden" name="end_date" value="{{ date('Y-m-d') }}" />
                                    <input type="hidden" name="warehouse_id" value="0" />
                                    <a id="purchase-report-link"
                                        href="">{{ trans('file.Purchase Report') }}</a>
                                    {!! Form::close() !!}
                                </li>
                            @endif
                        @endif
                    @endif
                    @if ($customer_report_active)
                        <li id="customer-report-menu">
                            <a id="customer-report-link" href="">{{ trans('file.Customer Report') }}</a>
                        </li>
                    @endif
                    @if ($supplier_report_active)
                        @if ($general_setting->type === 'KbPeShVmYq3t6w9yBEHMcQfTjWnZ')
                            @if ($general_setting->usaha_type === '4' || $general_setting->usaha_type === '2')
                                <li id="supplier-report-menu">
                                    <a id="supplier-report-link"
                                        href="">{{ trans('file.Supplier Report') }}</a>
                                </li>
                            @endif
                        @endif
                    @endif
                </ul>
            </li>
        @endif

        <li><a href="#setting" aria-expanded="false" data-toggle="collapse"> <i
                    class="dripicons-gear"></i><span>{{ trans('file.settings') }}</span></a>
            <ul id="setting" class="collapse list-unstyled ">

                <?php
                $all_notification_permission_active = DB::table('permissions')
                    ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                    ->where([['permissions.name', 'all_notification'], ['role_id', $role->id]])
                    ->first();

                $send_notification_permission_active = DB::table('permissions')
                    ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                    ->where([['permissions.name', 'send_notification'], ['role_id', $role->id]])
                    ->first();

                $warehouse_permission_active = DB::table('permissions')
                    ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                    ->where([['permissions.name', 'warehouse'], ['role_id', $role->id]])
                    ->first();

                $tax_permission_active = DB::table('permissions')
                    ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                    ->where([['permissions.name', 'tax'], ['role_id', $role->id]])
                    ->first();

                $general_setting_permission_active = DB::table('permissions')
                    ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                    ->where([['permissions.name', 'general_setting'], ['role_id', $role->id]])
                    ->first();

                $backup_database_permission_active = DB::table('permissions')
                    ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                    ->where([['permissions.name', 'backup_database'], ['role_id', $role->id]])
                    ->first();

                $mail_setting_permission_active = DB::table('permissions')
                    ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                    ->where([['permissions.name', 'mail_setting'], ['role_id', $role->id]])
                    ->first();

                $sms_setting_permission_active = DB::table('permissions')
                    ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                    ->where([['permissions.name', 'sms_setting'], ['role_id', $role->id]])
                    ->first();

                $create_sms_permission_active = DB::table('permissions')
                    ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                    ->where([['permissions.name', 'create_sms'], ['role_id', $role->id]])
                    ->first();

                $pos_setting_permission_active = DB::table('permissions')
                    ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                    ->where([['permissions.name', 'pos_setting'], ['role_id', $role->id]])
                    ->first();

                $hrm_setting_permission_active = DB::table('permissions')
                    ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                    ->where([['permissions.name', 'hrm_setting'], ['role_id', $role->id]])
                    ->first();

                $reward_point_setting_permission_active = DB::table('permissions')
                    ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                    ->where([['permissions.name', 'reward_point_setting'], ['role_id', $role->id]])
                    ->first();

                $discount_plan_permission_active = DB::table('permissions')
                    ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                    ->where([['permissions.name', 'discount_plan'], ['role_id', $role->id]])
                    ->first();

                $discount_permission_active = DB::table('permissions')
                    ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                    ->where([['permissions.name', 'discount'], ['role_id', $role->id]])
                    ->first();
                ?>
                <li id="user-menu"><a
                        href="{{ route('user.profile', ['id' => Auth::id()]) }}">{{ trans('file.User Profile') }}</a>
                </li>
                @if ($general_setting_permission_active)
                    <li id="general-setting-menu"><a
                            href="{{ route('setting.general') }}">{{ trans('file.General Setting') }}</a></li>
                @endif
                @if ($user_index_permission_active)
                        <li id="user-list-menu"><a href="{{ route('user.index') }}">{{ trans('file.User') }}</a>
                        </li>
                    @endif

            </ul>
        </li>

    </ul>
</nav>
