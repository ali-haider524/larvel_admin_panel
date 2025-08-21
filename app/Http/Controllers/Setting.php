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
use Illuminate\Support\Str;
use File, Image;

class Setting extends Controller
{
    public function index()
    {
        $data = DB::table('tbl_setting')->where('id', 1)->get();
        return view('admin-setting/app-setting/general', compact('data'));
    }

    public function indexMaintenance()
    {
         $data = DB::table('tbl_setting')->where('id', 1)->get();
        return view('admin-setting/app-setting/update', compact('data'));
    }

    public function indexFraud()
    {
        return view('admin-setting/app-setting/security');
    }

    public function indexAdmin()
    {
        $data = DB::table('users')->where('id', 1)->get();
        return view('admin-setting/app-setting/admin',compact('data'));
    }
    
    public function indexConfiguration()
    {
        if(env('API_KEY')==null){
            $this->updateData('API_KEY',Str::random(25));
        }

        if(env('CRON_SECRET')==null){
            $this->updateData('CRON_SECRET',Str::random(15));
        }

        if(env('CUSTOM_OFFER_SECRET')==null){
            $this->updateData('CUSTOM_OFFER_SECRET',Str::random(10));
        }
        
        \Artisan::call('config:clear');

        return view('admin-setting/app-setting/config');
    }

    public function indexAds()
    {
        $data = DB::table('tbl_setting')->where('id', 1)->get();
        $inter = json_decode($data[0]->interstitalID);
        return view('admin-setting/app-setting/ads', ['data' => $data, 'inter' => $inter]);
    }

    public function indexApp()
    {
        $data = DB::table('tbl_app_setting')->where('id', 1)->get();
        $t = DB::table('tbl_setting')->where('id', 1)->select('task', 'homeMsg')->get();
        $task = json_decode($t[0]->task);
        $pay = json_decode($data[0]->pay_info);
        $daily = json_decode($data[0]->dailybonus);
        return view('admin-setting/app-setting/app', ['data' => $data, 'pay' => $pay, 'daily' => $daily, 'task' => $task, 'homeMsg' => $t[0]->homeMsg]);
    }

