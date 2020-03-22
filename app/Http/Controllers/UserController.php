<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Auth;
use Hash;
class UserController extends Controller
{
   public function register(Request $request){
   	 $validator=Validator::make($request->all(),
   	 		[
   	 			'name'=>'required|min:2|max:255',
   	 			'email'=>'required|email|unique:users,email',
   	 			'password'=>'required|min:6|max:255',
   	 			're_password'=>'required|same:password',

   	 		],
   	 		[
   	 			'name.required'=>'Tên không được bỏ trống',
   	 			'name.min'=>'Tên phải có tối thiểu 2 ký tự',
   	 			'name.max'=>'Tên phải có tối đa 255 ký tự',
   	 			'email.required'=>'Email không được bỏ trống',
   	 			'email.email'=>'Phải có đúng định dạng email',
   	 			'email.unique'=>'E  mail nay da duoc su dung',
   	 			'password.required'=>'Mật khẩu không được bỏ trống',
   	 			'password.min'=>'Mật Khẩu phải có tối thiểu 6 ký tự',
   	 			'password.max'=>'Mật khẩu phải có tối đa 255 ký tự',
   	 			're_password.required'=>'Trường này không được bỏ trống',
   	 			're_password.same'=>'Nhập mật khẩu không đúng với trường mật khẩu',
   	 		]
   	 	);
   	 	$data=$request->all();
   	 	$data['password']=Hash::make($request->password);
     if($validator->fails()){
            return response()->json(['error'=>'true','message' => $validator->errors()],200);
      }else{
          $user=User::create($data);
          Auth::login($user);
          return response()->json(['message'=>'Dang ky thanh cong','Tai khoan cua ban la:'=>Auth::user()]);
      }
   	 
    }
    public function loginClient(Request $request){
       $validator=Validator::make($request->all(),
        [
          'email'=>'required|email',
          'password'=>'required|min:6|max:255',
        ],
        [
          'email.required'=>'Email không được bỏ trống',
          'email.email'=>'Phải có đúng định dạng email',
          'password.required'=>'Mật khẩu không được bỏ trống',
          'password.min'=>'Mật Khẩu phải có tối thiểu 6 ký tự',
          'password.max'=>'Mật khẩu phải có tối đa 255 ký tự',
        ]
      );
      if($validator->fails()){
          return response()->json(['error'=>'true','message' => $validator->errors()],200);
      }
      $data=array('email' =>$request->email ,'password'=>$request->password );
      if(Auth::attempt($data)){
        return response()->json(['message'=>'Dang nhap thanh cong','Tai khoan cua ban la:'=>Auth::user()]);
      }
      else {
         return response()->json(['message'=>'Dang nhap that bai']);
      }
    }
    public function logout(){
    	 if(Auth::check()){
            Auth::logout();
            return response()->json(['message'=>'Dang xuat thanh cong']);
        }
    }
    
}
