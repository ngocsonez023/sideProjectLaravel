<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Auth;
use App\Order;
use App\User;
use DB;
use Log;

class OrderController extends Controller
{
    public function order(){
    	$data = DB::table('orders')->get();
    	return response()->json(['status'=>0, 'message'=> 'Success', 'data'=> $data]);
    }

    public function view (Request $request){
    	$data['order'] = Order::with('orders')->where('id',$request->id)->first();
    	$data['user'] = User::where('id',Auth::user())->first();
    	return response()->json(['status'=>0, 'message'=>'Success', 'data'=>$data]);
    }

    public function update (Request $request){
    	$data = Order::where('id',$request->id)->update(['order_status'=>$request->order_status]);
    	return response()->json(['status'=>0, 'message'=>'order update Success', 'data'=>$data]);
    }

    public function delete($id){
    	$data = Order::where('id',$id)->delete();
    	return response()->json(['status'=>0, 'message'=>'order delete Success', 'data'=> $data]);
    }
}
