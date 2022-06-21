<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use App\Models\Person;
use Validator;

class RegisterController extends Controller
{
    

  /*
  |--------------------------------------------------------------------------
  | Person registration function. The registration person will get his/her registration detail
  | information after successfully register. 
  |@param  \Illuminate\Http\Request  $request
  |-------------------------------------------------------------------------
  */

   public function register(Request $request)
   {
     /*====check essential validation====*/ 
   		 $validator= Validator::make($request->all(),[
   		        'first_name'=>'required|string',
   		        'last_name' =>'required|string',
   		        'email'     =>'required|email|unique:persons',
   		        'password'  =>'required|min:4',
   		    ]);
        /*====check user's request method====*/
       if ($request->isMethod('post'))
       {
        /*====Send error message if validation is failed====*/
   		  if ($validator->fails()) 
   		  {
            return response()->json([
              'message'       =>$validator->errors()->first(),
              'type'          =>"error",
              'status' =>422
           ],Response::HTTP_UNPROCESSABLE_ENTITY);
   		    }else{
   		         
               /*====save person detail information====*/
                $person=Person::create([
                        'first_name'=>$request->first_name,
                        'last_name'=>$request->last_name,
                        'email'=>$request->email,
                        'password'=>bcrypt($request->password)
                  ]);
                /*====send person detail information====*/
                return response()->json([
               'person'=>$person,
               'type'=>"success",
               'status'=>200],Response::HTTP_OK);
   		  }
      }


   }

   
}
