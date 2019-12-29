<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddProductsRequest;
use App\Http\Requests\EditProductsRequest;
use App\Admin_users;
use App\Http\Requests;
use App\Products;
use App\Category;
use App\Sale;
use App\Detail_img;
use Auth;
use DateTime,File,Input,DB;
use Log;
use Session;
use Excel;

class ProductsController extends Controller
{
	public function getlist($id)
	{
        if ($id!='all') { 
            $pro = products::where('cat_id',$id)->orderBy('id','DESC')->paginate(10);
            $cat= Category::all();
            return view('back-end.products.list',['data'=>$pro,'cat'=>$cat,'loai'=>$id]);                    
        } else {
            $pro = Products::orderBy('id','DESC')->paginate(10);
            $cat= Category::all();
            return view('back-end.products.list',['data'=>$pro,'cat'=>$cat,'loai'=>0]);
        }		
	}
    public function getadd($id)
    {
          $loai = DB::table('category')->get();
          $pro = Products::all(); 
        return view('back-end.products.add',compact('loai'));
		
		
    }
    public function postadd(AddProductsRequest $rq)
    {
    	$pro = new Products();
    	$pro->name = $rq->txtname;
    	$pro->slug = str_slug($rq->txtname,'-');
    	$pro->intro = $rq->txtintro;
    	$pro->promo1 = $rq->txtpromo1;
    	$pro->promo2 = $rq->txtpromo2;
    	$pro->promo3 = $rq->txtpromo3;
    	$pro->packet = $rq->txtpacket;
    	$pro->tag = $rq->txttag;
    	$pro->price = $rq->txtprice;
      $pro->cat = $rq->sltCate;
      $pro->content = $rq->content;
    	$pro->created_at = new datetime;
    	$pro->status = '1';
    	$f = $rq->file('txtimg')->getClientOriginalName();
    	$filename = time().'_'.$f;
    	$pro->images = $filename;    	
    	$rq->file('txtimg')->move('uploads/products/',$filename);
    	$pro->save();    	
      $id_product = $pro->id;

      if($rq->sale_status == 'ON'){
      $sale = new Sale();
      $sale->price_sale = $rq->price_sale;
      $sale->sale_status = $rq->sale_status;
      $sale->start_date = $rq->start_date;
      $sale->end_date = $rq->end_date;
      $sale->id_product = $pro->id;
      $sale->save();  
     }

	return redirect('admin/sanpham/all')
      ->with(['flash_level'=>'result_msg','flash_massage'=>' Đã thêm thành công !']);    	

    }
    public function getdel($id)
    {
        $detail = Detail_img::where('pro_id',$id)->get();
        foreach ($detail as $row) {                
               $dt = Detail_img::find($row->id);
               $pt = public_path('uploads/products/details/').$dt->images_url;   
                if (file_exists($pt))
                {
                    unlink($pt);
                }
               $dt->delete();                              
            }
    	$pro = Products::find($id);
        $pro->delete();
        return redirect('admin/sanpham/all')
         ->with(['flash_level'=>'result_msg','flash_massage'=>'Đã xóa !']);
    }
    public function getedit(Request $request)
    {
         $loai = DB::table('category')->get();
         $product = DB::table('products')
         ->leftjoin('category','category.name','=','products.cat')
         ->leftjoin('products_sale','products_sale.id_product','=','products.id')
         ->select('category.name','products_sale.price_sale','products_sale.sale_status','products_sale.start_date','products_sale.end_date','products.*')
         ->where('products.id',$request->id)->first();
            return view('back-end.products.edit-mobile',compact('loai','product'));
            // return view('back-end.products.edit-mobile',['pro'=>$pro,'cat'=>$cat,'loai'=>$p_id]);     
    }
    public function postedit($loai,$id,EditProductsRequest $rq)
    {
    	$pro = Products::find($id);

        $pro->name = $rq->txtname;
        $pro->slug = str_slug($rq->txtname,'-');
        $pro->intro = $rq->txtintro;
        $pro->promo1 = $rq->txtpromo1;
        $pro->promo2 = $rq->txtpromo2;
        $pro->promo3 = $rq->txtpromo3;
        $pro->packet = $rq->txtpacket;
        $pro->tag = $rq->txttag;
        $pro->price = $rq->txtprice;
        $pro->content = $rq->content;
        $pro->cat = $rq->sltCate;
        $pro->updated_at = new datetime;
        $pro->status = '1';
        $file_path = public_path('uploads/products/').$pro->images;        
        if ($rq->hasFile('txtimg')) {
            if (file_exists($file_path))
                {
                    unlink($file_path);
                }
            
            $f = $rq->file('txtimg')->getClientOriginalName();
            $filename = time().'_'.$f;
            $pro->images = $filename;       
            $rq->file('txtimg')->move('uploads/products/',$filename);
        }       
        $pro->save();
        $id_product = $id;
      $sale = Sale::where('id_product','=',$id)->first();    
       if(!isset($sale->id_product)){
          $sale_e = new Sale();
          $sale_e->price_sale = $rq->price_sale;
          $sale_e->sale_status = $rq->sale_status;
          $sale_e->start_date = $rq->start_date;
          $sale_e->end_date = $rq->end_date;
          $sale_e->id_product = $id;
          $sale_e->save();
        }
        else{ 
          $sale->price_sale = $rq->price_sale;
          $sale->sale_status = $rq->sale_status;
          $sale->start_date = $rq->start_date;
          $sale->end_date = $rq->end_date;
          $sale->id_product = $id;
          $sale->save();
        }
    return redirect('admin/sanpham/all')
      ->with(['flash_level'=>'result_msg','flash_massage'=>' Đã lưu !']);       
    }
    public function getSearch(Request $req){
            $cat= Category::all();
            $pro = Products::where('name','like', '%'.$req->key.'%')
            ->orderBy('id','DESC')
            ->paginate(10);
            if (!$pro || !$pro->count(0)) {
            return redirect('/admin/sanpham/search?key')->with(['status'=>'Không có sản phẩm !']);
            }
            return view('back-end.products.search',['pro'=>$pro,'cat'=>$cat,'loai'=>0]);
   }

   public function import(Request $request){
     //validate the xls file
  $this -> validate($request , [
            'file' => 'required'
        ] , [
             'file.required' => 'Chưa chọn file !'
        ]);

  if($request->hasFile('file')){
   $extension = File::extension($request->file->getClientOriginalName());
   if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {

    $path = $request->file->getRealPath();
    $data = Excel::load($path, function($reader) {
    })->get();
    if(!empty($data) && $data->count()){

     foreach ($data as $key => $value) {
      $insert[] = [
      'name' => $value->name,
      'slug' => $value->str_slug,
      'intro' => $value->intro,
      'price' => $value->price,
      'images' => $value->images,
      'cat' => $value->cat,
      'status' => $value->status,
      'content' => $value->content,
      'created_at'  => date('d-m-y'),
      'updated_at'  => date('d-m-y'),
      ];
     }

     if(!empty($insert)){

      $insertData = Products::insert($insert);
      if ($insertData) {
       Session::flash('thanhcong', 'Import thành công, vui lòng bổ sung thêm thông tin sản phẩm');
      }else {                        
       Session::flash('thatbai', 'Error inserting the data..');
     return redirect('admin/sanpham/all');
      }
     }
    }

   return redirect('admin/sanpham/all');

   }else {
    Session::flash('thatbai', 'Định dạng này là '.$extension.' file.!!Vui lòng chọn định dạng xls hoặc csv file..!!');
  return redirect('admin/sanpham/all');
   }
  }
 }
}
