<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Web;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class WebArticle extends Controller
{
    public function index()
    {
        $data = Web::where('status','=',0)->orwhere('status','=',2)->orderBy('id','DESC')->paginate();
        return view('web.web-management', compact('data'));
    }

    public function indexComplete()
    {
        $data = Web::where('status','=',1)->orderBy('id','DESC')->paginate();
        return view('web.complete', compact('data'));
    }

    public function pendingApproval()
    {
        $data = Web::where('status','=',3)->paginate();
        return view('promotion.pending-web', compact('data'));
    }

    public function create(){
        return view('web.add-web');
    }

    public function store(Request $req){
        $web= new Web;
        $web->title=$req->title;
        $web->url=$req->url;
        $web->point=$req->point;
        $web->timer=$req->timer;
        $web->task_limit=$req->task_limit;
        $web->country=$req->country;
        $web->save();
        
        return redirect('/article/active')->with('success','Added Successsfully');
    }
    
    public function edit(Web $id){
        return view('web/edit-web',['data'=>$id]);
    }
    
    public function update(Request $req){
        
        $web= Web::find($req->id);
        $web->title=$req->title;
        $web->url=$req->url;
        $web->point=$req->point;
        $web->timer=$req->timer;
        $web->task_limit=$req->task_limit;
        $web->country=$req->country;
        $web->save();
        
        return redirect('/article/active')->with('success','Update Successsfully');
        
    }
    
    public function rejectPromo(Request $req){
        
        if($req->type=="web"){
            $web=DB::table('weblink')->where('id',$req->id)->get();
            $limit=$web[0]->task_limit;
            $coin = $info[0]->video_promotecoin;
            
            $amt=$limit*$coin;
            $user=Users::find($web[0]->userid);
            $total=$user->balance+$amt;
            $user->balance=$total;
            $user->save();
            
            $trns = DB::table('transaction')
                ->insert([
                    'tran_type' => 'credit',
                    'user_id' => $web[0]->userid,
                    'amount' => $amt,
                    'type' => 'Web Promotion',
                    'remained_balance' => $total,
                    'inserted_at' => Carbon::now(),
                    'remarks' => $req->remark
                ]);
            
            DB::table('tbl_noti')->insert(['user_id'=>$web[0]->userid,'title'=>$web[0]->title,'msg'=>$req->remark,'created_at'=>Carbon::now()]);
            return redirect('/promotion/article/approval')->with('success','Reject Successfully');
            

        }else if($req->type=="video"){
            $vid=DB::table('youtube_video')->where('id',$req->id)->get();
            $limit=$vid[0]->task_limit;
            $coin = $info[0]->video_promotecoin;
            
            $amt=$limit*$coin;
            $user=Users::find($vid[0]->userid);
            $total=$user->balance+$amt;
            $user->balance=$total;
            $user->save();
            
            $trns = DB::table('transaction')
                ->insert([
                    'tran_type' => 'credit',
                    'user_id' => $vid[0]->userid,
                    'amount' => $amt,
                    'type' => 'Video Promotion',
                    'remained_balance' => $total,
                    'inserted_at' => Carbon::now(),
                    'remarks' => $req->remark
                ]);
            
            DB::table('tbl_noti')->insert(['user_id'=>$vid[0]->userid,'title'=>$vid[0]->title,'msg'=>$req->remark,'created_at'=>Carbon::now()]);
            return redirect('/promotion/videozone/approval')->with('success','Reject Successfully');
        }
    }
 
   
    public function destroy($id){
        Web::where('id',$id)->delete();
        return 1;
    }

    public function action(Request $req){
        if($req->status=="delete"){
            $update =Web::whereIn('id',explode(",",$req->id))->delete(); 
            if($update){
                return 1;
            }else{
                return "not updated";
            }
        }
        else if($req->status=="enable"){
            $update =Web::whereIn('id',explode(",",$req->id))->update(['status'=>0]); 
            if($update){
                return 1;
            }else{
                return "not updated";
            }
        }
        else if($req->status=="disable"){
            $update =Web::whereIn('id',explode(",",$req->id))->update(['status'=>2]); 
            if($update){
                return 1;
            }else{
                return "not updated";
            }
        }
        else if($req->status=="approve"){
            $update =Web::whereIn('id',explode(",",$req->id))->update(['status'=>0]); 
            if($update){
                return 1;
            }else{
                return "not updated";
            }
        }
    }
}
