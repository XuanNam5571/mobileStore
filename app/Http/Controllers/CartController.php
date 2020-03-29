<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Categories;
use App\Models\Products;
use App\Models\ProductTypes;
use Cart;
use Auth;
use App\Models\Order;
use App\Models\OrderDetail;
use Mail;
use App\Mail\ShoppingMail;
class CartController extends Controller
{
    //  public function __construct(){
    //   $category=Categories::where('status',1)->get();
    //   $producttype=ProductTypes::where('status',1)->get();
    //   view()->share(['category'=>$category,'producttype'=>$producttype]);
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart=Cart::content();
        // //dd($cart);
        // //return view('client.pages.cart',compact('cart'));
        $data=Cart::total();
        return response()->json(['cart'=>$cart,'tong tien'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $data=$request->all();
       $data['idUser']=Auth::user()->id;
       $data['total_price']=str_replace(',','',Cart::total());
       $data['code_order']='order'.rand();
       $data['status']=0;
       $data['name']=Auth::user()->name;
       $order=Order::create($data);
       $idOrder=$order->id;
       $orderDetail=[];
       $orderDetails=[];
       foreach (Cart::content() as $key => $value) {
               $orderDetail['idOrder']=$idOrder;
               $orderDetail['idProduct']=$value->id;
               $orderDetail['quantity']=$value->qty;
               $orderDetail['price']=$value->price;
               $product=Products::where('id',$value->id)->first();
               $count_mua=(($product->quantity)-($value->qty));
               $product->update(['quantity'=>$count_mua]);
               $orderDetails[$key]= OrderDetail::create($orderDetail);
       }
       Mail::to($order->email)->send(new ShoppingMail($order,$orderDetails));
       Cart::destroy();
       return response()->json(['message'=>'Ban da mua hang thanh cong']);  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //id la cot rowid khi addcart sinh ra
        if($request->qty == 0){
            return response()->json(['error' => 'Số lượng tối thiểu là 1 sản phẩm'],200);
        }else{
            Cart::update($id,$request->qty);
            return response()->json(['result' => 'Đã cập số lượng sản phẩm thành công']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Cart::remove($id);
      return response()->json(['result' => 'Đã xóa thành công']);
    }
    public function addCart($id,Request $request){
        $product=Products::find($id);
        $count_mua=(($product->quantity)-($request->qty));
        if($count_mua>=0 && $product->quantity >0){
            if(isset($request->qty) && $request->qty!=0){
                $qty=$request->qty;
            }else{
                $qty=1;
            }
        }else{
           return response()->json(['message'=>$product->name.' chỉ còn '.$product->quantity .' sản phẩm']);
        }
        if($product->promotion>0){
            $price=$product->promotion;
        }else{
            $price=$product->price;
        }
        $cart= $cart = ['id' => $id, 'name' => $product->name, 'qty' => $qty, 'price' => $price, 'options' => ['img' => $product->image]];
        Cart::add($cart);
        //$cartItems = Cart::content()->toArray();
        return response()->json(Cart::content());
    }

    public function checkout(){
        if(Auth::check() && Cart::count()>0){
            $user=Auth::user();
            $price=str_replace(',','',Cart::total());
            return response()->json(['price'=>$price,'user'=>$user]);
        }else{
            return response()->json(['message'=>'Ban phai dang nhap de thuc hien chuc nang nay va phai co 1 san phan trong gio hang']);
        }
    }
}
