<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Image;
use DateTime,File,Input,DB;
class ImageController extends Controller
{
 public function getlist()
   {  
      $image = DB::table('tblimage')->get();
       return view('back-end.image.list',compact('image'));
   }
    public function getadd()
   {	
		$image = DB::table('tblimage')->get();
		return view('back-end.image.add',compact('image'));
   }

   public function postadd(Request $request)
   {

     if ($image = $request->file('images')) {  
            foreach ($image as $files) {
            $filename = date('YmdHis') . "." . $files->getClientOriginalName();
            $files->move('uploads/products/', $filename);
            $listimg[]['image'] = "$filename";
            // action chưa có
            }
            DB::table('tblimage')->insert($listimg);
        }
        return redirect('admin/thuvien')->with(['flash_level'=>'result_msg','flash_massage'=>' Đã thêm thành công !']);  
   }



}