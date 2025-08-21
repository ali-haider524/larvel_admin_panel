<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Users;
use App\Models\Slider;
use App\Models\AppOffer;
use App\Models\Video;
use App\Models\Web;
use App\Models\Task;
use App\Models\CoinStore;
use App\Models\Transaction;
use App\Models\Weblink;
use App\User;
use Carbon\Carbon;
use GeoIP;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use File, Image;


class Fun extends Controller
{

    private $timestamp;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'config', 'testapp', 'cronjob', 'offer_custom','offer_cr']]);
        $this->guard = "api";
        $this->timestamp = Carbon::now();
    }

    public function config(Request $req)
    {   
        $req= json_decode(urldecode(base64_decode(request()->field)), true);
        $salt=$req['i'];
        if($salt==""){
            return $this->respError("Something went wrong!");      
        }
        if($salt!= md5(env('API_KEY').env('API_KEY'))){
            return $this->respError("Something went wrong!!" );      
        }

        $data = DB::table('tbl_setting')->where('id', 1)->get();
        $spin = DB::table('spin_wheel')->get();
        if ($data) {
            return response(['data' => $data, 'spin' => $spin, 'code'=>201]);
        } else {
            return response(['data' => 'data not found!!', 'code' => 400]);
        }
    }

    public function promoBanner()
    {
        $data = Slider::where(['status' => 0])->where(['bannertype' => 'slide'])->select('banner', 'link', 'onclick')->get();
        if ($data) {
            return response(['data' => $data, 'code' => 201]);
        } else {
            return response(['data' => 'Data Not Found', 'code' => 401]);
        }
    }

    public function popupBanner()
    {
        $data = Slider::where(['status' => 0])->where('bannertype', '!=', 'slide')->select('banner', 'link', 'onclick')->get();
        if ($data) {
            return response(['data' => $data, 'code' => 201]);
        } else {
            return response(['data' => 'Data Not Found', 'code' => 401]);
        }
    }


    public function ofWeb()
    {
        $user = JWTAuth::User();
        $avil = env('TASK_WEB') - $user->web;
        if ($avil < 0) {
            return [];
        }else{
          if($avil > 10){
              $avil=10;
          }  
        }
        $data = DB::select('Select weblink.id,title,url,status,point,timer,weblink.type,country 
                            from weblink 
                        left outer join task on 
                        task.user_id =:ids 
                        and 
                        weblink.id = task.task_id
                        and 
                        task.type=1
                        where
                        weblink.country Like :cn or weblink.country=:all
                        and
                        task.task_id is NULL
                        and weblink.status=0 ORDER BY weblink.type=:usr DESC limit :lim', ['ids' => $user->cust_id, 'cn' => '%' . $user->country . '%', 'all' => 'all', 'usr' => 'User', 'lim' => $avil]);

        return response()->json($data);
    }

    public function ofVideo()
    {
        $user = JWTAuth::User();
        $avil = env('TASK_VIDEO') - $user->video;
        if ($avil < 0) {
            return [];
        }else{
          if($avil > 10){
              $avil=10;
          }  
        }
        $data = DB::select('Select youtube_video.id,title,timer,status,point,url,thumb,task_limit,youtube_video.type,country 
                            from youtube_video 
                        left outer join task on 
                        task.user_id =:ids 
                        and 
                        youtube_video.id = task.task_id
                        and 
                        task.type=2
                        where
                        youtube_video.country Like :cn or youtube_video.country=:all                         
                        and
                        task.task_id is NULL
                        and youtube_video.status=0 ORDER BY youtube_video.type=:usr DESC limit :lim', ['ids' => $user->cust_id, 'cn' => '%' . $user->country . '%', 'all' => 'all', 'usr' => 'User', 'lim' => $avil]);

        return response()->json($data);
    }

    public function ofCustom()
    {
        $user = JWTAuth::User();
        $data = DB::select('Select appsname.id,app_name,image,points,url,appurl,details, 
                            task_limit,country,p_userid,appsname.appID
                            from appsname 
                        left outer join appslog on 
                        appslog.user_id =:ids 
                        and 
                        appsname.id = appslog.appid
                        where
                        appsname.country Like :cn or appsname.country=:all
                        and 
                        appslog.appid is NULL
                        and appsname.status=0 ORDER BY appsname.points DESC limit :lim', ['ids' => $user->cust_id, 'cn' => '%' . $user->country . '%', 'all' => 'all', 'lim' => 15]);

        return response()->json($data); 
    }

    public function dailyoffer()
    {
        $user = JWTAuth::User();
        $data = DB::select('Select tbl_dailyoffer.id,title,coin,tbl_dailyoffer.image,tbl_dailyoffer.link,country,description
                            from tbl_dailyoffer 
                        left outer join data_dailyoffer on 
                        data_dailyoffer.user_id =:ids 
                        and 
                        tbl_dailyoffer.id = data_dailyoffer.survey_id
                        where
                        tbl_dailyoffer.status=0
                        and
                        tbl_dailyoffer.country Like :cn or tbl_dailyoffer.country=:all
                        and
                        data_dailyoffer.survey_id is NULL
                       
                        ORDER BY tbl_dailyoffer.id DESC limit :lim', ['ids' => $user->cust_id, 'cn' => '%' . $user->country . '%', 'all' => 'all', 'lim' => 15]);

        return response()->json($data);
    }

    public function ofCustomProgress()
    {
        $user = JWTAuth::User();

        $data = DB::table('appsname')
            ->join('appslog', 'appslog.appid', '=', 'appsname.id')
            ->select('app_name', 'details', 'appsname.image', 'appsname.points', 'appslog.user_id')
            ->where('appslog.user_id', '=', $user->cust_id)
            ->orderBy('appslog.id', 'DESC')->limit(15)->get();

        return response()->json($data);
    }

    public function countTask($type)
    {
        $user = JWTAuth::User();

        if ($type == "0") {
            $total = env('TASK_SPIN');
            $avil = $user->spin;
        } else if ($type == "1") {
            $total = env('TASK_SCRATCH');
            $avil = $user->scratch;
        } else if ($type == "1") {
            $total = env('TASK_MATH');
            $avil = $user->quiz;
        }


        if ($avil <= $total) {
            return response()->json(['total' => $total, 'available' => $total - $avil, 'code' => 201]);
        } else {
            return response()->json(['total' => $total, 'available' => 0, 'code' => 401]);
        }
    }

    public function api(Request $reqs)
    {
        $req = json_decode(urldecode(base64_decode(request()->data)), true);
        $i0 = $req['i0'];
        $i1 = $req['i1'];
        $i1i = $req['i1i'];

        $key=$req['i'];
        if($i0=="" || $key==""){
            return $this->respError("Something went wrong!");      
        }
        if($key!= md5(env('API_KEY').$i0)){
            return $this->respError("Something went wrong!!" );      
        }

        switch ($i1) {
            case 0:
                return $this->dailycheck();
                break;

            case 1:
                return $this->crMulti($i0, $i1i); 
                break;

            case 2:
                return $this->ftlimt($i1i); 
                break;

            case 3:
                return $this->ra($i1i); 
                break;

            case 4:
                return $this->vz($i1i); 
                break;

            case 5:
                return $this->pz($i1i); 
                break;

            case 6:
                return $this->wd($i1i, $i0); 
                break;

            case 7:
                return $this->cb($i1i); 
                break;

            case 8:
                return $this->moveTaskPending($i1i);
                break;

            case 9:
                return $this->promoinfo();
                break;

            case 10:
                return $this->getPromoVideo($i1i);
                break;
            case 11:
                return $this->readnoti();
                break;

            case 12:
                return $this->claimbonus($i1i);
                break;

            case 13:
                return $this->deleteAccount();
                break;
        }
    }

    public function testapp()
    {
        return $data = DB::table('transaction')->join('customer', 'customer.cust_id', '=', 'transaction.user_id')
            ->select('transaction.*', 'transaction.user_id', DB::raw('SUM(transaction.amount) As amount'), 'customer.name')
            ->groupBy('transaction.amount')->limit(50)->get();

        return response()->json($data);
    }

    public function leaderboard()
    {
        $data = DB::table('customer')
            ->select('customer.name', 'customer.balance', 'customer.profile', 'customer.type')
            ->orderBy('customer.balance', 'DESC')
            ->take('30')
            ->get();

        if ($data) {
            return response()->json(['data' => $data, 'code' => 201]);
        } else {
            return response()->json(['data' => 'Data Not Found', 'code' => 404]);
        }
    }

    function wd($i, $id)
    {
        $rd = DB::table('redeem')->where('id', $id)->select('title', 'points', 'refer', 'task', 'quantity')->get();
        if ($rd) {
            if ($user = JWTAuth::User()) {
                if ($user->balance >= $rd[0]->points) {
                    $rchk = DB::table('recharge_request')->where('user_id', $user->cust_id)->whereDate('date', date('Y-m-d'))->count();
                    if ($rchk >= (int)env('RDM_LIM')) {
                        return $this->respError('Oops You Today Redeem Limit is Completed.');
                    }

                    if ($rd[0]->quantity == 0) {
                        return $this->respError('You are to Late No Stock Left wait for few days or try with Different Option.');
                    }

                    if ($rd[0]->refer > 0) {

                        $cref = Users::where('from_refferal_id', $user->refferal_id)->count();
                        if ($cref < $rd[0]->refer) {
                            return $this->respError('Invite ' . $rd[0]->refer . ' Unlock this Redeem');
                        }
                    }

                    if ($rd[0]->task > 0) {
                        switch ($rd[0]->task) {
                            case 1:
                                if ($user->spin < (int) env('TASK_SPIN') || $user->scratch < (int) env('TASK_SCRATCH')) {
                                    return $this->respError('To Unlock this Redeem You Need to Complete Lucky wheel ,Scratch Card Task');
                                }
                                break;

                            case 2:
                                if ($user->spin < (int) env('TASK_SPIN') || $user->scratch < (int) env('TASK_SCRATCH') || $user->quiz < (int) env('TASK_MATH')) {
                                    return $this->respError('To Unlock this Redeem You Need to Complete this Task = Lucky wheel,Scratch Card, Math Quiz Task');
                                }
                                break;

                            case 3:
                                if ($user->spin < (int) env('TASK_SPIN') || $user->scratch < (int) env('TASK_SCRATCH') || $user->web < (int) env('TASK_WEB')) {
                                    return $this->respError('To Unlock this Redeem You Need to Complete this Task = Lucky wheel,Scratch Card, Read Article Task');
                                }
                                break;

                            case 4:
                                if ($user->spin < (int) env('TASK_SPIN') || $user->scratch < (int) env('TASK_SCRATCH') || $user->web < (int) env('TASK_WEB') || $user->video < (int) env('TASK_VIDEO')) {
                                    return $this->respError('To Unlock this Redeem You Need to Complete this Task = Lucky wheel,Scratch Card, Read Article, VideoZone Task');
                                }
                                break;
                        }
                    }

                    DB::table('redeem')->where('id', $id)->update(['quantity' => ($rd[0]->quantity - 1)]);

                    $ins = DB::table('recharge_request')->insert([
                        'mobile_no' => $i,
                        'amount' => $rd[0]->points,
                        'type' => $rd[0]->title,
                        'user_id' => $user->cust_id,
                        'status' => 'Pending',
                        'date' => Carbon::now()
                    ]);

                    if ($ins) {
                        $ded = $user->balance - $rd[0]->points;
                        $user->balance = $ded;
                        $user->save();


                        DB::table('transaction')->insert([
                            'tran_type' => 'credit',
                            'type' => 'Withdrawal',
                            'user_id' => $id,
                            'amount' => $rd[0]->points,
                            'ip' => Fun::IpAddr(),
                            'remained_balance' => $ded,
                            'remarks' => 'Withdrawal Request Submit',
                            'inserted_at' => Carbon::now()
                        ]);

                        return $this->respOk('Redeem Successfully you will receive with in 48 Hours.', $ded);
                    } else {
                        return $this->respError('Something went wrong');
                    }
                } else {
                    return $this->respError('Not Enough Coin to Redeem');
                }
            } else {
                return $this->respError(' Restart App');
            }
        } else {
            return $this->respError('Error 002');
        }
    }

    function pz($i)
    {
        $v = DB::table('games')->where('id', $i)->get();
        if ($v) {
            $user = JWTAuth::User();
            $cnt = Task::where(['type' => 3, 'user_id' => $user->cust_id, 'task_id' => $i])->whereDate('created_at', date('Y-m-d'))->count();
            if ($cnt == 0) {
                $a = explode(",", env('GAME_COIN'));
                $c = rand($a[0], $a[1]);
                $t = $user->balance + $c;
                $user->balance = $t;
                $user->save();
                $this->taskLog(3, $i, $user->cust_id);
                $this->intTrans("Play Game", $user->cust_id, $c, $t, $c . " Bonus Received");
                return $this->respOk($c . " Bonus Received", $t);
            } else {
                return $this->respError("Bonus Already Received");
            }
        } else {
            return $this->respError('Today No Task Left');
        }
    }

    function vz($i)
    {
        $v = DB::table('youtube_video')->where('id', $i)->select('task_limit', 'point', 'views')->get();
        if ($v) {
            $user = JWTAuth::User();
            if ($user->video <= env('TASK_VIDEO')) {
                $c = $v[0]->point;
                $user->video += +1;
                $t = $user->balance + $c;
                $user->balance = $t;
                $user->save();
                DB::table('youtube_video')->where('id', $i)->update(['views' => ($v[0]->views + 1)]);
                if($v[0]->task_limit>0){
                    if (($v[0]->views + 1) >= $v[0]->task_limit) {
                        DB::table('youtube_video')->where('id', $i)->update(['status' => 1]);
                    }
                }
                $this->taskLog(2, $i, $user->cust_id);
                $this->intTrans("Videzone", $user->cust_id, $c, $t, $c . " Bonus Received");
                return $this->respOk($c . " Bonus Received", $t);
            } else {
                return $this->respError("Today No Task Left");
            }
        } else {
            return $this->respError('Today No Task Left');
        }
    }

    function ra($i)
    {
        $w = DB::table('weblink')->where('id', $i)->select('task_limit', 'point', 'views')->get();
        if ($w) {
            $user = JWTAuth::User();
            if ($user->web <= env('TASK_WEB')) {
                $c = $w[0]->point;
                $user->web += +1;
                $t = $user->balance + $c;
                $user->balance = $t;
                $user->save();
                DB::table('weblink')->where('id', $i)->update(['views' => ($w[0]->views + 1)]);
                if($w[0]->task_limit>0){
                    if (($w[0]->views+ 1) >= $w[0]->task_limit) {
                        DB::table('weblink')->where('id', $i)->update(['status' => 1]);
                    }
                }
                $this->taskLog(1, $i, $user->cust_id);
                $this->intTrans("Article", $user->cust_id, $c, $t, $c . " Bonus Received");
                return $this->respOk($c . " Bonus Received", $t);
            } else {
                return $this->respError("Today No Task Left");
            }
        } else {
            return $this->respError('Today No Task Left');
        }
    }

    function taskLog($type, $taskid, $uid)
    {
        Task::insert(['type' => $type, 'task_id' => $taskid, 'user_id' => $uid]);
    }

    function crMulti($type, $c)
    {
        if ($user = JWTAuth::User()) {
            if ($type == "0") {
                if ($user->spin <= (int) env('TASK_SPIN')) {
                    $user->spin += +1;
                    $tot = $user->balance + $c;
                    $user->balance = $tot;
                    $user->save();
                    $this->intTrans("Lucky Wheel", $user->cust_id, $c, $tot, $c . " Bonus Received");
                    return response()->json(['msg' => $c . " Bonus Received", 'limit' => (int) env('TASK_SPIN') - $user->spin, 'balance' => $tot, 'interval' => 5, 'code' => 201]);
                } else {
                    return $this->respError("Today No Spin Left");
                }
            } else if ($type == "1") {
                if ($user->scratch <= env('TASK_SCRATCH')) {
                    $user->scratch += +1;
                    $tot = $user->balance + $c;
                    $user->balance = $tot;
                    $user->save();
                    $this->intTrans("Scratch Card", $user->cust_id, $c, $tot, $c . " Bonus Received");
                    return response()->json(['msg' => $c . " Bonus Received", 'limit' => (int) env('TASK_SCRATCH') - $user->scratch, 'balance' => $tot, 'interval' => 5, 'code' => 201]);
                } else {
                    return $this->respError("Today No Scratch Card Left");
                }
            } else if ($type == "2") {
                if ($user->quiz <= env('TASK_MATH')) {
                    $a = explode(",", env('MATH_COIN'));
                    $c = rand($a[0], $a[1]);
                    $user->quiz += +1;
                    $tot = $user->balance + $c;
                    $user->balance = $tot;
                    $user->save();
                    $this->intTrans("Quiz", $user->cust_id, $c, $tot, $c . " Bonus Received");
                    return response()->json(['msg' => $c . " Bonus Received", 'limit' => (int) env('TASK_MATH') - $user->quiz, 'interval' => 5, 'balance' => $tot, 'code' => 201]);
                } else {
                    return $this->respError("Today No Quiz Left");
                }
            }
        }
    }

    function ftlimt($type)
    {
        $user = JWTAuth::User();
        switch ($type) {
            case 0:
                $t = (int) env('TASK_SPIN');
                $u = $user->spin;
                break;

            case 1:
                $t =  (int) env('TASK_SCRATCH');
                $u = $user->scratch;
                break;

            case 2:
                $t =  (int) env('TASK_MATH');
                $u = $user->quiz;
                break;
        }

        if ($u <= $t) {
            return response()->json(['total' => $t, 'limit' => $t - $u, 'coin' => env('SCRATCH_COIN'), 'code' => 201]);
        } else {
            return response()->json(['total' => $t, 'limit' => 0, 'code' => 401]);
        }
    }

    function dailycheck()
    {
        if ($user = JWTAuth::User()) {
            if ($user->d == date('Y-m-d')) {
                return $this->respError("Daily Bonus Already Claimed");
            } else {
                $data = $pay = DB::table('tbl_app_setting')->get()->first()->dailybonus;
                $js=json_decode($data,true);
                $day =Carbon::parse(Carbon::now())->format('l');
                if($day=="Monday"){
                    $coin = $js[0]['d1'];
                }else if($day=="Tuesday"){
                    $coin = $js[0]['d2'];
                }else if($day=="Wednesday"){
                    $coin = $js[0]['d3'];
                }else if($day=="Thursday"){
                    $coin = $js[0]['d4'];
                }else if($day=="Friday"){
                    $coin = $js[0]['d5'];
                }else if($day=="Saturday"){
                    $coin = $js[0]['d6'];
                }else if($day=="Sunday"){
                    $coin = $js[0]['d7'];
                }

                $user->d = date('Y-m-d');
                $total = $user->balance + $coin;
                $user->balance = $total;
                $user->updated_at = $this->timestamp;
                $user->save();
                $this->intTrans("Daily Bonus", $user->cust_id, $coin, $total, $coin . " Bonus Received");
                return $this->respOk($coin . " Bonus Received", $total);
            }
        }
    }
    
    function intTrans($task, $id, $coin, $total, $remark)
    {
        DB::table('transaction')->insert([
            'tran_type' => 'credit',
            'type' => $task,
            'user_id' => $id,
            'amount' => $coin,
            'ip' => Fun::IpAddr(),
            'remained_balance' => $total,
            'remarks' => $remark,
            'inserted_at' => Carbon::now()
        ]);
    }

    function respError($msg)
    {
        return response()->json(['msg' => $msg, 'code' => 404]);
    }

    function respOk($msg, $total)
    {
        return response()->json(['msg' => $msg, 'balance' => $total, 'code' => 201]);
    }

    public function funGame()
    {
        $data = DB::table('games')->select('id', 'title', 'image', 'link')->orderBy('id', 'DESC')->limit(20)->get();
        return response()->json(['data' => $data, 'game_minute' => env('GAME_MIN'), 'code' => 201]);
    }

    public function funOfferwalls()
    {

        $data = DB::table('offerwall')->where('status', 0)->orderBy('id', 'DESC')->get();
        return response()->json(['data' => $data, 'code' => 201]);
    }

    public function funfaq($type)
    {
        $data = DB::table('faq')->where('type', $type)->orderBy('id', 'ASC')->get();
        return response()->json($data);
    }

    public function rewardCat()
    {
        $user = JWTAuth::User();
        $data = DB::table('redeem_cat')->select('id', 'name', 'image', 'country')->where('status', '0')->where('country', 'LIKE', '%' . $user->country . '%')->orwhere('country', 'all')->get();
        return response()->json($data);
    }

    public function funrewards($id)
    {
        $user = JWTAuth::User();
        $data=DB::select('select * from redeem where category=:cat and status=0 and country LIKE :cn or country =:all AND category=:cat1 ORDER by points + 0 ASC',['cat'=>$id,'cn'=>'%'.$user->country.'%','all'=>'all','cat1'=>$id]);
        return response()->json(['data' => $data, 'code' => 201]);
    }

    public function funCoinstore()
    {
        $user = JWTAuth::User();
        $pay = DB::table('tbl_app_setting')->get()->first()->pay_info;
        $data = DB::table('coinstore')->where('status', '0')->where('country', 'LIKE', '%' . $user->country . '%')->orwhere('country', 'all')->get();
        return response()->json(['data' => $data, 'code' => 201, 'info' => $pay]);
    }

    function promoinfo()
    {
        if ($user = JWTAuth::User()) {
            $info = DB::table('tbl_app_setting')->where('id', 1)->get();

            return response()->json([
                'balance' => $user->balance,
                'data1' => $info[0]->max_promote,
                'data2' => $info[0]->video_promotecoin,
                'code' => 201
            ]);
        } else {
            return response()->json(['msg' => 'Something went wrong', 'code' => 401]);
        }
    }

    public function isUserBanned()
    {
        if ($user = JWTAuth::User()) {
            if ($user->status == 1) {
                return response()->json(['msg' => $user->reason, 'code' => 401]);
            }
        } else {
            return response()->json(['msg' => 'Something went wrong', 'code' => 401]);
        }
    }

    public function IpAddr()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }


    function cb($refid)
    {
        if ($user = JWTAuth::User()) {
            $mode = (int) env('REF_MODE');
            $bonus = (int) env('WL_COIN');

            if ($refid == $user->refferal_id) {
                return $this->respError("You Can't Use your Own referral code");
            } else if ($user->from_refer != null || $user->from_refer > 0) {
                return $this->respError("Already Collected Bonus");
            }

            if ($refid == null) {

                if ($mode == 1 && $user->spin < (int) env('TASK_SPIN') || $user->scratch < (int) env('TASK_SCRATCH')) {
                    return $this->respError("Complete Lucky Wheel and Scratch Card To Unlock.");
                }

                $total = $user->balance + $bonus;
                $user->balance = $total;
                $user->from_refferal_id = 1;
                $user->save();

                $trns = DB::table('transaction')
                    ->insert([
                        'tran_type' => 'credit',
                        'user_id' => $user->cust_id,
                        'amount' => $bonus,
                        'type' => 'Welcome bonus',
                        'remained_balance' => $total,
                        'remarks' => 'Welcome Bonus'
                    ]);

                return $this->respOk($bonus . ' Bonus Received ', $total);
            } else {
                $checkRef = Users::where('from_refferal_id', $refid)->count();
                if ($checkRef > 0) {

                    if ($mode == 1 && $user->spin < (int) env('TASK_SPIN') || $user->scratch < (int) env('TASK_SCRATCH')) {
                        return $this->respError("Complete Lucky Wheel and Scratch Card To Unlock.");
                    }

                    $referbonus = (int) env('REF_COIN');
                    $total = $user->balance + $bonus;
                    $user->from_refferal_id = $refid;
                    $user->balance = $total;
                    $user->save();

                    $trns = DB::table('transaction')
                        ->insert([
                            'tran_type' => 'credit',
                            'user_id' => $user->cust_id,
                            'amount' => $bonus,
                            'type' => 'welcome bonus',
                            'remained_balance' => $total,
                            'remarks' => 'Welcome Bonus'
                        ]);

                    $update = Users::where('refferal_id', $refid)->get();
                    $refbal = $update->balance + $referbonus;
                    $update->balance = $refbal;
                    $update->save();

                    $trnss = DB::table('transaction')
                        ->insert([
                            'tran_type' => 'credit',
                            'user_id' => $update->cust_id,
                            'amount' => $referbonus,
                            'type' => 'Invite',
                            'remained_balance' => $refbal,
                            'remarks' => 'Referral Bonus Credit From ' . $user->name
                        ]);

                    return $this->respOk($bonus . ' Bonus Received ', $total);
                } else {
                    return $this->respError("Invalid Refer Code");
                }
            }
        } else {
            return $this->respError("Something went wrong");
        }
    }


    function getPromoVideo($type)
    {
        if ($user = JWTAuth::User()) {
            if ($type == "0") {
                return response()->json(Web::where('userid', $user->cust_id)->get());
            } else {
                return response()->json(Video::where('userid', $user->cust_id)->get());
            }
        }
    }

    public function createPromo(Request $req)
    {
        if ($user = JWTAuth::User()) {
            $now = Carbon::now();
            $type = $req->type;
            $userid = $user->cust_id;

            $info = DB::table('tbl_app_setting')->where('id', 1)->select('video_promotecoin', 'promote_time', 'promo_videocoin', 'promo_webcoin', 'max_promote')->get();
            $userbal = $user->balance;
            $promote = $req->limit;
            $maxpromote = $info[0]->max_promote;

            $coin = $info[0]->video_promotecoin;

            if (!($promote * $coin <= $userbal)) {
                return response()->json(['msg' => "Not Enough Coin", 'code' => 400]);
            }

            if ($promote > $maxpromote) {
                return $this->respError('Max Promote Limit is' . $maxpromote);
            }

            if ($type == "video") {
                $video = new Video;
                $video->title = $req->title;
                $video->thumb = 'http://img.youtube.com/vi/' . Fun::YouTubeGetID($req->url) . '/sddefault.jpg';
                $video->timer = $info[0]->promote_time;
                $video->point = $info[0]->promo_videocoin;
                $video->task_limit = $promote;
                $video->type = "User";
                $video->userid = $userid;
                $video->status = 3;
                $video->url = $req->url;
                $res = $video->save();

                $total = $userbal - ($promote * $coin);

                $trns = DB::table('transaction')
                    ->insert([
                        'tran_type' => 'debit',
                        'user_id' => $userid,
                        'amount' => $promote * $coin,
                        'ip' => Fun::IpAddr(),
                        'type' => 'Video Promotion',
                        'remained_balance' => $total,
                        'inserted_at' => $now,
                        'remarks' => 'Video Promotion Created'
                    ]);

                $user->balance = $total;
                $user->save();

                if ($res && $trns) {
                    return $this->respOk('Promotion Create Successfully', $total);
                } else {
                    return $this->respError('Technical Error');
                }
            } else if ($type == "web") {
                $weblink = new Web;
                $weblink->title = $req->title;
                $weblink->url = $req->url;
                $weblink->point = $info[0]->promo_webcoin;
                $weblink->timer = $info[0]->promote_time;
                $weblink->task_limit = $promote;
                $weblink->type = "User";
                $weblink->status = 3;
                $weblink->userid = $userid;
                $res = $weblink->save();

                $total = $userbal - ($promote * $coin);
                $trns = DB::table('transaction')
                    ->insert([
                        'tran_type' => 'debit',
                        'user_id' => $userid,
                        'amount' => $promote * $coin,
                        'ip' => Fun::IpAddr(),
                        'type' => 'Website Promotion',
                        'remained_balance' => $total,
                        'inserted_at' => $now,
                        'remarks' => 'Website Promotion Created'
                    ]);
                $user->balance = $total;
                $user->save();

                if ($res && $trns) {
                    return $this->respOk('Promotion Create Successfully', $total);
                } else {
                    return $this->respError('Technical Error');
                }
            }
        } else {
            return $this->respError("Something went wrong");
        }
    }


    public function cronjob($secret)
    {

        if ($secret == env('CRON_SECRET')) {
            DB::table('customer')->update([
                'web' => 0,
                'video' => 0,
                'spin' => 0,
                'scratch' => 0,
                'quiz' => 0,
                'td' => date('Y-m-d'),
            ]);

            DB::table('task')->delete();
            DB::table('appslog')->where('status', 1)->delete();


            \Artisan::call('view:clear');
            \Artisan::call('cache:clear');
            \Artisan::call('route:clear');
            \Artisan::call('config:clear');
            
            return response()->json(['msg' => 'Cron Job Run Successfully!!.']);
        } else {
            return 'something went wrong';
        }
    }

    public function moveTaskPending($appid)
    {
        if ($user = JWTAuth::User()) {
            $d = DB::table('appslog')->where(['user_id' => $user->cust_id, 'appid' => $appid])->count();
            if ($d) {
                return $this->respError("offer Already in Pending");
            } else {
                DB::table('appslog')->insert([
                    'user_id' => $user->cust_id,
                    'appid' => $appid,
                    'status' => 1,
                    'created_at' => date('Y-m-d')
                ]);

                return response()->json(['msg' => 'Offer added in pending', 'code' => 201]);
            }
        } else {
            return $this->respError("Invalid User");
        }
    }

    public function offer_custom(Request $req)
    {

        if ($req->signs != env('CUSTOM_OFFER_SECRET')) {
            return 'Invalid ';
        }

        if (isset($req->subid2)) {
            $id = $req->subid2;
            $appID = 0;
        } else if (isset($req->offerid)) {
            $id = $req->offerid;
            $appID = 1;
        } else if (isset($req->appid)) {
            $id = $req->appid;
            $appID = 2;
        } else {
            return 'Invalid Configuration ';
        }

        $app = AppOffer::find($id);
        if ($app) {

            if ($app->appID != $appID) {
                return 'Invalid App ID Type ';
            }

            $prm = str_replace('=', '', $app->p_userid);
            $uid = $req->$prm;

            $ad = DB::table('appslog')->where(['user_id' => $uid, 'appid' => $id])->get();
            if ($ad) {
                if ($ad[0]->status == "1") {
                    $user = Users::find($uid);
                    $total = $user->balance + $app->points;
                    $user->balance = $total;
                    $user->save();

                    $app->views += +1;
                    if ($app->task_limit != "0") {
                        if (($app->views += +1) >=  $app->task_limit) {
                            $app->status = 1;
                        }
                    }
                    $app->save();
                    DB::table('appslog')->where(['user_id' => $uid, 'appid' => $id])->update(['status' => 0]);

                    DB::table('transaction')
                        ->insert([
                            'tran_type' => 'credit',
                            'user_id' => $uid,
                            'amount' => $app->points,
                            'type' => 'Offers',
                            'remained_balance' => $total,
                            'remarks' => $app->app_name . ' Completed'
                        ]);

                    DB::table('tbl_noti')->insert(['user_id' => $uid, 'title' => $app->points . ' Bonus Received', 'msg' => $app->app_name . ' Completed', 'created_at' => Carbon::now()]);


                    return $app->response_code;
                } else {
                    return 'Already Creited';
                }
            } else {
                $user = Users::find($uid);
                $total = $user->balance + $app->points;
                $user->balance = $total;
                $user->save();

                $app->views += +1;
                if ($app->task_limit != "0") {
                    if (($app->views += +1) >=  $app->task_limit) {
                        $app->status = 1;
                    }
                }
                $app->save();
                DB::table('appslog')->insert(['user_id' => $uid, 'appid' => $id, 'status' => 0]);

                DB::table('transaction')
                    ->insert([
                        'tran_type' => 'credit',
                        'user_id' => $uid,
                        'amount' => $app->points,
                        'type' => 'Offers',
                        'remained_balance' => $total,
                        'remarks' => $app->app_name . ' Completed'
                    ]);
                DB::table('tbl_noti')->insert(['user_id' => $uid, 'title' => $app->points . ' Bonus Received', 'msg' => $app->app_name . ' Completed', 'created_at' => Carbon::now()]);

                return $app->response_code;
            }
        } else {
            return 'Offer Not Found';
        }
    }

    public function crofferwall($id, Request $req)
    {
        return 'aaa';
         if ($req->signs != env('CUSTOM_OFFER_SECRET')) {
            return 'Invalid ';
        }
        
        $now = Carbon::now();

        $offerinfo = DB::table('offerwall')->where('id', $id)->get();
        $postbinfo = DB::table('postback')->where('offerwall_id', $id)->get();

        if ($offerinfo && $postbinfo) {
            $offerwall = $postbinfo[0]->offerwall_name;
            $userid = $req->query(strtok($postbinfo[0]->p_userid, '='));
            $payout = $req->query(strtok($postbinfo[0]->p_payout, '='));
            $ip = $req->query(strtok($postbinfo[0]->p_ip, '='));
            $offerid = $req->query(strtok($postbinfo[0]->p_campaing_id, '='));
            $offername = $req->query(strtok($postbinfo[0]->p_offername, '='));

            if ($offername == "") {
                $offername = "offer completed";
            }

            $fetchcoin = Users::find($userid);
            $currentcoin = $fetchcoin->balance;
            $total = $currentcoin + $payout;
            $trns = DB::table('transaction')
                ->insert([
                    'tran_type' => 'credit',
                    'user_id' => $userid,
                    'amount' => $payout,
                    'ip' => $ip,
                    'eventId' => $offerid,
                    'type' => $offername . ' Credit',
                    'remained_balance' => $total,
                    'offerwall_type' => $offerwall,
                    'admin_remarks' => $offerwall . ' ' . $offername . ' Completed',
                    'remarks' => $offername . ' Completed'
                ]);
            $fetchcoin->balance = $total;
            $fetchcoin->save();

            DB::table('tbl_noti')->insert(['user_id' => $userid, 'title' => $payout . ' Bonus Received', 'msg' => $offername . ' Completed', 'created_at' => Carbon::now()]);

            if ($offerwall == "Iron source") {
                return $req->eventId . ':OK';
            } else
                return $postbinfo[0]->response_code;
        }
    }

    function YouTubeGetID($url)
    {
        if (stristr($url, 'youtu.be/')) {
            preg_match('/(https:|http:|)(\/\/www\.|\/\/|)(.*?)\/(.{11})/i', $url, $final_ID);
            return $final_ID[4];
        } else {
            @preg_match('/(https:|http:|):(\/\/www\.|\/\/|)(.*?)\/(embed\/|watch.*?v=|)([a-z_A-Z0-9\-]{11})/i', $url, $IDD);
            return $IDD[5];
        }
    }

    public function notiMsg()
    {
        if ($user = JWTAuth::User()) {
            $data = DB::table('tbl_noti')->where(['user_id' => $user->cust_id, 'noti_type' => 0])->orWhere(['user_id' => 0, 'noti_type' => 1])->select('title', 'msg', 'created_at')->latest()->limit(30)->get();
            return response()->json($data);
        }
    }

    function readnoti()
    {
        if ($user = JWTAuth::User()) {
            DB::table('tbl_noti')->where(['user_id' => $user->cust_id])->update(['status' => 1]);
            return response()->json(['msg' => "Notificatin Mark as Read", 'balance' => 0, 'code' => 201]);
        }
    }

    public function submit_dailyoffer(Request $req)
    {
        if ($user = JWTAuth::User()) {

            $cn = DB::table('data_dailyoffer')->where(['survey_id' => $req->id, 'user_id' => $user->cust_id])->count();

            if ($cn > 0) {
                return response()->json(['msg' => 'Offer Already Submited', 'code' => 201]);
            }

            if ($req->newimage) {
                $image = $req->newimage;
                $filenameWithExt = $image->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
                $filename = preg_replace("/\s+/", '-', $filename);
                $extension = $image->getClientOriginalExtension();
                $fileNameToStore = uniqid() . '_' . time() . '.' . $extension;
                $image_resize = Image::make($image->getRealPath());
                $image_resize->resize(300, 500);
                $image_resize->save('images/dailyoffer/' . $fileNameToStore);

                DB::table('data_dailyoffer')->insert([
                    'url' => $req->link,
                    'survey_id' => $req->id,
                    'taskStatus' => 0,
                    'image' => $fileNameToStore,
                    'user_id' => $user->cust_id,
                    'name' => $user->name,
                    'email' => $user->email
                ]);

                $srv=DB::table('tbl_dailyoffer')->where('id',  $req->id)->get();

                DB::table('tbl_dailyoffer')->where('id',  $req->id)->update(['views' => ($srv[0]->views + 1)]);

                if($srv[0]->task_limit >0){
                    if ( ($srv[0]->views+1)  >= $srv[0]->task_limit) {
                        DB::table('tbl_dailyoffer')->where('id',  $req->id)->update(['status' => 1]);
                    }
                }

                return response()->json(['msg' => 'Offer Submit Successfully Bonus will be receive after verification', 'code' => 201]);
            } else {
                DB::table('data_dailyoffer')->insert([
                    'url' => $req->link,
                    'survey_id' => $req->id,
                    'taskStatus' => 0,
                    'user_id' => $user->cust_id,
                    'name' => $user->name,
                    'email' => $user->email
                ]);

                return response()->json(['msg' => 'Offer Submit Successfully Bonus will be receive after verification', 'code' => 201]);
            }
        }
    }

    public function verifyPay(Request $req)
    {
        if ($user = JWTAuth::User()) {
            $json = json_decode(base64_decode($req->data), true);
            $pc = DB::table('coinstore')->where('id', $json['s1'])->get();
            if ($pc) {
                DB::table('payment_transaction')->insert([
                    'userid' => $user->cust_id,
                    'method' => $json['s2'],
                    'trans_id' => $json['s3'],
                    'amount' => $json['s4'],
                    'coin' => $pc[0]->coin,
                    'status' => $json['s5'],
                    'pacinfo' => $json['s6']
                ]);
                $total = $user->balance + $pc[0]->coin;
                $user->balance = $total;

                DB::table('transaction')->insert([
                    'tran_type' => 'credit',
                    'type' => 'Coin Purchased',
                    'ip' => Fun::IpAddr(),
                    'user_id' =>  $user->cust_id,
                    'amount' => $pc[0]->coin,
                    'remained_balance' => $total,
                    'remarks' => 'Coin Purchased'
                ]);
                DB::table('tbl_noti')->insert(['user_id' => $user->cust_id, 'title' => "Coin Purchase", 'msg' => "Coin Purchase Successfully. added to your wallet", 'created_at' => Carbon::now()]);

                $data = $user->save();

                if ($data) {
                    return $this->respOk("Coin Purchase Successfully.", $total);
                } else {
                    return $this->respError("Server Error.");
                }
            }
        }
    }

    public function supportTicket()
    {
        if ($user = JWTAuth::User()) {
            $data = DB::table('support_ticket')->where('user_id', $user->cust_id)->latest()->get();
            return response()->json($data);
        }
    }

    public function createSupportTicket(Request $req)
    {
        if ($user = JWTAuth::User()) {
            $cnt = DB::table('support_ticket')->where('user_id', $user->cust_id)->where('status', '<', 2)->count();
            if ($cnt > 0) {
                return $this->respError("You have already one Active Support Ticket.");
            }

            $ins = DB::table('support_ticket')->insert([
                'user_id' => $user->cust_id,
                'ticketID' => mt_rand(123456, 999999),
                'email' => $req->email,
                'name' => $user->name,
                'subject' => $req->subject,
                'message' => $req->message,
                'status' => 0,
                'created_at' => Carbon::now()
            ]);

            if ($ins) {
                return $this->respOk("Ticket Created Successfully. Reponse will be with in 48 hours.", 0);
            } else {
                return $this->respError("Something went wrong");
            }
        }
    }

    function claimbonus($fromrefer)
    {
        if ($user = JWTAuth::User()) {
            $rm = (int) env('REF_MODE');

            $bonus = env('WL_COIN');
            $referbonus = env('REF_COIN');

            if ($rm == 1) {
                if ($user->spin < (int) env('TASK_SPIN') || $user->scratch < (int) env('TASK_SCRATCH')) {
                    return $this->respError('To Unlock this Option You Need to Complete Lucky wheel ,Scratch Card Task');
                }
            }

            if ($user->refferal_id == $fromrefer) {
                return $this->respError('You cant Use your refer code');
            }

            if ($user->from_refferal_id > 0) {
                return $this->respError('Welcome Bonus Already Claimed');
            }


            if ($fromrefer == null || $fromrefer == "") {

                $total = $user->balance + $bonus;
                $user->balance = $total;
                $user->from_refferal_id = 1;
                $user->save();
                $trns = DB::table('transaction')
                    ->insert([
                        'tran_type' => 'credit',
                        'user_id' => $user->cust_id,
                        'amount' => $bonus,
                        'type' => 'welcome bonus',
                        'remained_balance' => $total,
                        'remarks' => 'Welcome Bonus'
                    ]);

                return $this->respOk($bonus . " Bonuns Claimed Successfully", $total);
            } else {

                $checkRef = Users::where('refferal_id', $fromrefer)->count();

                if ($checkRef > 0) {


                    $fetchcoin = DB::table('customer')->where('refferal_id', $fromrefer)->get();
                    $update = Users::find($fetchcoin[0]->cust_id);
                    $update->balance = $fetchcoin[0]->balance + $referbonus;
                    $res = $update->save();


                    $total = $user->balance + $bonus;
                    $user->from_refferal_id = $fromrefer;
                    $user->balance = $total;
                    $user->save();
                    $trns = DB::table('transaction')
                        ->insert([
                            'tran_type' => 'credit',
                            'user_id' => $user->cust_id,
                            'amount' => $bonus,
                            'type' => 'welcome bonus',
                            'remained_balance' => $total,
                            'remarks' => 'Welcome Bonus'
                        ]);


                    $trnss = DB::table('transaction')
                        ->insert([
                            'tran_type' => 'credit',
                            'user_id' => $fetchcoin[0]->cust_id,
                            'amount' => $referbonus,
                            'type' => 'Invite',
                            'remained_balance' => $fetchcoin[0]->balance + $referbonus,
                            'remarks' => 'Referral Bonus Credit From ' . $user->name
                        ]);

                    DB::table('tbl_noti')->insert(['user_id' => $fetchcoin[0]->cust_id, 'title' => 'Referral Bonus Credit From ' . $user->name, 'msg' => 'Refer Bonus Received' . $referbonus, 'created_at' => Carbon::now()]);
                    return $this->respOk($bonus . " Bonus Claimed Successfully", $total);
                } else {

                    return $this->respError("Refer Code is Not Valid");
                }
            }
        } else {
            $this->respError("Restart App Session Expired");
        }
    }


    function deleteAccount()
    {
        if ($user = JWTAuth::User()) {
            $id = $user->cust_id;
            DB::table('customer')->where('cust_id', $id)->delete();
            DB::table('transaction')->where('user_id', $id)->delete();
            DB::table('recharge_request')->where('user_id', $id)->delete();
            DB::table('appslog')->where('user_id', $id)->delete();
            DB::table('data_dailyoffer')->where('user_id', $id)->delete();
            DB::table('monitor_report')->where('userid', $id)->delete();

            return $this->respOk("Account Deleted Successfully",0);
        } else {
            return $this->respError("Session Expired Login Again");
        }
    }
}
