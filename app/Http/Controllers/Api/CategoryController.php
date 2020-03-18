<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JWTAuth;
use DB;
use Log;


class CategoryController extends Controller
{
	public function __construct()
    {
        $this->middleware('jwt.verify', ['except' => ['login']]);
    }
    public function category(Request $request){
    	$data = DB::table('categories')->get();
    	return response()->json(['status'=>0, 'message'=>'Success', 'data'=>$data]);
    }

    public function add (Request $request){
    	$data = [];
    	foreach ($request->all() as $key => $value) {
    		$data[$key] = $value;
    	}
    	DB::table('categories')->insert($data);
    	return response()->json(['status'=>0, 'message'=>'Category insert Success', 'data'=>$data]);
    }

    public function edit (Request $request){
    	$data = [];
    	foreach ($request->all() as $key => $value) {
    		$data[$key] = $value;
    	}
    	DB::table('categories')->where('id',$request->id)->update($data);
    	return response()->json(['status'=>0, 'message'=>'Category update Success', 'data'=>$data]);
    }

    public function delete($id){
    	DB::table('categories')->where('id',$id)->delete();
    	return response()->json(['status'=>0, 'message'=>'Category delete Success', 'data'=>'']);
    }
}
