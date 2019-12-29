<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\Products;
use App\Sale;
use App\Category;
use App\Pro_detail;
use App\News;
use App\Wishlist;
use App\Oders;
use App\Oders_detail;
use DB,Cart,Datetime;
use Carbon\Carbon;
use log;


class PagesController extends Controller
{
    public function index()
    {
        // mobile
        $products = DB::table('products')
                ->Leftjoin('category', 'products.cat_id', '=', 'category.id')
                ->Leftjoin('products_sale', 'products_sale.id_product', '=', 'products.id')
                ->Leftjoin('wishlist', 'products.id', '=', 'wishlist.pro_id')
                ->where('products.status','=','1')
                ->where('products_sale.sale_status','=','ON')
                ->select('products.*','products_sale.price_sale','products_sale.sale_status','products_sale.start_date','products_sale.end_date','wishlist.pro_id')
                ->take(15)
                ->get();
        $products_new = DB::table('products')
                ->Leftjoin('category', 'products.cat_id', '=', 'category.id')
                ->Leftjoin('products_sale', 'products_sale.id_product', '=', 'products.id')
                ->Leftjoin('wishlist', 'products.id', '=', 'wishlist.pro_id')
                ->where('products.status','=','1')
                ->orderBy('products.id','DESC')
                ->select('products.*','products_sale.price_sale','products_sale.sale_status','products_sale.start_date','products_sale.end_date','wishlist.pro_id','wishlist.user_id')
                ->get();
        $timenow = Carbon::now('Asia/Ho_Chi_Minh');

    	return view('home',['products'=>$products,'timenow'=>$timenow,'products_new'=>$products_new]);
    }
    public function view_wishlist(){
        if (Auth::guest()) {
            return redirect('login');
        }
        $wish = DB::table('products')
                    ->Leftjoin('wishlist','wishlist.pro_id','=','products.id')
                    ->get();
         return view('detail.wish',compact('wish'));
    }
    public function addwishlist(Request $request){
        if (Auth::guest()) {
            return redirect('login');
        }
        // $products = Products::find($id);
        $wishlist = new Wishlist();
        $wishlist->user_id=Auth::user()->id;
        $wishlist->pro_id=$request->pro_id;
        $wishlist->save();

        $products= DB::table('products')->where('id',$request->pro_id)->get();
        return redirect()->back() ->with('alert', 'Đã thêm vào yêu thích!');
    }
    public function getdeletewish($id)
    {
        $abc = DB::table('Wishlist')->where('id','=',$id)->delete();
        return redirect('yeu-thich')
         ->with(['flash_level'=>'result_msg','flash_massage'=>'Đã xóa !']);
    }
    public function addcart($id)
    {
        // $pro = Products::where('id',$id)->first();
        $timenow = Carbon::now('Asia/Ho_Chi_Minh');
        $pro = DB::table('products')
                ->Leftjoin('category', 'products.cat', '=', 'category.name')
                ->Leftjoin('products_sale', 'products_sale.id_product', '=', 'products.id')
                ->where('products.id',$id)
                 ->select('products.*','products_sale.price_sale','products_sale.sale_status','products_sale.start_date','products_sale.end_date')
                ->first();
            if(isset($pro->price_sale) && $pro->sale_status == 'ON' && $pro->start_date < $timenow && $pro->end_date > $timenow){
                Cart::add(['id' => $pro->id, 'name' => $pro->name, 'qty' => 1, 'price' => $pro->price_sale,'options' => ['img' => $pro->images]]);
            }
            else{
                Cart::add(['id' => $pro->id, 'name' => $pro->name, 'qty' => 1, 'price' => $pro->price,'options' => ['img' => $pro->images]]);
            }
        // if($pro->price_sale){
        //     Cart::add(['id' => $pro->id_product, 'name' => $pro->name, 'qty' => 1, 'price_sale' => $pro->price_sale,'options' => ['img' => $pro->images]]);
        // }
        // else{
        //      Cart::add(['id' => $pro->id, 'name' => $pro->name, 'qty' => 1, 'price' => $pro->price,'options' => ['img' => $pro->images]]);
        // }
        return response()->json(['id' => $pro->id, 'name' => $pro->name, 'qty' => 1, 'price' => $pro->price,'options' => ['img' => $pro->images]]);
    }


