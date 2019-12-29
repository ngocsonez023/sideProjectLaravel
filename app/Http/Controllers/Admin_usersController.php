<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Admin_users;
use Auth;
use DB;

class Admin_usersController extends Controller
{
    public function getlist()
   {  
      $cate = DB::table('category')->get();
      $data = DB::table('admin_users')->paginate(10);
       return view('back-end.admin_mem.list',compact('cate','data'));
   }
        public function getadd()
    {
      $data = DB::table('admin_users')->get();
      return view('back-end.admin_mem.add',['data'=>$data]);   
    }
    public function getedit($id)
   {
   		$data = Admin_users::where('id',$id)->first();
   		return view('back-end.admin_mem.edit',['data'=>$data]);
   }
   public function getdel($id){
    $admin = Auth::guard('admin')->user();
         $adminLv = $admin['level'];
        if($adminLv == 2){
            return back()->with(['flash_level'=>'result_msg','flash_massage'=>' Bạn không có quyền xoá !']);
        }

       DB::table('admin_users')->where('id', '=', $id)->delete();
        return redirect('admin/nhanvien')
         ->with(['flash_level'=>'result_msg','flash_massage'=>'Đã xóa !']);

    }
     public function postadd(Request $request){

     $level = $request['level'];
     $name = $request['name'];
     $email = $request['email'];
     $password = $request['password'];

      $admin = new admin_users;

      $admin['level'] = $level;
      $admin['name'] = $name;
      $admin['email'] = $email;
      $admin['password'] = bcrypt($request['password']);
      $admin -> save();

      return redirect('admin/nhanvien')->with(['flash_level'=>'result_msg','flash_massage'=>' Đã tạo thành công !']);
     }
    public function postEdit(Request $request , $id){

      $admin = Auth::guard('admin')->user();
         $adminLv = $admin['level'];
        if($adminLv == 2){
            return back()->with(['flash_level'=>'result_msg','flash_massage'=>'Bạn không có quyền chỉnh sửa !']);
        }


      $admin = Admin_users::find($id);

        $level = $request['level'];
        $name = $request['name'];
        $email = $request['email'];
        $password = $request['password'];

       $admin['level'] = $level;
       $admin['name'] = $name;
       $admin['email'] = $email;
       $admin['password'] = bcrypt($request['password']);
        $admin -> save();

      return redirect('admin/nhanvien')->with(['flash_level'=>'result_msg','flash_massage'=>' Đã lưu !'], $id);       
    }

}
