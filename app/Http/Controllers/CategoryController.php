<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\ProductTypes;
use App\Models\Products;
use App\Http\Requests\StoreCategoryRequest;
use Validator;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category=Categories::where('status',1)->get();
        // return view('admin.pages.category.list',compact('category'));
        return response()->json($category);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('admin.pages.category.add');
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
            [
                'name'=>'required|min:2|max:255'
            ],
            [
                'required'=>'Tên danh mục không được để trống',
                'min'=>'Tên danh mục phải từ  2-255 ký tự',
                'max'=>'Tên danh mục phải từ  2-255 ký tự',
            ]
        );
        if($validator->fails()){
            return response()->json(['error'=>'true','message' => $validator->errors()],200);
        }
        $data=$request->all();
        if(Categories::create($data)){
             $categories = Categories::all();
             return response()->json(['message'=>'them thanh cong','Categories'=> $categories]);
        }else{
             return response()->json(['message'=>'them that bai']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
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
        $category=Categories::find($id);
        return response()->json($category,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $validator=Validator::make($request->all(),
            [
                'name'=>'required|min:2|max:255'
            ],
            [
                'required'=>'Tên danh mục không được để trống',
                'min'=>'Tên danh mục phải từ  2-255 ký tự',
                'max'=>'Tên danh mục phải từ  2-255 ký tự',
            ]
        );
        if($validator->fails()){
            return response()->json(['error'=>'true','message' => $validator->errors()],200);
        }
        $category=Categories::find($id);
        $category-> update([
                'name'=>$request->name,
                'status'=>$request->status,
           ]
        );
        return response()->json(['success'=>'update thanh cong']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $category=Categories::find($id);
         $productType=ProductTypes::where('idCategory',$id)->get();
         $product=Products::where('idCategory',$id)->get();
         if(count($category->productType)===0){
             $category-> delete();
             return response()->json(['success'=>'Xoa thanh cong']);
         }else{
             return response()->json(['error'=>'Xoa that bai. Mot truong khac dang su dung truong nay xin vui long kiem tra lai','productType'=>$productType,'product'=>$product]);
         }
    }
}
