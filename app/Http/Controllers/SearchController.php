<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;

class SearchController extends Controller
{
    public function find(Request $request) {
      $customer = Admin_users::where('name', 'like', '%' . $request->get('q') . '%')->get();
      return response()->json($customer);
    }
}