<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
   	protected $table ='products_sale';
	protected $guarded =[];

    public function products()
    {
        return $this->hasOne('App\Products','id_product');
    }
}
