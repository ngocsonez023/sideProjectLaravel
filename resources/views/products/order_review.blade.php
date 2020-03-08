@extends('layouts.frontLayout.front_design')
@section('content')

<section id="form" style="margin-top:20px;">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Order Review</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-sm-4 col-sm-offset-1">
                <div class="login-form">
                    <h2>Bill Address</h2>
                    <div class="form-group">
                        {{$userDetails->name}}
                    </div>
                    <div class="form-group">
                        {{$userDetails->address}}
                    </div>
                    <div class="form-group">
                     {{$userDetails->city}}
                 </div>
                 <div class="form-group">
                    {{$userDetails->state}}
                </div>
                <div class="form-group">
                    {{$userDetails->country}}
                </div>
                <div class="form-group">
                    {{$userDetails->pincode}}
                </div>
                <div class="form-group">
                    {{$userDetails->mobile}}
                </div>
            </div>
        </div>
        <div class="col-sm-1">
            <h2></h2>
        </div>
        <div class="col-sm-4">
            <div class="signup-form">
                <h2>Shipping Details</h2>
                <div class="form-group">
                    {{$shippingDetails->name}}
                </div>
                <div class="form-group">
                    {{$shippingDetails->address}}
                </div>
                <div class="form-group">
                    {{$shippingDetails->city}}
                </div>
                <div class="form-group">
                    {{$shippingDetails->state}}
                </div>
                <div class="form-group">  
                    {{$shippingDetails->country}}
                </div>
                <div class="form-group">
                    {{$shippingDetails->pincode}}
                </div>
                <div class="form-group">
                    {{$shippingDetails->mobile}}
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<section id="cart_items" style="margin-top:-200px;" >
    <div class="container">

        <div class="shopper-informations">
            <div class="row">					
            </div>
        </div>

        <div class="review-payment">
            <h2>Review & Payment</h2>
        </div>

        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Item</td>
                        <td class="description"></td>
                        <td class="price">Price</td>
                        <td class="quantity">Quantity</td>
                        <td class="total">Total</td>
                    </tr>
                </thead>
                <tbody>
                    <?php $total_amount =0; ?>
                    @foreach($userCart as $cart) 
                    <tr>
                        <td class="cart_product">
                            <a href=""><img style="width:80px;" src="{{asset('images/backend_img/products/small/'.$cart->image)}}" alt=""></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{$cart->product_name}}</a></h4>
                            <p>Product Code: {{$cart->product_code}} | Size: {{$cart->size}}</p>
                        </td>
                        <td class="cart_price">
                            <p>PKR {{$cart->price}}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <p>{{$cart->quantity}}</p>
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">PKR {{$cart->price*$cart->quantity}}</p>
                        </td>
                    </tr>
                    <?php $total_amount = $total_amount + ($cart->price*$cart->quantity);?>
                    @endforeach
                    <tr>
                        <td colspan="4">&nbsp;</td>
                        <td colspan="2">
                            <table class="table table-condensed total-result">
                                <tr>
                                    <td>Cart Sub Total</td>
                                    <td>PKR {{$total_amount}}</td>
                                </tr>
                                <tr class="shipping-cost">
                                    <td>Shipping Cost (+)</td>
                                    <td>PKR 0</td>										
                                </tr>
                                <tr class="shipping-cost">
                                    <td>Discount Amount (-)</td>
                                    <td>
                                        @if(!empty(Session::get('CouponAmount')))
                                        PKR {{Session::get('CouponAmount')}}
                                        @else
                                        PKR 0
                                        @endif
                                    </td>										
                                </tr>
                                <tr>
                                    <td>Phí giao hàng</td>
                                    <td>
                                        @if (!empty(session('delivery_fee')))                                                    
                                        <label>{{ session('delivery_fee') }} vnd</label>
                                        @else
                                        <label >--- Unsupport</label>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Grand Total</td>
                                    <?php 
                                    $grand_total = $total_amount - Session::get('CouponAmount') + session('delivery_fee');
                                    session(['total_price'=>$grand_total]); ?>
                                    <td><span>PKR {{Session::get('total_price')}}</span></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <form name="paymentForm" id="paymentForm" action="{{url('/place-order')}}" method="post"> {{csrf_field()}}
            <input type="hidden" name="grand_total" value="{{$grand_total}}">
            <div class="payment-options">
                <span>
                    <label><strong>Select Payment Method: </strong></label>
                </span>
                <span>
                    <label><input onClick="paymentMethods();" type="radio" name="payment_method" class="payment_method" value="COD"><strong> Cash on Delivery (COD) </strong></label>
                </span>
                <span>
                    <label><input onClick="paymentMethods();" type="radio" name="payment_method" class="payment_method" value="momopay"><strong>MOMO</strong></label>
                </span>
                <span>
                    <label><input onClick="paymentMethods();" type="radio" name="payment_method" class="payment_method" value="nganluongpay"><strong>NGUAN LUONG</strong></label>
                </span>
                <span style="float:right;">
                    <button id="COD_button" class="btn btn-mini check_out cod payment_btns" onclick="return selectPaymentMethod();">Giao hàng nhận tiền</button>
                    <span style="display: none;" id="momopay_button" class="bg-payfor btn btn-dark check_out payment_btns">Thanh toán Momo</span>
                    <span style="display: none;" id="nganluongpay_button" class="check_out payment_btns">
                        <a href="{{ $result['payment_methods'][2]['nganluong_apipoint'] }}">Thanh toán Ngân Lượng</a>
                    </span>
                </span>
                
            </div>
        </form>
    </div>
</section> <!--/#cart_items-->

<script type="text/javascript">
     //paymentMethods
     function paymentMethods() {
        var payment_method = jQuery(".payment_method:checked").val();
        jQuery(".payment_btns").hide();
        jQuery("#" + payment_method + '_button').show();
        jQuery.ajax({
            url: '{{ URL::to("/paymentComponent")}}',
            type: "get",
            data: '&payment_method=' + payment_method,
            success: function (res) {
                console.log(res);
            },
        });
    }
    // cod
    jQuery(document).on('click', '#COD', function (e) {
        jQuery("#paymentForm").submit();
    });
    // momo
    jQuery(document).on('click', '#momopay_button', function () {
        const data = <?= isset($result['payment_methods'][1]['momopay_data']) ? json_encode($result['payment_methods'][1]['momopay_data']) : '{}' ?>;
        jQuery.post("{{ isset($result['payment_methods'][1]['momopay_apipoint']) ? $result['payment_methods'][1]['momopay_apipoint'] : '' }}", JSON.stringify(data)).then(function (res) {
            if (res.errorCode == 0) {
                window.location = res.payUrl;
            }
        });
    });


</script>

@endsection