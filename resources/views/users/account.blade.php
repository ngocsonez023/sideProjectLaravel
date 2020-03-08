@extends('layouts.frontLayout.front_design')
@section('content')

<section id="form" style="margin-top:20px;"><!--form-->
    <div class="container">
        <div class="row">
            @if(Session::has('flash_message_error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{ session('flash_message_error') }}</strong>
            </div>
            @endif
            @if(Session::has('flash_message_success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{ session('flash_message_success') }}</strong>
            </div>
            @endif
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">Accounts</li>
                </ol>
            </div>
            <div class="col-sm-4 col-sm-offset-1">
                <div class="login-form">
                    <h2>Update Account</h2>
                    <form id="accountForm" name="accountForm" action="{{url('/account')}}" method="post"> {{csrf_field()}}
                        <div class="form-group">
                            <label>Họ và tên</label>
                            <input value="{{$userDetails->name}}" type="text" name="name" id="name" placeholder="Name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input value="{{$userDetails->email}}" type="text" name="email" id="email" placeholder="Email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>SĐT</label>
                            <input value="{{$userDetails->mobile}}" type="text" name="mobile" id="mobile" placeholder="Mobile" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Tỉnh/thành phố</label>
                            <select name="country" id="country" class="form-control">
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                <option value="{{$country->countries_name}}" @if($country->countries_name == $userDetails->country) selected @endif>
                                    {{$country->countries_name}}</option>
                                    @endforeach
                                </select> 
                            </div>
                            <div class="form-group">
                                <label>Quận/Huyện</label>
                                <select name="state" id="state" class="form-control" style="">
                                    @foreach($result['zones'] as $value)
                                    <option value="{{$value->zone_name}}" @if(!empty($userDetails->state) && $value->zone_name == $userDetails->state) selected @endif>{{$value->zone_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Phường xã</label>                        
                                <select name="city" id="city" class="form-control">
                                    @foreach($result['wards'] as $value)
                                    <option value="{{$value->name}}" @if(!empty($userDetails->city) && $value->name == $userDetails->city) selected @endif>{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Số nhà</label>                        
                                <input value="{{$userDetails->address}}" type="text" name="address" id="address" placeholder="Address" class="form-control">
                                <input style="display: none;" value="{{$userDetails->pincode}}" type="text" name="pincode" id="pincode" placeholder="Address" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-default">Update</button>
                        </form>
                    </div>
                </div>
                <div class="col-sm-1">
                    <h2 class="or">OR</h2>
                </div>
                <div class="col-sm-4">
                    <div class="signup-form">
                        <h2>Update Password</h2>
                        <form class="passwordForm" name="passwordForm" action="{{url('/update-user-pwd')}}" method="POST">{{csrf_field()}}
                            <div class="form-group">
                                <label>Số nhà</label>
                                <input type="password" name="current_pwd" id="current_pwd" placeholder="Current Password" required="required" class="form-control">
                            </div>
                            <span id="chkPwd"></span>
                            <div class="form-group">
                                <label>Số nhà</label>
                                <input type="password" name="new_pwd" id="new_pwd" placeholder="New Password" required="required" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Số nhà</label>
                                <input type="password" name="confirm_pwd" id="confirm_pwd" placeholder="Confirm Password" required="required" class="form-control">
                            </div>
                            <span id="con_pwd"></span>
                            <button type="submit" class="btn btn-default">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section><!--/form-->
    <script>
        var password = document.getElementById("new_pwd")
        , confirm_password = document.getElementById("confirm_pwd");

        function validatePassword(){
          if(new_pwd.value != confirm_pwd.value) {
            confirm_pwd.setCustomValidity("Passwords Don't Match");
        } else {
            confirm_pwd.setCustomValidity('');
        }
    }

    new_pwd.onchange = validatePassword;
    confirm_pwd.onkeyup = validatePassword;

    // get address
    jQuery(document).on('change', '#country', function () {
        var data = jQuery("#country").val();
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
                jQuery("#state").html(zonesShow);  
                jQuery("#city").html(wardsShow);  
            },
            error: function (e) {
                console.log("ERROR : ", e);
            }
        });
    });

    jQuery(document).on('click', '#state', function () {
        var data = jQuery("#state").val();
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
                jQuery("#city").html(wardsShow);  
            },
            error: function (e) {
                console.log("ERROR : ", e);
            }
        });
    });
</script>
@endsection