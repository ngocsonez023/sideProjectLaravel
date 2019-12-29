<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class wishlist extends Model
{
      protected $table ='wishlist';
      protected $guarded =['user_id','pro_id']; 
      
      public function products()
    {
        return $this->hasMany('App\Products','pro_id');
    }
}
