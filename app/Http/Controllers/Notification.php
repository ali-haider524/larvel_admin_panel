<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Image;
use File,Carbon\Carbon;

class Notification extends Controller
{
    public function index()
    {
        return view('pages.notifications');
    }
    
   public function norification_all(Request $req){
       
        $title = $req->title;
	    $message = $req->description;
	    $link = $req->url;
	    
	    if(empty($message)){ $message=null; }
	    if(empty($link)){ $link=null; }
	    
	    if($req->image){
	        $image = $req->image;
            $filenameWithExt = $image->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
            $filename = preg_replace("/\s+/", '-', $filename);
            $extension = $image->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(400,200);  
            $save= $image_resize->save('images/'.$fileNameToStore);
            
            $icon=env('APP_URL').'images/'.$fileNameToStore;
	    }else{
	        $icon=null;
	    }
	    
            
        if($message==null || empty($message)){
	     	 $content = array("en" => strip_tags($title));
	    }else{
	         $content = array("en" => strip_tags($message));
	    }
	    
	    if($icon==null){
	        DB::table('tbl_noti')->insert(['title'=>$req->title,'msg'=>$req->description,'noti_type'=>1,'created_at'=>Carbon::now()]);
	    }
        
        $fields = array(
        	'app_id' => env('ONESIGNAL_APP_ID'),
        	'included_segments' => array('All'),                                            
        	'data' => array(
        		"link" => $link,
        		"description" => $message,
        		"img" => $icon
        	),
        	'headings'=> array("en" => $title),
        	'contents' =>$content,
        	'big_picture' =>  $icon
        );

        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                   'Authorization: Basic '.env('ONESIGNAL_REST_API_KEY')));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        
        return redirect('/push-notification')->with('success','Notificaiton send Successfully');
       
   }
   
   public function notifyUser(Request $request){
        $token=Users::find($request->id);
        $userId=$token->p_token;
        
        $title=$request->title;
        $message = $request->description;

        $content = array("en" => strip_tags($message));
	    
        $fields = array(
        	'app_id' => env('ONESIGNAL_APP_ID'),
        	'include_player_ids' => $userId,                                            
        	'headings'=> array("en" => $title),
        	'contents' =>$content,
        	'big_picture' =>  null
        );

	    DB::table('tbl_noti')->insert(['user_id'=>$request->id,'title'=>$title,'msg'=>$message,'created_at'=>Carbon::now()]);

        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                   'Authorization: Basic '.env('ONESIGNAL_REST_API_KEY')));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        
     return redirect('/user-track/'.$request->id)->with('success','Notification Send Successfully');
    }
   
}