    public function getupdatecart($id,$qty,$dk)
    {
      if ($dk=='up') {
         $qt = $qty+1;
         Cart::update($id, $qt);
         return redirect()->route('getcart');
      } elseif ($dk=='down') {
         $qt = $qty-1;
         Cart::update($id, $qt);
         return redirect()->route('getcart');
      } else {
         return redirect()->route('getcart');
      }
    }
    public function getdeletecart($id)
    {
     Cart::remove($id);
     return redirect()->route('getcart');
    }
    public function xoa()
    {
        Cart::destroy();   
        return redirect()->route('index');   
    }
    public function getcart()
    {   
    	return view('detail.card')->with('slug','Chi tiết đơn hàng');
    }
    public function getoder()
    {
        if (Auth::guest()) {
            return redirect('login');
        } else {

            return view ('detail.oder')
            ->with('slug','Xác nhận');
        }        
    }
    public function postoder(Request $rq)
    {
        $oder = new Oders();
        $total = 0;
        foreach (Cart::content() as $row) {
            $total = $total + ( $row->qty * $row->price);
        }
        $oder->c_id = Auth::user()->id;
        $oder->qty = Cart::count();
        $oder->sub_total = floatval($total);
        $oder->total =  floatval($total);
        $oder->note = $rq->txtnote;
        $oder->status = 0;
        $oder->type = 'cod';
        $oder->created_at = new datetime;
        $oder->save();
        $o_id =$oder->id;

        foreach (Cart::content() as $row) {
           $detail = new Oders_detail();
           $detail->pro_id = $row->id;
           $detail->qty = $row->qty;
           $detail->o_id = $o_id;
           $detail->created_at = new datetime;
           $detail->save();
        }
       
        Cart::destroy();   
        return redirect()->route('getcart')
        ->with(['flash_level'=>'result_msg','flash_massage'=>' Đơn hàng của bạn đã được gửi đi !']);    
        
    }
    public function getcate($cat)
    {
    	if ($cat == 'mobile') {
            // mobile
            $mobile = DB::table('products')
                ->join('category', 'products.cat_id', '=', 'category.id')

                ->select('products.*')
                ->paginate(12);
    		return view('category.mobile',['data'=>$mobile]);
    	} 
        elseif ($cat == 'laptop') {
            // mobile
            $lap = DB::table('products')
                ->join('category', 'products.cat_id', '=', 'category.id')

                ->select('products.*')
                ->paginate(12);
            return view('category.laptop',['data'=>$lap]);
        }
        elseif ($cat == 'pc') {
            // mobile
        $pc = DB::table('products')
                ->join('category', 'products.cat_id', '=', 'category.id')

                ->select('products.*')
                ->paginate(8);
            return view('category.pc',['data'=>$pc]);
        }
        elseif ($cat == 'tin-tuc') {
            $new =  DB::table('news')
                    ->orderBy('created_at', 'desc')
                    ->paginate(3);
            $top1 = $new->shift();
             $all =  DB::table('news')
                    ->orderBy('created_at', 'desc')
                    ->paginate(5);
            return view('category.news',['data'=>$new,'hot1'=>$top1,'all'=>$all]);
        } 
        // else{
        //     return redirect()->route('index');
        // }
    }
    public function detail($cat,$id,$slug)
    {
        if ($cat =='tin-tuc') {
            $new = News::where('id',$id)->first();
            return view('detail.news',['data'=>$new,'slug'=>$slug]);
        } 
        elseif ($cat =='mobile') {
            $mobile = DB::table('products')
                ->Leftjoin('category', 'products.cat_id', '=', 'category.id')
                ->Leftjoin('products_sale', 'products_sale.id_product', '=', 'products.id')
                ->where('products.id',$id)
                 ->select('products.*','products_sale.price_sale','products_sale.sale_status','products_sale.start_date','products_sale.end_date')
                ->first();
            $timenow = Carbon::now('Asia/Ho_Chi_Minh');

            // $mobile = Products::where('id',$id)->first();
            if (empty($mobile)) {
                return view ('errors.503');
                } 
            else {
                   return view ('detail.mobile',['data'=>$mobile,'slug'=>$slug,'timenow'=>$timenow]);
               }
        }
        elseif ($cat =='laptop') {
            $lap = Products::where('id',$id)->first();
            if (empty($lap)) {
            return redirect()->route('index');
            } else {
           return view ('detail.laptop',['data'=>$lap,'slug'=>$slug]);
            }
        }
        elseif ($cat =='pc') {            
            $pc = Products::where('id',$id)->first();
            if (empty($pc)) {
                return redirect()->route('index');
            } else {
                return view ('detail.pc',['data'=>$pc,'slug'=>$slug]);
            }
        } else {
            return redirect()->route('index');
        }
    }
}
