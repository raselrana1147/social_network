<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Models\Person;
use Illuminate\Support\Facades\DB;


class AuthController extends Controller
{
    
    public function __construct()
    {
       $this->middleware('auth:api',['except'=>'login']);
    }

    /*
    |--------------------------------------------------------------------------
    | Person login function. The person will get bearer token 
    | if he/she can successfully login. If he/she can successfully login this function 
    | will return persons's onjects and bearer token
    |@param  \Illuminate\Http\Request  $request
    |-------------------------------------------------------------------------
    */
    
    public function login(Request $request)
    {
       /*====Check account is exist====*/ 
         $data=Person::where('email',$request->email)->first();
         if (!is_null($data)) {
              /*====Match email and pasword====*/ 
               $credentials = $request->only(['email', 'password']);
               /*=====bearer token===*/ 
               if ($token = $this->guard()->attempt($credentials)) {
                /*====get authenticate persons's objects====*/ 

                $user=auth('api')->user();
                /*====send person's objects and bearer token====*/ 
                 return response()->json([
                   "message"=>"Successfully Login",
                   "status" =>200,
                   "type"   =>"success",
                   "user"=>$user,
                   "access_token"=>$token,
                   "token_type"=>"bearer"
                 ],Response::HTTP_OK);
               }
                /*====send response if password not match====*/ 
               return response()->json([
                  "message"=>"Password did not match",
                   "status" =>200,
                   "type"   =>"success",
                   "user_id"=>null,
                   "access_token"=>null,
                   "token_type"=>"bearer"
                 ],401);
         
         }else{
           /*====send response if account not found====*/ 
             return response()->json([
                  "message"=>"No account is found",
                   "status" =>200,
                   "type"   =>"success",
                   "user_id"=>null,
                   "access_token"=>null,
                   "token_type"=>"bearer"
             ],Response::HTTP_FORBIDDEN);
         } 
    }

    
  

    /*
    |--------------------------------------------------------------------------
    | Logout function. This function is responsible to destroy authenticate 
    | user bearer token. If any authenticate person logout his/her token will be destroyed
    | 
    |-------------------------------------------------------------------------
    */

    public function logout()
    {
      
       /*====make token invalid====*/ 
        auth('api')->logout();
         /*====send message if bearer token is invalid====*/ 
        return response()
        ->json([
             'message' => 'Successfully logged out',
             'status' => 200,
            ],Response::HTTP_OK);
    }


    /*
    |--------------------------------------------------------------------------
    | Logout function is responsible to define authentication guard guard
    |-------------------------------------------------------------------------
    */
    public function guard()
    {
        return Auth::guard('api');
    }
}
