<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JWTAuth;
use DB;
use Log;

class CouponController extends Controller
{
    public function coupon(){
    	$data = DB::table('coupons')->get();
    	return response()->json(['status'=>0, 'message'=> 'Success', 'data'=> $data]);
    }

    public function add (Request $request){
    	$data = [];
    	foreach ($request->all() as $key => $value) {
    		$data[$key] = $value;
    	}
    	DB::table('coupons')->insert($data);
    	return response()->json(['status'=>0, 'message'=>'coupon insert Success', 'data'=>$data]);
    }

    public function edit (Request $request){
    	$data = [];
    	foreach ($request->all() as $key => $value) {
    		$data[$key] = $value;
    	}
    	DB::table('coupons')->where('id',$request->id)->update($data);
    	return response()->json(['status'=>0, 'message'=>'coupon update Success', 'data'=>$data]);
    }

    public function delete($id){
    	DB::table('coupons')->where('id',$id)->delete();
    	return response()->json(['status'=>0, 'message'=>'coupon delete Success', 'data'=>'']);
    }
}
