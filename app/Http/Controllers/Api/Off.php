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
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use File, Image;


class Off extends Controller
{

  public function crofferwall($id, Request $req)
    {
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

            $cnt=DB::table('transaction')->where(['eventId'=>$offerid,'user_id'=>$userid])->count();
            
            if($cnt>0){
                return response()->json(':Already Credied');
            }else{
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
                } else{
                    return $postbinfo[0]->response_code;
                }
            }
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
            return response()->json('Invalid Configuration ');
        }

        $app = AppOffer::find($id);
        if ($app) {

            if ($app->appID != $appID) {
                 return response()->json('Invalid App ID Type');
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


               return response()->json($app->response_code);
                } else {
                   return response()->json('Already Creited');
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

                 return response()->json($app->response_code);
            }
        } else {
            return response()->json('Offer Not Found');
        }
    }


}