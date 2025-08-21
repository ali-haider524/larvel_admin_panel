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
use App\Models\AppOffer;
use App\Models\Recharge;
use App\Models\Video;
use App\Models\Web;

class Home extends Controller
{
    public function index()
    {
        $user=  Users::count();   
        $ban=  Users::where('status',1)->count();   
        $today=  Users::whereDate('inserted_at',date('Y-m-d'))->count();   
        $appopen=  Users::whereDate('updated_at',date('Y-m-d'))->count();   
        $apps=  AppOffer::where('status',0)->count();   
        $redeem=  DB::table('redeem')->count();   
        $trans=  DB::table('transaction')->count();   
        $video=  Video::where('status',0)->count();   
        $weblink=  Web::where('status',0)->count();   
        $pending=DB::table('recharge_request')->where('status','Pending')->count();
        $complete=DB::table('recharge_request')->where('status','Success')->count();
        $sdk=DB::table('offerwall')->where('type','sdk')->count();
        $web=DB::table('offerwall')->where('type','web')->count();
        $api=DB::table('offerwall')->where('type','api')->count();
        $doffer=DB::table('tbl_dailyoffer')->count();
        $store=DB::table('coinstore')->count();
        $game=DB::table('games')->count();
        $month=Users::whereMonth('inserted_at', date('m'))
        ->whereYear('inserted_at', date('Y'))
        ->count();
        
           return view('dashboards.default',
                ['user'=>$user,
                'apps'=>$apps,
                'redeem'=>$redeem,
                'video'=>$video,
                'weblink'=>$weblink,
                'pending'=>$pending,
                'trans'=>$trans,
                'complete'=>$complete,
                'sdk'=>$sdk,
                'web'=>$web,
                'api'=>$api,
                'doffer'=>$doffer,
                'store'=>$store,
                'game'=>$game,
                'appopen'=>$appopen,
                'today'=>$today,
                'ban'=>$ban,
                'month'=>$month,
                ]);
    }
    
}