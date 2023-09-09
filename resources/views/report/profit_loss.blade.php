@extends('layout.main')
@section('content')
<section>
	<h3 class="text-center">{{trans('file.Summary Report')}}</h3>
	{!! Form::open(['route' => 'report.profitLoss', 'method' => 'post']) !!}
	<div class="col-md-6 offset-md-3 mt-4">
        <div class="form-group row">
            <label class="d-tc mt-2"><strong>{{trans('file.Choose Your Date')}}</strong> &nbsp;</label>
            <div class="d-tc">
                <div class="input-group">
                    <input type="text" class="daterangepicker-field form-control" value="{{$start_date}} To {{$end_date}}" required />
                    <input type="hidden" name="start_date" value="{{$start_date}}" />
                    <input type="hidden" name="end_date" value="{{$end_date}}" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">{{trans('file.submit')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
	{{Form::close()}}
	<div class="container-fluid">
		<div class="row mt-4 justify-content-center">
            @if($general_setting->type === 'KbPeShVmYq3t6w9yBEHMcQfTjWnZ')
                @if($general_setting->usaha_type === '1' || $general_setting->usaha_type === '2')
                @endif
            @endif
            @if($general_setting->type === 'KbPeShVmYq3t6w9yBEHMcQfTjWnZ')
                @if($general_setting->usaha_type === '1' || $general_setting->usaha_type === '2')
                    <div class="col-md-3">
                        <div class="colored-box">
                            <i class="fa fa-heart"></i>
                            <h3>{{trans('file.Purchase')}}</h3>
                            <hr>
                            <div class="mt-3">
                                <p class="mt-2">{{trans('file.Amount')}} <span class="float-right"> Rp. {{number_format((float)$purchase[0]->grand_total, 0, '.', '.') }}</span></p>
                                <p class="mt-2">{{trans('file.Purchase')}} <span class="float-right">{{number_format($total_purchase,0,'.','.')}}</span></p>
                                <p class="mt-2">{{trans('file.Paid')}} <span class="float-right">Rp. {{number_format((float)$purchase[0]->paid_amount, 0, '.', '.')}}</span></p>
                                <p class="mt-2">{{trans('file.Tax')}} <span class="float-right">Rp. {{number_format((float)$purchase[0]->tax, 0, '.', '.')}}</span></p>
                                <p class="mt-2">{{trans('file.Discount')}} <span class="float-right">Rp. {{number_format((float)$purchase[0]->discount, 0, '.', '.')}}</span></p>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
			<div class="col-md-3">
				<div class="colored-box">
					<i class="fa fa-shopping-cart"></i>
					<h3>{{trans('file.Sale')}}</h3>
					<hr>
					<div class="mt-3">
						<p class="mt-2">{{trans('file.Amount')}} <span class="float-right"> Rp. {{number_format((float)$sale[0]->grand_total, 0, '.', '.') }}</span></p>
						<p class="mt-2">{{trans('file.Sale')}} <span class="float-right">{{number_format($total_sale,0,'.','.')}}</span></p>
						<p class="mt-2">{{trans('file.Paid')}} <span class="float-right">Rp. {{number_format((float)$sale[0]->paid_amount, 0, '.', '.')}}</span></p>
						<p class="mt-2">{{trans('file.Tax')}} <span class="float-right">Rp. {{number_format((float)$sale[0]->tax, 0, '.', '.')}}</span></p>
						<p class="mt-2">{{trans('file.Discount')}} <span class="float-right">Rp. {{number_format((float)$sale[0]->discount, 0, '.', '.')}}</span></p>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="colored-box">
					<i class="fa fa-random "></i>
					<h3>{{trans('file.Sale Return')}}</h3>
					<hr>
					<div class="mt-3">
						<p class="mt-2">{{trans('file.Amount')}} <span class="float-right"> Rp. {{number_format((float)$return[0]->grand_total, 0, '.', '.') }}</span></p>
						<p class="mt-2">{{trans('file.Return')}} <span class="float-right">{{number_format($total_return,0,'.','.')}}</span></p>
						<p class="mt-2">{{trans('file.Tax')}} <span class="float-right">Rp. {{number_format((float)$return[0]->tax, 0, '.', '.')}}</span></p>
					</div>
				</div>
			</div>
            @if($general_setting->type === 'KbPeShVmYq3t6w9yBEHMcQfTjWnZ')
                @if($general_setting->usaha_type === '1' || $general_setting->usaha_type === '2')
                    <div class="col-md-3">
                        <div class="colored-box">
                            <i class="fa fa-random "></i>
                            <h3>{{trans('file.Purchase Return')}}</h3>
                            <hr>
                            <div class="mt-3">
                                <p class="mt-2">{{trans('file.Amount')}} <span class="float-right"> Rp. {{number_format((float)$purchase_return[0]->grand_total, 0, '.', '.') }}</span></p>
                                <p class="mt-2">{{trans('file.Return')}} <span class="float-right">{{number_format($total_purchase_return,0,'.','.')}}</span></p>
                                <p class="mt-2">{{trans('file.Tax')}} <span class="float-right">Rp. {{number_format((float)$purchase_return[0]->tax, 0, '.', '.')}}</span></p>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
		</div>
		<div class="row mt-2">
			<div class="col-md-4">
				<div class="colored-box">
					<i class="fa fa-money"></i>
					<h3>{{trans('file.profit')}} / {{trans('file.Loss')}}</h3>
					<hr>
					<div class="mt-3">
						<p class="mt-2">{{trans('file.Sale')}} <span class="float-right">Rp. {{number_format((float)$sale[0]->grand_total, 0, '.', '.')}}</span></p>
						<p class="mt-2">{{trans('file.Product Cost')}} <span class="float-right">- Rp. {{number_format((float)$product_cost, 0, '.', '.')}}</span></p>
						<p class="mt-2">{{trans('file.profit')}} <span class="float-right"> Rp. {{number_format((float)($sale[0]->grand_total - $product_cost), 0, '.', '.') }}</span></p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="colored-box">
					<i class="fa fa-money"></i>
					<h3>{{trans('file.profit')}} / {{trans('file.Loss')}}</h3>
					<hr>
					<div class="mt-3">
						<p class="mt-2">{{trans('file.Sale')}} <span class="float-right">Rp. {{number_format((float)$sale[0]->grand_total, 0, '.', '.')}}</span></p>
						<p class="mt-2">{{trans('file.Product Cost')}} <span class="float-right">- Rp. {{number_format((float)$product_cost, 0, '.', '.')}}</span></p>
						<p class="mt-2">{{trans('file.Sale Return')}} <span class="float-right">- Rp. {{number_format((float)$return[0]->grand_total, 0, '.', '.')}}</span></p>
                        @if($general_setting->type === 'KbPeShVmYq3t6w9yBEHMcQfTjWnZ')
                            @if($general_setting->usaha_type === '1' || $general_setting->usaha_type === '2')
                                <p class="mt-2">{{trans('file.Purchase Return')}} <span class="float-right"> Rp. {{number_format((float)$purchase_return[0]->grand_total, 0, '.', '.')}}</span></p>
                            @endif
                        @endif
						<p class="mt-2">{{trans('file.profit')}} <span class="float-right"> Rp. {{number_format((float)($sale[0]->grand_total - $product_cost - $return[0]->grand_total + $purchase_return[0]->grand_total), 0, '.', '.') }}</span></p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="colored-box">
					<i class="fa fa-money "></i>
					<h3>{{trans('file.Net Profit')}} / {{trans('file.Net Loss')}}</h3>
					<hr>
					<h4 class="text-center">Rp. {{number_format((float)(($sale[0]->grand_total-$sale[0]->tax) - ($product_cost-$product_tax) - ($return[0]->grand_total-$return[0]->tax) + ($purchase_return[0]->grand_total-$purchase_return[0]->tax) - $expense), 0, '.', '.') }}</h4>
					<p class="text-center">
						({{trans('file.Sale')}} Rp. {{number_format((float)($sale[0]->grand_total), 0, '.', '.')}} -
                        {{trans('file.Tax')}} Rp. {{number_format((float)($sale[0]->tax), 0, '.', '.')}}) -
                        ({{trans('file.Product Cost')}} Rp. {{number_format((float)($product_cost), 0, '.', '.')}} -
                        {{trans('file.Tax')}} Rp. {{number_format((float)($product_tax), 0, '.', '.')}}) -
                        ({{trans('file.Return')}} Rp. {{number_format((float)($return[0]->grand_total), 0, '.', '.')}} -
                        {{trans('file.Tax')}} Rp. {{number_format((float)($return[0]->tax), 0, '.', '.')}}) +
                        @if($general_setting->type === 'KbPeShVmYq3t6w9yBEHMcQfTjWnZ')
                            @if($general_setting->usaha_type === '1' || $general_setting->usaha_type === '2')
                                ({{trans('file.Purchase Return')}} Rp. {{number_format((float)($purchase_return[0]->grand_total), 0, '.', '.')}} -
                                {{trans('file.Tax')}} Rp. {{number_format((float)($purchase_return[0]->tax), 0, '.', '.')}}) -
                            @endif
                        @endif
                        ({{trans('file.Expense')}} Rp. {{number_format((float)($expense), 0, '.', '.')}})
					</p>
				</div>
			</div>
		</div>
		<div class="row mt-2">
			<div class="col-md-3">
				<div class="colored-box">
					<i class="fa fa-dollar"></i>
					<h3>{{trans('file.Payment Recieved')}}</h3>
					<hr>
					<div class="mt-3">
						<p class="mt-2">{{trans('file.Amount')}} <span class="float-right"> Rp. {{number_format((float)$payment_recieved, 0, '.', '.') }}</span></p>
						<p class="mt-2">{{trans('file.Recieved')}} <span class="float-right">{{number_format($payment_recieved_number,0,'.','.')}}</span></p>
						<p class="mt-2">Cash <span class="float-right">Rp. {{number_format((float)$cash_payment_sale, 0, '.', '.')}}</span></p>
						<p class="mt-2">Cheque <span class="float-right">Rp. {{number_format((float)$cheque_payment_sale, 0, '.', '.')}}</span></p>
						<p class="mt-2">Credit Card <span class="float-right">Rp. {{number_format((float)$credit_card_payment_sale, 0, '.', '.')}}</span></p>
						<p class="mt-2">Gift Card <span class="float-right">Rp. {{number_format((float)$gift_card_payment_sale, 0, '.', '.')}}</span></p>
						<p class="mt-2">Paypal <span class="float-right">Rp. {{number_format((float)$paypal_payment_sale, 0, '.', '.')}}</span></p>
						<p class="mt-2">Deposit <span class="float-right">Rp. {{number_format((float)$deposit_payment_sale, 0, '.', '.')}}</span></p>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="colored-box">
					<i class="fa fa-dollar"></i>
					<h3>{{trans('file.Payment Sent')}}</h3>
					<hr>
					<div class="mt-3">
						<p class="mt-2">{{trans('file.Amount')}} <span class="float-right"> Rp. {{number_format((float)$payment_sent, 0, '.', '.') }}</span></p>
						<p class="mt-2">{{trans('file.Recieved')}} <span class="float-right">{{number_format($payment_sent_number,0,'.','.')}}</span></p>
						<p class="mt-2">Cash <span class="float-right">Rp. {{number_format((float)$cash_payment_purchase, 0, '.', '.')}}</span></p>
						<p class="mt-2">Cheque <span class="float-right">Rp. {{number_format((float)$cheque_payment_purchase, 0, '.', '.')}}</span></p>
						<p class="mt-2">Credit Card <span class="float-right">Rp. {{number_format((float)$credit_card_payment_purchase, 0, '.', '.')}}</span></p>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="colored-box">
					<i class="fa fa-dollar"></i>
					<h3>{{trans('file.Expense')}}</h3>
					<hr>
					<div class="mt-3">
						<p class="mt-2">{{trans('file.Amount')}} <span class="float-right"> Rp. {{number_format((float)$expense, 0, '.', '.') }}</span></p>
						<p class="mt-2">{{trans('file.Expense')}} <span class="float-right">{{number_format($total_expense,0,'.','.')}}</span></p>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="colored-box">
					<i class="fa fa-dollar"></i>
					<h3>{{trans('file.Payroll')}}</h3>
					<hr>
					<div class="mt-3">
						<p class="mt-2">{{trans('file.Amount')}} <span class="float-right"> Rp. {{number_format((float)$payroll, 0, '.', '.') }}</span></p>
						<p class="mt-2">{{trans('file.Payroll')}} <span class="float-right">{{number_format($total_payroll,0,'.','.')}}</span></p>
					</div>
				</div>
			</div>
		</div>
		<div class="row mt-2">
			<div class="col-md-4 offset-md-4">
				<div class="colored-box">
					<i class="fa fa-dollar"></i>
					<h3>{{trans('file.Cash in Hand')}}</h3>
					<hr>
					<div class="mt-3">
						<p class="mt-2">{{trans('file.Recieved')}} <span class="float-right"> Rp. {{number_format((float)($payment_recieved), 0, '.', '.') }}</span></p>
						<p class="mt-2">{{trans('file.Sent')}} <span class="float-right">- Rp. {{number_format((float)($payment_sent), 0, '.', '.') }}</span></p>
						<p class="mt-2">{{trans('file.Sale Return')}} <span class="float-right">- Rp. {{number_format((float)$return[0]->grand_total, 0, '.', '.')}}</span></p>
                        @if($general_setting->type === 'KbPeShVmYq3t6w9yBEHMcQfTjWnZ')
                            @if($general_setting->usaha_type === '1' || $general_setting->usaha_type === '2')
                                <p class="mt-2">{{trans('file.Purchase Return')}} <span class="float-right"> Rp. {{number_format((float)$purchase_return[0]->grand_total, 0, '.', '.')}}</span></p>
                            @endif
                        @endif
						<p class="mt-2">{{trans('file.Expense')}} <span class="float-right">- Rp. {{number_format((float)$expense, 0, '.', '.')}}</span></p>
						<p class="mt-2">{{trans('file.Payroll')}} <span class="float-right">- Rp. {{number_format((float)$payroll, 0, '.', '.')}}</span></p>
						<p class="mt-2">{{trans('file.In Hand')}} <span class="float-right">Rp. {{number_format((float)($payment_recieved - $payment_sent - $return[0]->grand_total + $purchase_return[0]->grand_total - $expense - $payroll), 0, '.', '.') }}</span></p>
					</div>
				</div>
			</div>
		</div>
		<div class="row mt-4 justify-content-center">
			@foreach($warehouse_name as $key => $name)
				<div class="col-md-4">
					<div class="colored-box">
						<i class="fa fa-money"></i>
						<h3>{{$name}}</h3>
						<h4 class="text-center mt-3">Rp. {{number_format((float)($warehouse_sale[$key][0]->grand_total - $warehouse_purchase[$key][0]->grand_total - $warehouse_return[$key][0]->grand_total + $warehouse_purchase_return[$key][0]->grand_total), 0, '.', '.') }}</h4>
						<p class="text-center">
							{{trans('file.Sale')}}
                            Rp. {{number_format((float)($warehouse_sale[$key][0]->grand_total), 0, '.', '.')}} -
                            @if($general_setting->type === 'KbPeShVmYq3t6w9yBEHMcQfTjWnZ')
                                @if($general_setting->usaha_type === '1' || $general_setting->usaha_type === '2')
                                    {{trans('file.Purchase')}} Rp. {{number_format((float)($warehouse_purchase[$key][0]->grand_total), 0, '.', '.')}} -
                                    {{trans('file.Purchase Return')}} Rp. {{number_format((float)($warehouse_purchase_return[$key][0]->grand_total), 0, '.', '.')}} +
                                @endif
                            @endif
                            {{trans('file.Sale Return')}} Rp. {{number_format((float)($warehouse_return[$key][0]->grand_total), 0, '.', '.')}}
						</p>
						<hr style="border-color: rgba(0, 0, 0, 0.2);">
						<h4 class="text-center">Rp. {{number_format((float)(($warehouse_sale[$key][0]->grand_total - $warehouse_sale[$key][0]->tax) - ($warehouse_purchase[$key][0]->grand_total - $warehouse_purchase[$key][0]->tax) - ($warehouse_return[$key][0]->grand_total - $warehouse_return[$key][0]->tax) + ($warehouse_purchase_return[$key][0]->grand_total - $warehouse_purchase_return[$key][0]->tax) ), 0, '.', '.') }}</h4>
						<p class="text-center">
							 {{trans('file.Net Sale')}} Rp. {{number_format((float)($warehouse_sale[$key][0]->grand_total - $warehouse_sale[$key][0]->tax), 0, '.', '.')}} -
                             @if($general_setting->type === 'KbPeShVmYq3t6w9yBEHMcQfTjWnZ')
                                @if($general_setting->usaha_type === '1' || $general_setting->usaha_type === '2')
                                    {{trans('file.Net Purchase')}} Rp. {{number_format((float)($warehouse_purchase[$key][0]->grand_total - $warehouse_purchase[$key][0]->tax), 0, '.', '.')}} -
                                    {{trans('file.Net Purchase Return')}} Rp. {{number_format((float)($warehouse_purchase_return[$key][0]->grand_total - $warehouse_purchase_return[$key][0]->tax), 0, '.', '.')}} +
                                @endif
                            @endif
                             {{trans('file.Net Sale Return')}} Rp. {{number_format((float)($warehouse_return[$key][0]->grand_total - $warehouse_return[$key][0]->tax), 0, '.', '.')}}
						</p>
						<hr style="border-color: rgba(0, 0, 0, 0.2);">
						<h4 class="text-center">Rp. {{number_format((float)$warehouse_expense[$key], 0, '.', '.') }}</h4>
						<p class="text-center">{{trans('file.Expense')}}</p>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</section>

@endsection

@push('scripts')
<script type="text/javascript">

	$("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report #profit-loss-report-menu").addClass("active");

	$(".daterangepicker-field").daterangepicker({
	  callback: function(startDate, endDate, period){
	    var start_date = startDate.format('YYYY-MM-DD');
	    var end_date = endDate.format('YYYY-MM-DD');
	    var title = start_date + ' To ' + end_date;
	    $(this).val(title);
	    $('input[name="start_date"]').val(start_date);
	    $('input[name="end_date"]').val(end_date);
	  }
	});
</script>
@endpush
