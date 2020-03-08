<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Log;
use DB;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Category;
class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	public static function mainCategories(){
		$mainCategories = Category::where(['Parent_id'=>0])->get();
        //$mainCategories = json_decode(json_encode($mainCategories));
        //echo "<pre>";print_r($mainCategories);die;

		return $mainCategories;
	}

	public function getaddress(Request $request){
		$country_id = DB::table('countries')->select('countries_id')->where('countries_name',$request->data)->first();
		$result['zones'] = DB::table('zones')->where('zone_country_id',$country_id->countries_id)->get();
		$result['wards'] = DB::table('wards')->where('zone_id',$result['zones'][0]->zone_id)->get();
		return $result;
	}

	public function getward(Request $request){
		$zone_id = DB::table('zones')->where('zone_name',$request->data)->first();
		$result['wards'] = DB::table('wards')->where('zone_id',$zone_id->zone_id)->get();
		return $result;
	}
}
