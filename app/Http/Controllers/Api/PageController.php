<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use App\Models\Page;
use App\Models\PageFollower;

class PageController extends Controller
{
    
	public function __construct()
	{
	   $this->middleware('auth:api');
	}

    /*
    |
    |This function is written to create page. The authenticate person can
    | create one or more page.
    |@param  \Illuminate\Http\Request  $request
    */

    public function create(Request $request)
    {
         /*====check essential validation====*/ 
       $validator= Validator::make($request->all(),[
		        'page_name'=>'required|string|unique:pages',
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
   		      
            /*====Save page details data====*/
               $page=new Page();
               $page->page_name=$request->page_name;
               $page->person_id=auth()->user()->id;
               $page->save();
                /*====send message if the data successfully saved====*/
                return response()->json([
               'message'=>"Successfuly created",
               'type'=>"success",
               'status'=>200],Response::HTTP_OK);
   		    }
   		 }
    }

    /*
    |
    |This function is written to follow a page. The authenticate person can 
    | follow one or more page. 
    */

    public function follower(Request $request, $page_id)
    {
        /*====check user's request method====*/
          if ($request->isMethod('post')) 
          {
             /*====Check the authenticate person has already followed this page or not====*/ 
               $data=PageFollower::where(['person_id'=>auth()->user()->id,'page_id'=>$page_id])->first();
               if (is_null($data)) 
               {
                 /*====Save the follewer and page information====*/ 
                    $page_follower=new PageFollower();
                    $page_follower->person_id=auth()->user()->id;
                    $page_follower->page_id=$page_id;
                    $page_follower->save();
                     
                      /*====send message if the data successfully saved====*/
                     return response()->json([
                    'message'=>"Successfuly following",
                    'type'=>"success",
                    'status'=>200],Response::HTTP_OK);
               }else{

                  /*====send message if this authencate user already following this page====*/ 
               return response()->json([
                'message'=>"Your are already following this page",
                'type'=>"error",
                'status'=>200],Response::HTTP_OK);
               }
              

         }
    }
}