    public function update(Request $req)
    {

        if ($req->type == "appsetting") {
            $dailybonus = array([
                'd1' => $req->day1,
                'd2' => $req->day2,
                'd3' => $req->day3,
                'd4' => $req->day4,
                'd5' => $req->day5,
                'd6' => $req->day6,
                'd7' => $req->day7
            ]);

            $payinfo = array([
                'storeName' => $req->storeName,
                'paypal_key' => $req->paypal_key,
                'upiID' => $req->upiID,
                'upiName' => $req->upiName,
                'upiMerchant' => $req->upiMerchant,
                'm_payinfo' => $req->manualDetail,
                'contact' => $req->manualContact,
                'google_key' => $req->google_key,
                'paypal' => ($req->paypal == 'on') ? 'on' : 'off',
                'upi' => ($req->upi == 'on') ? 'on' : 'off',
                'manual' => ($req->manual == 'on') ? 'on' : 'off',
                'inapp' => ($req->inapp == 'on') ? 'on' : 'off'
            ]);

            DB::table('tbl_app_setting')->where('id', 1)->update([
                'max_promote' => $req->max_promote,
                'video_promotecoin' => $req->video_promotecoin,
                'promote_time' => $req->promote_time,
                'promo_videocoin' => $req->promo_videocoin,
                'promo_webcoin' => $req->promo_webcoin,
                'dailybonus' => json_encode($dailybonus),
                'pay_info' => json_encode($payinfo)
            ]);

            $this->updateData('TASK_WEB', $req->TASK_WEB);
            $this->updateData('TASK_VIDEO', $req->TASK_VIDEO);
            $this->updateData('TASK_SPIN', $req->TASK_SPIN);
            $this->updateData('TASK_SCRATCH', $req->TASK_SCRATCH);
            $this->updateData('TASK_MATH', $req->TASK_MATH);
            $this->updateData('GAME_MIN', $req->GAME_MIN);
            $this->updateData('SCRATCH_COIN', $req->SCRATCH_COIN);
            $this->updateData('MATH_COIN', $req->MATH_COIN);
            $this->updateData('GAME_COIN', $req->GAME_COIN);
            $this->updateData('WL_COIN', $req->WL_COIN);
            $this->updateData('REF_COIN', $req->REF_COIN);
            $this->updateData('REF_MODE', $req->REF_MODE);
            $this->updateData('RDM_LIM', $req->RDM_LIM);

            \Artisan::call('config:clear');

            return redirect('/setting/app')->with('success', 'Update Successfully!');
        } else if ($req->type == "hometask") {

            $task = array([
                'math' => ($req->math == 'on') ? 'on' : 'off',
                'spin' => ($req->spin == 'on') ? 'on' : 'off',
                'scratch' => ($req->scratch == 'on') ? 'on' : 'off',
                'web' => ($req->web == 'on') ? 'on' : 'off',
                'video' => ($req->video == 'on') ? 'on' : 'off',
                'game' => ($req->game == 'on') ? 'on' : 'off',
                'cpi' => ($req->cpi == 'on') ? 'on' : 'off',
                'promo' => ($req->promo == 'on') ? 'on' : 'off',
                'store' => ($req->store == 'on') ? 'on' : 'off',
                'offerwall' => ($req->offerwall == 'on') ? 'on' : 'off',
                'db' => ($req->db == 'on') ? 'on' : 'off',
                'do' => ($req->do == 'on') ? 'on' : 'off'
            ]);

            DB::table('tbl_setting')->where('id', 1)->update(['task' => json_encode($task), 'homeMsg' => $req->homeMsg]);
            return redirect('/setting/app')->with('success', 'Update Successfully!');
        } else if ($req->type == "ads") {

            if ($req->isApplovin == "on") {
                $isApplovin = 'true';
            } else {
                $isApplovin = 'false';
            }
            if ($req->isAdmob == "on") {
                $isAdmob = 'true';
            } else {
                $isAdmob = 'false';
            }
            if ($req->isUnity == "on") {
                $isUnity = 'true';
            } else {
                $isUnity = 'false';
            }
            if ($req->isStart == "on") {
                $isStart = 'true';
            } else {
                $isStart = 'false';
            }
            if ($req->isAdcolony == "on") {
                $isAdcolony = 'true';
            } else {
                $isAdcolony = 'false';
            }
            if ($req->isFb == "on") {
                $isFb = 'true';
            } else {
                $isFb = 'false';
            }

            $interstitaliD = array([
                'au_admob' => $req->au_admob,
                'au_applovin' => $req->au_applovin,
                'au_unity' => $req->au_unity,
                'au_fb' => $req->au_fb,
                'isApplovin' => $isApplovin,
                'isAdmob' => $isAdmob,
                'isUnity' => $isUnity,
                'isStart' => $isStart,
                'isAdcolony' => $isAdcolony,
                'isFb' => $isFb
            ]);

            DB::table('tbl_setting')->where('id', 1)->update([
                'startapp_appid' => $req->startapp_appid,
                'unity_game' => $req->unity_game,
                'adcolonyApp' => $req->adcolonyApp,
                'adcolony_zone' => $req->adcolony_zone,
                'banner_type' => $req->banner_type,
                'bannerID' => $req->bannerID,
                'interstital_type' => $req->interstital_type,
                'interstital_count' => $req->interstitalCount,
                'nativeType' => $req->native_type,
                'nativeID' => $req->nativeID,
                'native_count' => $req->nativeCount,
                'interstitalID' => json_encode($interstitaliD),
            ]);

            return redirect('/setting/ads')->with('success', 'Update Successfully!');
        } else if ($req->type == "security") {

            $this->updateData('SEC_ONE_DEVICE', ($req->SEC_ONE_DEVICE == 'on') ? '0' : '1');
            $this->updateData('SEC_AUTOBAN_ROOT', ($req->SEC_AUTOBAN_ROOT == 'on') ? '0' : '1');
            $this->updateData('SEC_BLOCK_ROOT', ($req->SEC_BLOCK_ROOT == 'on') ? '0' : '1');

            \Artisan::call('config:clear');
            return redirect('/setting/fraud-prevention')->with('success', 'Update Successfully!');
        } else if ($req->type == "admin") {

            $admin = DB::table('users')->where('id', 1)->get();

            if (!Hash::check($req->oldpass, $admin[0]->password) ){
                return redirect()->back()->withErrors(['msgError' => 'Old Password not Matched.']);
            }

            if ($req->newpass != $req->cnpass) {
                return redirect()->back()->withErrors(['msgError' => 'Old Password and New Password Matched.']);
            }

            DB::table('users')->where('id', 1)->update([
                'email' => $req->email,
                'password' => Hash::make($req->newpass)
            ]);

            return redirect('/setting/admin-profile')->with('success', 'Update Successfully!');
        } else if ($req->type == "smtp") {

            $this->updateData('MAIL_MAILER', $req->MAIL_MAILER);
            $this->updateData('MAIL_HOST', $req->MAIL_HOST);
            $this->updateData('MAIL_PORT', $req->MAIL_PORT);
            $this->updateData('MAIL_USERNAME', $req->MAIL_USERNAME);
            $this->updateData('MAIL_PASSWORD', $req->MAIL_PASSWORD);
            $this->updateData('MAIL_ENCRYPTION', $req->MAIL_ENCRYPTION);
            $this->updateData('MAIL_FROM_ADDRESS', $req->MAIL_USERNAME);

            \Artisan::call('config:clear');

            return redirect('/setting/app-configuration')->with('success', 'Update Successfully!');
        }else if ($req->type == "notification") {

            $this->updateData('ONESIGNAL_APP_ID', $req->ONESIGNAL_APP_ID);
            $this->updateData('ONESIGNAL_REST_API_KEY', $req->ONESIGNAL_REST_API_KEY);
            \Artisan::call('config:clear');

            return redirect('/setting/app-configuration')->with('success', 'Update Successfully!');
        }
        else if ($req->type == "server") {
            
            if($req->APP_ENV=="local"){
                $this->updateData('APP_DEBUG','true');
                $this->updateData('APP_ENV','local');
            }else{
                $this->updateData('APP_DEBUG','false');
                $this->updateData('APP_ENV','production');
            }

            $this->updateData('API_KEY', $req->API_KEY);
            $this->updateData('CUSTOM_OFFER_SECRET', $req->CUSTOM_OFFER_SECRET);
            $this->updateData('CRON_SECRET', $req->CRON_SECRET);
            $this->updateData('COIN_TO_USD', $req->COIN_TO_USD);
            $this->updateData('APP_URL', $req->APP_URL);

            \Artisan::call('config:clear');

            return redirect('/setting/app-configuration')->with('success', 'Update Successfully!');
        }
        else if($req->type=="update"){
            DB::table('tbl_setting')->where('id',1)->update([
                'up_version'=>$req->up_version,
                'up_mode'=>$req->up_mode,
                'up_msg'=>$req->up_msg,
                'up_link'=>$req->up_link,
                'up_btn'=>$req->up_btn,
                'up_status'=>$req->up_status,
                ]);
                
             return redirect('/setting/update-maintenance')->with('success', 'Update Successfully!');
      
        }
        else if($req->type=="general"){
            
            if($req->icon){
                 $image_path = "/images/favicon.png";
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
                 
                $image = $req->icon;

                $fileNameToStore = 'favicon.png';
                $image_resize = Image::make($image->getRealPath());
                $image_resize->resize(76,76);
                $save = $image_resize->save('images/' . $fileNameToStore);
            }
            
            
            DB::table('tbl_setting')->where('id',1)->update([
                'app_author'=>$req->app_author,
                'app_email'=>$req->app_email,
                'app_website'=>$req->app_website,
                'privacy_policy'=>$req->privacy_policy,
                'insta'=>$req->insta,
                'youtube'=>$req->youtube,
                'telegram'=>$req->telegram,
                'app_description'=>$req->app_description,
                'refer_msg'=>$req->refer_msg,
                ]);
                
             return redirect('/setting/general')->with('success', 'Update Successfully!');
      
        }
    }

    public static function updateData($key, $value)
    {
        $path = base_path('.env');

        if (file_exists($path)) {

            file_put_contents($path, str_replace(
                $key . '=' . env($key),
                $key . '=' . $value,
                file_get_contents($path)
            ));
        }
    }
}
