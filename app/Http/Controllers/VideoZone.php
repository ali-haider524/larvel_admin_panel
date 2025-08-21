<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Video;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class VideoZone extends Controller
{
    public function index()
    {
        $data = Video::where('status','=',0)->orwhere('status','=',2)->orderBy('id','DESC')->paginate();
        return view('video.video-management', compact('data'));
    }

    public function indexComplete()
    {
        $data = Video::where('status','=',1)->orderBy('id','DESC')->paginate();
        return view('video.complete', compact('data'));
    }

    
    public function pendingApproval()
    {
        $data = Video::where('status','=',3)->paginate();
        return view('promotion.pending-video', compact('data'));
    }


    public function create(){
        return view('video.add');
    }

    public function store(Request $req){
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $req->url, $match);
        $youtube_id = $match[1];
        $video= new Video;
        $video->title=$req->title;
        $video->thumb='http://img.youtube.com/vi/'.$youtube_id.'/sddefault.jpg';
        $video->timer=$req->timer;
        $video->point=$req->point;
        $video->country=$req->country;
        $video->task_limit=$req->task_limit;
        $video->url=$req->url;
        $res=$video->save();
        if($res){
            return redirect('/videozone/active')->with('success', ' Created Successfully!');
        }else{
            return redirect('/videozone/add')->with('error', 'Technical Error!');
        }   
    }

    public function edit(Video $id){
        return view('video/edit',['data'=>$id]);
    }
    
    public function update(Request $req){
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $req->url, $match);
        $youtube_id = $match[1];
        $video= Video::find($req->id);
        $video->title=$req->title;
        $video->thumb='http://img.youtube.com/vi/'.$youtube_id.'/sddefault.jpg';
        $video->timer=$req->timer;
        $video->point=$req->point;
        $video->country=$req->country;
        $video->task_limit=$req->task_limit;
        $video->url=$req->url;
        $res=$video->save();
        if($res){
            return redirect('/videozone/active')->with('success', ' Update Successfully!');
        }else{
            return redirect('/videozone/add')->with('error', 'Technical Error!');
        }
    }


    public function destroy($id){
        video::where('id',$id)->delete();
        return 1;
    }

    public function action(Request $req){

        if($req->status=="delete"){
            $update =video::whereIn('id',explode(",",$req->id))->delete(); 
            if($update){
                return 1;
            }else{
                return "not updated";
            }
        }
        else if($req->status=="enable"){
            $update =video::whereIn('id',explode(",",$req->id))->update(['status'=>0]); 
            if($update){
                return 1;
            }else{
                return "not updated";
            }
        }
        else if($req->status=="disable"){
            $update =video::whereIn('id',explode(",",$req->id))->update(['status'=>2]); 
            if($update){
                return 1;
            }else{
                return "not updated";
            }
        }else if($req->status=="approve"){
            $update =video::whereIn('id',explode(",",$req->id))->update(['status'=>0]); 
            if($update){
                return 1;
            }else{
                return "not updated";
            }
        }
    }


    // public function notifyUser($type,$id,$reason){
    //     $token=Users::find($id);
    //     $userId=$token->p_token;
    //     $name=$token->name;
     
    //     if($type=="Reject"){
    //        $title= $name." Your Redeem Request has been Rejected";
    //         $message =$reason; 
            
    //     }else if($type=="Success"){
    //        $title=$name." Your Redeem Request has been Approved";
    //         $message =$reason; 
    //     }
        
    // if($userId){
    //   $res=  OneSignal::sendNotificationToUser(
    //         $message,
    //         $userId,
    //         $url = null,
    //         $data = null,
    //         $buttons = null,
    //         $schedule = null,
    //         $headings = $title, 
    //         $subtitle = null
    //     );  
    // }
    // }

}
