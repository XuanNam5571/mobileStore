<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ProductTypes;
use App\Models\Categories;
use App\Http\Requests\StoreProcductTypeRequest;
use Validator;
class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $producttype = ProductTypes::paginate(5);
        // return view('admin.pages.producttype.list',compact('producttype'));
         return response()->json($producttype);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category=Categories::where('status',1)->get();
        // return view('admin.pages.producttype.list',compact('producttype'));
        return response()->json($producttype);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->all(),
            [
                'name' => 'required|min:2|max:255',
            ],
            [
                'name.required' => 'Tên loại sản phẩm không được bỏ trống',
                'name.min' => 'Tên loại sản phẩm tối thiểu có 2 ký tự',
                'name.max' => 'Tên loại sản phẩm tối đa có 255 ký tự',
            ]
        );
        if($validator->fails()){
            return response()->json(['error'=>'true', 'message'=>$validator->errors()],200);
        }
        $data=$request->all();
        if(ProductTypes::create($data)){
             $producttype = ProductTypes::all();
             return response()->json(['message'=>'them thanh cong','producttype'=> $producttype]);
        }else{
             return response()->json(['message'=>'them that bai']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
   public function edit($id)
    {
        $producttype = ProductTypes::find($id);
        $category = Categories::where('status',1)->get();
        return response()->json(['category' => $category, 'producttype' => $producttype]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $id
     * @param  \App\ProductType  $productType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $validator = Validator::make($request->all(),
            [
                'name' => 'required|min:2|max:255',
            ],
            [
                'name.required' => 'Tên loại sản phẩm không được bỏ trống',
                'name.min' => 'Tên loại sản phẩm tối thiểu có 2 ký tự',
                'name.max' => 'Tên loại sản phẩm tối đa có 255 ký tự',
            ]
        );
        if($validator->fails()){
            return response()->json(['error' => 'true', 'message' => $validator->errors()],200);
        }
        $producttype = ProductTypes::find($id);
        $data = $request->all();
        if($producttype->update($data)){
            return response()->json(['result' => 'Đã sửa thành công loại sản phẩm có id '.$id],200);
        }else{
            return response()->json(['result' => 'Đã sửa không thành công loại sản phẩm có id '.$id],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductType  $productType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $producttype = ProductTypes::find($id);
       if(count($producttype->product)===0){
            if($producttype->delete()){
            return response()->json(['result' => 'Đã xóa thành công loại sản phẩm có id '.$id],200);
        }else{
            return response()->json(['result' => 'Đã xóa không thành công loại sản phẩm có id '.$id],200);
        }
    }else{
       return response()    >json(['error'=>'Xoa that bai. Mot san pham su dung truong nay xin vui long kiem tra lai']);
    }
    }
}
