<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Follower;
use Validator;

class FollowController extends Controller
{
    


	public function __construct()
	{
	   $this->middleware('auth:api');
	}

	/*
	|
	|This function is written to follow a person. The authencatio person can
	|can follow anonter person.
	|@param  \Illuminate\Http\Request  $request
	*/

    public function follower(Request $request,$person_id)
    {
    	    
    	    /*====Check the user's request method====*/   	 
	       if ($request->isMethod('post')) 
	       {
	       		 /*====Check the authenticate person has already followed this person or not====*/ 
	       	   $data=Follower::where(['follower_id'=>auth()->user()->id,'following_id'=>$person_id])->first();
	       	   if (is_null($data)) 
	       	   {
	       	   		 /*====Save follewer and following information====*/ 
	       	   		$follower=new Follower();
	       	   		$follower->following_id=$person_id;
	       	   		$follower->follower_id=auth()->user()->id;
	       	   		$follower->save();
	       	   		 
	       	   		   /*====send message if the data successfully saved====*/
	       	   		 return response()->json([
	       	   		'message'=>"Successfuly following",
	       	   		'type'=>"success",
	       	   		'status'=>200],Response::HTTP_OK);

	       	   }else{
	       	   	  /*====send message if this authencate person already following this person====*/ 
	       	   	 
	       	   return response()->json([
	       	   	'message'=>"You already following this person",
	       	   	'type'=>"error",
	       	   	'status'=>200],Response::HTTP_OK);
	       	   }
	      }
    	   		
    }
}
