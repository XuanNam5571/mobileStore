<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Categories;
use App\Models\Products;
use App\Models\ProductTypes;
use Cart;
use Auth;
class HomeController extends Controller
{
  //web.php
    public function __construct(){
      $category=Categories::where('status',1)->get();
      $producttype=ProductTypes::where('status',1)->get();
      view()->share(['category'=>$category,'producttype'=>$producttype]);
    }
    public function index(){
      $product1=Products::where('status',1)->where('idProductType',8)->get();
      $product2=Products::where('status',1)->where('idProductType',7)->get();
      return view('client.pages.index',['pro_samsung'=>$product1,'pro_nokia'=>$product2]);
    }



    //api.php
    public function getvalue(){
      $category=Categories::where('status',1)->get();
      $producttype=ProductTypes::where('status',1)->get();
      $product1=Products::where('status',1)->where('idProductType',8)->get();//lay du lieu san pham sam sung
      $product2=Products::where('status',1)->where('idProductType',7)->get();//lay du lieu san pham nokia
      //view()->share(['category'=>$category,'producttype'=>$producttype]);
      return response()->json(['category'=>$category,'producttype'=>$producttype,'Samsung'=>$product1,'Nokia'=> $product2]);
    }
}
