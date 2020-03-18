<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use JWTAuth;
use Auth;
use DB;
use Log;

class ProductController extends Controller
{
    public function product(){
    	$data = Product::get();
    	return response()->json(['status'=>0, 'message'=>'Success', 'data'=> $data]);
    }

    public function add(Request $request) {
    	$data = [];
    	foreach ($request->all() as $key => $value) {
    		$data[$key] = $value;
    		if ($key == 'image') {
    			$image_tmp = $request->file($key);
    			$extension = $image_tmp->getClientOriginalExtension();
                $filename = rand(111,99999).'.'.$extension;
                $data['image'] = $filename;
    		}
    	}
    	DB::table('products')->insert($data);
    	return response()->json(['status'=>0, 'message'=>'Success', 'data'=> $data]);
    }

    public function edit(Request $request){
    	$data = [];
    	foreach ($request->all() as $key => $value) {
    		$data[$key] = $value;
    		if ($key == 'image') {
    			$image_tmp = $request->file($key);
    			$extension = $image_tmp->getClientOriginalExtension();
                $filename = rand(111,99999).'.'.$extension;
                $data['image'] = $filename;
    		}
    	}
    	DB::table('products')->where('id',$request->id)->update($data);
    	return response()->json(['status'=>0, 'message'=>'Success', 'data'=> $data]);
    }

    public function delete($id){
    	DB::table('products')->where('id',$id)->delete();
    	return response()->json(['status'=>0, 'message'=>'Success', 'data'=> '']);
    }
}
