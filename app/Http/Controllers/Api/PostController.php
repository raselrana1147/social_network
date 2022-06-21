<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Post;
use App\Models\PagePost;
use App\Models\Follower;
use App\Models\PageFollower;
use Validator;

class PostController extends Controller
{
   
	public function __construct()
	{
	   $this->middleware('auth:api');
	}

  /*
  |
  |This function is written to submit the posts on person timeline. 
  |The authencation person add post
  |@param  \Illuminate\Http\Request  $request
  */

   public function post(Request $request)
   {
        /*====check essential validation====*/ 
          $validator= Validator::make($request->all(),[
  		     'post_content'=>'required|string',
  		    ]);
            /*====check user's request method====*/
          if ($request->isMethod('post')) 
          {
              /*====Send error message if validation is failed====*/
           if ($validator->fails()) 
           {
             return response()->json([
               'message' =>$validator->errors()->first(),
               'type' =>"error",
               'status' =>422
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
          }else{
             /*====Save page details data====*/
    	   		$post=new Post();
    	   		$post->post_content=$request->post_content;
    	   		$post->person_id=auth()->user()->id;
    	   		$post->save();

    	   		 /*====send message if the data successfully saved====*/
    	   		 return response()->json([
    	   		'message'=>"Successfuly posted",
    	   		'type'=>"success",
    	   		'status'=>200],Response::HTTP_OK);
        }
         	   
        }
   }


 /*
  |
  |This function is written to submit the posts on the page which he/she follow. 
  |The authencation person add post on the page
  |@param  \Illuminate\Http\Request  $request
  */
      public function page_post(Request $request,$page_id)
      {
         /*====check essential validation====*/ 
        $validator= Validator::make($request->all(),[
     		     'post_content'=>'required|string',
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
             /*====Save page post details data====*/       
   	   		$page_post=new PagePost();
   	   		$page_post->post_content=$request->post_content;
   	   		$page_post->person_id=auth()->user()->id;
   	   		$page_post->page_id=$page_id;
   	   		$page_post->save();
   	   		 
            /*====send message if the data successfully saved====*/ 
   	   		 return response()->json(
            [
   	   		    'message'=>"Successfuly posted",
   	   		    'type'=>"success",
   	   		     'status'=>200],
            Response::HTTP_OK);

          }
            	   
        }
      }


      /*
      |
      |This function is written to get all my feeds. 
      |
      */

      public function get_feed()
      {
      	 $person=auth()->user();

         /*====Get all the posts if my following persion add ad post in his/her timeline====*/ 
         $followers=Follower::where('follower_id',$person->id)->get();
         $follower_posts=[];
         foreach ($followers as $follower) 
         {
            $posts=Post::where('person_id',$follower->following_id)->latest()->get();
           foreach ($posts as $post) 
           {
              array_push($follower_posts, $post);
           }
         }

          /*====Get all the posts which page I am following====*/ 
         $page_feeds=[];
         $my_pages=PageFollower::where('person_id',$person->id)->get();
         foreach ($my_pages as $my_page) 
         {
           $page_posts=PagePost::where('page_id',$my_page->id)->latest()->get();
           foreach ($page_posts as $page_post)
            {
              array_push($page_feeds, $page_post);
            }
         }
          /*====Marge all my following person posts and my following page posts====*/ 
         $feeds=array_merge($follower_posts,$page_feeds);
          /*====return my feeds====*/ 
         return response()->json(
          [
           
            'feeds'=>$feeds ,
            'type'=>"success",
             'status'=>200],
          Response::HTTP_OK);
      	 
      }
}
