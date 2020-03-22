<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTypes extends Model
{
    protected $table ='producttype';
    protected $fillable = [
        'idCategory', 'status', 'name',
    ];
    public function Category(){
    	return $this->belongsTo('App\Models\Categories','idCategory','id');
    }
     public function product(){
    	return $this->hasMany('App\Models\Products','idProductType','id');
    }
}

