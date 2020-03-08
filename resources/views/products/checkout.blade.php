@extends('layouts.frontLayout.front_design')
@section('content')

<section id="form" style="margin-top:20px;"> <!--form-->
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Check Out</li>
            </ol>
        </div>
        @if(Session::has('flash_message_error'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{ session('flash_message_error') }}</strong>
        </div>
        @endif
        <form action="{{url('/checkout')}}" method="POST"> {{csrf_field()}}
            <div class="row">
                <div class="col-sm-4 col-sm-offset-1">
                    <div class="login-form"><!--login form-->
                        <h2>Bill To</h2>
                        <div class="form-group">
                            <label>Họ và tên</label>
                            <input name="billing_name" id="billing_name" @if(!empty($userDetails->name)) value="{{$userDetails->name}}" @endif 
                            type="text" placeholder="Billing Name" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Số điện thoại</label>
                            <input name="billing_mobile" id="billing_mobile" @if(!empty($userDetails->mobile)) value="{{$userDetails->mobile}}" @endif
                            type="text" placeholder="Billing Mobile" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>Tỉnh/Thành phố</label>
                            <select name="billing_country" id="billing_country" class="form-control">
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                <option value="{{$country->countries_name}}" 
                                    @if(!empty($userDetails->country) && $country->countries_name == $userDetails->country) selected @endif>
                                    {{$country->countries_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Quận/huyện</label>
                                <select name="billing_state" id="billing_state" class="form-control">
                                    @foreach($result['zones'] as $value)
                                        <option value="{{$value->zone_name}}" @if(!empty($userDetails->state) && $value->zone_name == $userDetails->state) selected @endif>{{$value->zone_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Phường/xã</label>
                                <select name="billing_city" id="billing_city" class="form-control">
                                    @foreach($result['wards'] as $value)
                                        <option value="{{$value->name}}" @if(!empty($userDetails->city) && $value->name == $userDetails->city) selected @endif>{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Số nhà</label>
                                <input name="billing_address" id="billing_address" @if(!empty($userDetails->address)) value="{{$userDetails->address}}" @endif 
                                type="text" placeholder="Billing Address" class="form-control"/>
                            </div>
                            <div class="form-group" style="display: none;">
                                <input type="text" name="billing_pincode" id="billing_pincode" @if(!empty($userDetails->pincode)) value="{{$userDetails->pincode}}" @endif
                                placeholder="Billing Pincode" class="form-control"/>
                            </div>
                            <div class="form-check">
                                <input value="{{$userDetails->name}}" type="checkbox" class="form-check-input" id="billtoship">
                                <label class="form-check-label" for="billtoship">Shipping Address Same As Billing Address</label>
                            </div>
                        </div><!--/login form-->
                    </div>
                    <div class="col-sm-1">
                        <h2></h2>
                    </div>
                    <div class="col-sm-4">
                        <div class="signup-form"><!--sign up form-->
                            <h2>Ship To</h2>
                            <div class="form-group">
                                <label>Họ và tên</label>
                                <input type="text" name="shipping_name" id="shipping_name" @if(!empty($shippingDetails->name)) value="{{$shippingDetails->name}}" @endif placeholder="Shipping Name" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="text" name="shipping_mobile" id="shipping_mobile" @if(!empty($shippingDetails->mobile)) value="{{$shippingDetails->mobile}}" @endif placeholder="Shipping Mobile" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label>Tỉnh/Thành phố</label>
                                <select name="shipping_country" id="shipping_country" class="form-control">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                    <option value="{{$country->countries_name}}"@if(!empty($shippingDetails->country) && $country->countries_name == $shippingDetails->country) selected @endif>
                                        {{$country->countries_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Quận/huyện</label>
                                    <select name="shipping_state" id="shipping_state" class="form-control">
                                        @foreach($result['zones'] as $value)
                                            <option value="{{$value->zone_name}}" @if(!empty($shippingDetails->state) && $value->zone_name == $shippingDetails->state) selected @endif>{{$value->zone_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Phường/xã</label>
                                    <select name="shipping_city" id="shipping_city" class="form-control">
                                        @foreach($result['wards'] as $value)
                                            <option value="{{$value->name}}" @if(!empty($shippingDetails->city) && $value->name == $shippingDetails->city) selected @endif>{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Số nhà</label>
                                    <input type="text" name="shipping_address" id="shipping_address" @if(!empty($shippingDetails->address)) value="{{$shippingDetails->address}}" @endif placeholder="Shipping Address" class="form-control"/>
                                </div>
                                <div class="form-group" style="display: none;">
                                    <input type="text" name="shipping_pincode" id="shipping_pincode" @if(!empty($shippingDetails->pincode)) value="{{$shippingDetails->pincode}}" @endif placeholder="Shipping Pincode" class="form-control"/>
                                </div>
                                <button type="submit" class="btn btn-mini check_out">CheckOut</button>
                            </div><!--/sign up form-->
                        </div>
                    </div>
                </form>
            </div>
        </section><!--/form-->
        <script type="text/javascript">
        // get address
        jQuery(document).on('change', '#billing_country', function () {
            var data = jQuery("#billing_country").val();
            jQuery.ajax({
                type: "get",
                url: '{{ URL::to("/getaddress")}}',
                data: 'data='+data,
                success: function (res) {
                    var zonesShow = [];
                    var wardsShow = [];
                    for (var i = 0 ; i < res.zones.length ; i++ ) {
                        var item_zone = `<option value="${res.zones[i].zone_name}">${res.zones[i].zone_name}</option>`;
                        zonesShow.push(item_zone);
                    }
                    for (var i = 0 ; i < res.wards.length ; i++ ) {
                        var item_ward = `<option value="${res.wards[i].name}">${res.wards[i].name}</option>`;
                        wardsShow.push(item_ward);
                    }
                    jQuery("#billing_state").html(zonesShow);  
                    jQuery("#billing_city").html(wardsShow);  
                },
                error: function (e) {
                    console.log("ERROR : ", e);
                }
            });
        });

        jQuery(document).on('click', '#shipping_country', function () {
            var data = jQuery("#shipping_country").val();
            jQuery.ajax({
                type: "get",
                url: '{{ URL::to("/getaddress")}}',
                data: 'data='+data,
                success: function (res) {
                    var zonesShow = [];
                    var wardsShow = [];
                    for (var i = 0 ; i < res.zones.length ; i++ ) {
                        var item_zone = `<option value="${res.zones[i].zone_name}">${res.zones[i].zone_name}</option>`;
                        zonesShow.push(item_zone);
                    }
                    for (var i = 0 ; i < res.wards.length ; i++ ) {
                        var item_ward = `<option value="${res.wards[i].name}">${res.wards[i].name}</option>`;
                        wardsShow.push(item_ward);
                    }
                    jQuery("#shipping_state").html(zonesShow);  
                    jQuery("#shipping_city").html(wardsShow);  
                },
                error: function (e) {
                    console.log("ERROR : ", e);
                }
            });
        });

        jQuery(document).on('click', '#billing_state', function () {
            var data = jQuery("#billing_state").val();
            jQuery.ajax({
                type: "get",
                url: '{{ URL::to("/getward")}}',
                data: 'data='+data,
                success: function (res) {
                    var wardsShow = [];
                    for (var i = 0 ; i < res.wards.length ; i++ ) {
                        var item_ward = `<option value="${res.wards[i].name}">${res.wards[i].name}</option>`;
                        wardsShow.push(item_ward);
                    }  
                    jQuery("#billing_city").html(wardsShow);  
                },
                error: function (e) {
                    console.log("ERROR : ", e);
                }
            });
        });

        jQuery(document).on('click', '#shipping_state', function () {
            var data = jQuery("#shipping_state").val();
            jQuery.ajax({
                type: "get",
                url: '{{ URL::to("/getward")}}',
                data: 'data='+data,
                success: function (res) {
                    var wardsShow = [];
                    for (var i = 0 ; i < res.wards.length ; i++ ) {
                        var item_ward = `<option value="${res.wards[i].name}">${res.wards[i].name}</option>`;
                        wardsShow.push(item_ward);
                    }  
                    jQuery("#shipping_city").html(wardsShow);  
                },
                error: function (e) {
                    console.log("ERROR : ", e);
                }
            });
        });
    </script>
    @endsection