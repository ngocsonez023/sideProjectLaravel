<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Oders;
use App\Oders_detail;
use DB;
use Carbon\Carbon;

class OdersController extends Controller
{
    public function getlist()
    {
    	$data = Oders::paginate(10);
    	return view('back-end.oders.list',['data'=>$data]);
    }

    public function getdetail($id)
    {
    	$oder = Oders::where('id',$id)->first();
    	$data = DB::table('oders_detail')
    			 	->Leftjoin('products', 'products.id', '=', 'oders_detail.pro_id')
                    ->Leftjoin('products_sale', 'products_sale.id_product', '=', 'products.id')
                    ->select('oders_detail.*','products.*','products_sale.id','products_sale.price_sale','products_sale.sale_status','products_sale.start_date','products_sale.end_date')
    			 	->groupBy('oders_detail.id')
    			 	->where('o_id',$id)
    			 	->get();
        $timenow = Carbon::now('Asia/Ho_Chi_Minh');
    	return view('back-end.oders.detail',['data'=>$data,'oder'=>$oder,'timenow'=>$timenow]);
    }
    public function postdetail($id)
    {
    	$oder = Oders::find($id);

    	$oder->status = 1;
    	$oder->save();
    	return redirect('admin/donhang')
      	->with(['flash_level'=>'result_msg','flash_massage'=>' Đã xác nhận đơn hàng thành công !']);    	

    }
     public function getdel($id)
    {       
    	$oder = Oders::where('id',$id)->first();
    	if ($oder->status ==1) {
    		return redirect()->back()
    		->with(['flash_level'=>'result_msg','flash_massage'=>'Không thể hủy đơn hàng số: '.$id.' vì đã được xác nhận!']);
    	} else {
    		$oder = Oders::find($id);
        	$oder->delete();
        	return redirect('admin/donhang')
         	->with(['flash_level'=>'result_msg','flash_massage'=>'Đã hủy bỏ đơn hàng số:  '.$id.' !']);
     	}
    }
}
