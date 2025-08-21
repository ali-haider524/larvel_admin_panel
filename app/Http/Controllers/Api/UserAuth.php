<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Users;
use Validator;
use Illuminate\Support\Facades\Hash;
use JWTAuth, DB, GeoIP;
use Tymon\JWTAuth\Exceptions\JWTException;
use Carbon\Carbon;
use Mail;
use App\Mail\NotifyMail;
use Illuminate\Mail\SentMessage;

class UserAuth extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'reset_password', 'verify_otp', 'update_password']]);
        $this->guard = "api";
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $req = json_decode(base64_decode(request()->i), true);

        $key=$req['i3'];
        if($req['type']=="" || $key==""){
            return $this->respError("Something went wrong!");      
        }
        if($key!= md5(env('API_KEY').$req['type'])){
            return $this->respError("Something went wrong!!" );      
        }



        if ($req['type'] == 0) {
            if ($req['person_id'] != null) {
                return $this->Googleregister($req);
            } else {
                return $this->register($req);
            }
        } else if ($req['type'] == 1) {
            return $this->googlelogin($req);
        } else if ($req['type'] == 2) {
            $validator = Validator::make($req, [
                'email' => 'required|email',
                'password' => 'required|string|min:5',
            ]);
        }


        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'code' => 401]);
        }
        
        
        $user = Users::where('email',$req['email'])->first();
        if ($user) {
            try {
            if(!Hash::check($req['password'],$user->password)) {
                   return response()->json([
                    'code' => 404,
                    'message' => 'Login credentials are invalid!.',
                ]);
            }
                
            if (!$token = JWTAuth::fromUser($user)) {

                return response()->json([
                    'code' => 404,
                    'message' => 'Login credentials are invalid.',
                ]);
            }
            } catch (JWTException $e) {
                return $credentials;
                return response()->json([
                    'code' => 404,
                    'message' => 'Could not create token.'
                ]);
            }
        }else{
              return response()->json([
                    'code' => 404,
                    'message' => 'Account Not Exist!!.',
             ]);
        }

        if (env('SEC_BLOCK_ROOT') == 0 && $req['root'] == "true") {
            $this->logmonitor($user->cust_id, " Rooted Device.");

            if (env('SEC_AUTOBAN_ROOT') == 0 && $req['root'] == "true") {
                $this->banuser($user->cust_id, "Account Banned for Security Reason Rooted Device.");
                $this->logmonitor($user->cust_id, "Root Device.");
                return response()->json(['message' => 'Account Banned for Security Reason Used Rooted Device.', 'code' => 401]);
            }

            return response()->json(['message' => 'Security Reason You Cant Use App on Rooted Device.', 'code' => 401]);
        }

        if ($user->country != null) {
            geoip()->getLocation(null);
            $ip = UserAuth::IpAddr();
            $arr_ip = geoip()->getLocation($ip);

            /* if (auth()->user()->country != $arr_ip->iso_code && env('SEC_AUTOBAN_COUNTRY_CHANGE') == 0) {
                $this->banuser(auth()->user()->cust_id, "Account Banned for Security Reason Country Changed.");
                $this->logmonitor(auth()->user()->cust_id, "Country Changed.");
                return response()->json(['message' => 'Account Banned for Security Reason Country Changed.', 'code' => 401]);
            }*/
        }
        
        if ($user->status==1) {
                 return response()->json(['message' => $user->reason, 'code' => 401]);
        }

        if ($user->updated_at != date('Y-m-d')) {
            Users::where('cust_id', $user->cust_id)->update(['updated_at' => date('Y-m-d')]);
        }


        // Get the token
            return $this->createNewTokenGoogle($user, $token);
    }


    public function register($req)
    {
        $validator = Validator::make($req, [
            'name' => 'required|string|between:4,15|regex:/^[\w ]+$/|unique:customer',
            'email' => 'required|string|email|max:40|unique:customer',
            'password' => 'required|string|min:6',
            'token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'code' => 401]);
        }

        if (env('SEC_ONE_DEVICE') == 0) {
            $cd = Users::where('token', $req['token'])->count();
            if ($cd > 0) {
                return response()->json(['message' => 'Account Already Exist', 'code' => 401]);
            }
        }

        geoip()->getLocation(null);
        $ip = UserAuth::IpAddr();
        $arr_ip = geoip()->getLocation($ip);

        $user               = new Users;
        $user->name         =       $req['name'];
        $user->email        =       $req['email'];
        $user->token        =       $req['token'];
        $user->profile      =       $req['profile'];
        $user->p_token      =       $req['p_token'];
        $user->password     =       Hash::make($req['password']);
        $user->type         =       "email";
        $user->refferal_id  =       UserAuth::genUserCode();
        $user->ip           =       $ip;
        $user->country      =       $arr_ip->iso_code;
        $res_user = $user->save();

        return response()->json([
            'message' => 'Account Created Successfully Click to Login Now', 'code' => 201
        ]);
    }

    public function googlelogin($req)
    {
        $validator = Validator::make($req, [
            'email' => 'required|string|email|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'code' => 401]);
        }
        $user = Users::where(['person_id' => $req['person_id'], 'email' => $req['email']])->first();

        if ($user) {
            try {
                if (!$token = JWTAuth::fromUser($user)) {
                    return response()->json([
                        'code' => 401,
                        'message' => 'Login credentials are invalid.',
                    ]);
                }
            } catch (JWTException $e) {
                return $credentials;
                return response()->json([
                    'code' => 401,
                    'message' => 'Could not create.',
                ]);
            }


            if (env('SEC_BLOCK_ROOT') == 0 && $req['root'] == "true") {
                $this->logmonitor(auth()->user()->cust_id, " Rooted Device.");

                if (env('SEC_AUTOBAN_ROOT') == 0 && $req['root'] == "true") {
                    $this->banuser(auth()->user()->cust_id, "Account Banned for Security Reason Rooted Device.");
                    $this->logmonitor(auth()->user()->cust_id, "Root Device.");
                    return response()->json(['message' => 'Account Banned for Security Reason Used Rooted Device.', 'code' => 401]);
                }

                return response()->json(['message' => 'Security Reason You Cant Use App on Rooted Device.', 'code' => 401]);
            }
            if ($user->country != null) {
                geoip()->getLocation(null);
                $ip = UserAuth::IpAddr();
                $arr_ip = geoip()->getLocation($ip);

                /* if ($user->country != $arr_ip->iso_code && env('SEC_AUTOBAN_COUNTRY_CHANGE') == 0) {
                    $this->banuser($user->cust_id, "Account Banned for Security Reason Country Changed.");
                    $this->logmonitor($user->cust_id, "Country Changed.");
                    return response()->json(['message' => 'Account Banned for Security Reason Country Changed.', 'code' => 401]);
                }*/
            }

         if ($user->status==1) {
                 return response()->json(['message' => $user->reason, 'code' => 401]);
        }
            if ($user->updated_at != date('Y-m-d')) {
                Users::where('cust_id', $user->cust_id)->update(['updated_at' => Carbon::now()]);
            }

            return $this->createNewTokenGoogle($user, $token);
        } else {
            return response()->json([
                'code' => 401,
                'message' => 'Login credentials are invalid.',
            ]);
        }
    }

    public function Googleregister($req)
    {
        $validator = Validator::make($req, [
            'email' => 'required|string|email|max:100|unique:users',
        ]);


        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'code' => 401]);
        }
        if ($user = Users::where(['person_id' => $req['person_id'], 'email' => $req['email']])->first()) {

            try {
                if (!$token = JWTAuth::fromUser($user)) {
                    return response()->json([
                        'code' => 401,
                        'message' => 'Login credentials are invalid.',
                    ]);
                }
            } catch (JWTException $e) {
                return $credentials;
                return response()->json([
                    'code' => 401,
                    'message' => 'Could not create.',
                ]);
            }


            if (env('SEC_BLOCK_ROOT') == 0 && $req['root'] == "true") {
                $this->logmonitor(auth()->user()->cust_id, " Rooted Device.");

                if (env('SEC_AUTOBAN_ROOT') == 0 && $req['root'] == "true") {
                    $this->banuser(auth()->user()->cust_id, "Account Banned for Security Reason Rooted Device.");
                    $this->logmonitor(auth()->user()->cust_id, "Root Device.");
                    return response()->json(['message' => 'Account Banned for Security Reason Used Rooted Device.', 'code' => 401]);
                }

                return response()->json(['message' => 'Security Reason You Cant Use App on Rooted Device.', 'code' => 401]);
            }

            if ($user->country != null) {
                geoip()->getLocation(null);
                $ip = UserAuth::IpAddr();
                $arr_ip = geoip()->getLocation($ip);

                /*  if ($user->country != $arr_ip->iso_code && env('SEC_AUTOBAN_COUNTRY_CHANGE') == 0) {
                    $this->banuser($user->cust_id, "Account Banned for Security Reason Country Changed.");
                    $this->logmonitor($user->cust_id, "Country Changed.");
                    return response()->json(['message' => 'Account Banned for Security Reason Country Changed.', 'code' => 401]);
                }*/
            }
            
             if ($user->status==1) {
                 return response()->json(['message' => $user->reason, 'code' => 401]);
             }

            if ($user->updated_at != date('Y-m-d')) {
                Users::where('cust_id', $user->cust_id)->update(['updated_at' => Carbon::now()]);
            }

            return $this->createNewTokenGoogle($user, $token);
        } else {

            $validator = Validator::make($req, [
                'name' => 'required|string|between:4,100',
                'email' => 'required|string|email|max:100|unique:users',
                'token' => 'required|string',
            ]);


            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->first(), 'code' => 401]);
            }

            if (env('SEC_ONE_DEVICE') == 0) {
                $cd = Users::where('token', $req['token'])->count();
                if ($cd > 0) {
                    return response()->json(['message' => 'Account Already Exist', 'code' => 401]);
                }
            }

            geoip()->getLocation(null);
            $ip = UserAuth::IpAddr();
            $arr_ip = geoip()->getLocation($ip);
            $user               = new Users;
            $user->name         =       $req['name'];
            $user->email        =       $req['email'];
            $user->token        =       $req['token'];
            $user->person_id    =       $req['person_id'];
            $user->profile      =       $req['profile'];
            $user->p_token      =       $req['p_token'];
            $user->type         =       "google";
            $user->refferal_id  =       UserAuth::genUserCode();
            $user->ip           =       $ip;
            $user->country      =       $arr_ip->iso_code;
            $user->save();

            $usr = Users::where('cust_id', $user->cust_id)->first();
            try {
                if (!$token = JWTAuth::fromUser($usr)) {
                    return response()->json([
                        'code' => 401,
                        'message' => 'Login credentials are invalid.',
                    ]);
                }
            } catch (JWTException $e) {
                return $credentials;
                return response()->json([
                    'code' => 401,
                    'message' => 'Could not create.',
                ]);
            }
            
            

            if ($user->updated_at != date('Y-m-d')) {
                Users::where('cust_id', $user->cust_id)->update(['updated_at' => Carbon::now()]);
            }
            return $this->createNewTokenGoogle($usr, $token);
        }
    }

    protected function createNewTokenGoogle($user, $token)
    {
        return response()->json([
            'resp' => $token . $user->refferal_id,
            'user' => $user,
            'message' => 'Login Successfull',
            'code' => 201,
            'noti' => $this->notiCount($user->cust_id)
        ]);
    }



    public function genUserCode()
    {
        $this->refferal_id = [
            'refferal_id' => mt_rand(123456, 999999)
        ];

        $rules = ['refferal_id' => 'unique:customer'];

        $validate = Validator::make($this->refferal_id, $rules)->passes();

        return $validate ? $this->refferal_id['refferal_id'] : $this->genUserCode();
    }

    function banuser($userid, $reason)
    {
        $user = Users::find($userid);
        $user->status = 1;
        $user->balance = 0;
        $user->reason = $reason;
        $user->banned_time = Carbon::now();
        $user->save();
    }

    function logmonitor($userid, $type)
    {
        DB::table('monitor_report')->insert(['userid' => $userid, 'type' => $type]);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }

    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    public function userProfile()
    {

        return response()->json(auth()->user());
    }

    public function accountHistory()
    {
        $user = JWTAuth::User();
        $data = DB::table('transaction')->where('user_id', $user->cust_id)->orderBy('id', 'DESC')->select('tran_type', 'type', 'amount', 'remarks', 'inserted_at')->limit(40)->get();
        return response()->json($data);
    }

    public function rewardHistory()
    {
        $user = JWTAuth::User();
        $data = DB::table('recharge_request')->where('user_id', $user->cust_id)->orderBy('request_id', 'DESC')->select('request_id', 'mobile_no', 'type', 'amount', 'updated_at', 'status', 'remarks', 'date')->limit(10)->get();
        return response()->json($data);
    }

    public function guard()
    {
        return Auth::guard();
    }

    protected function createNewToken($token)
    {
        return response()->json([
            'resp' => $token . auth()->user()->refferal_id,
            'user' => auth()->user(),
            'message' => 'Login Successfull',
            'code' => 201,
            'noti' => $this->notiCount(auth()->user()->cust_id)
        ]);
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

    function notiCount($id)
    {
        return DB::table('tbl_noti')->where(['user_id' => $id, 'noti_type' => 0, 'status' => 0])->orWhere(['user_id' => 0, 'noti_type' => 1])->count();
    }

    public function reset_password(Request $req)
    {
        
        if($req->type=="reset"){
                $appname = config('app.name');
                $valideator = Validator::make($req->all(), [
                    'email'    => 'email|exists:customer'
                ], [
                    'email.email' => 'Enter Valid Email !',
                    'email.exists' => 'Email Not Found !'
                ]);
        
                
                if ($valideator->fails()) {
                    return response()->json(['msg' => $valideator->errors()->first(), 'code' => 404]);
                }
                
                $cnt = DB::table('customer')->where('email', $req->email)->get()->first()->type;
                if ($cnt == "google") {
                    return response()->json(['msg' => 'Account linked with Google login', 'code' => 404]);
                }
        
        
                $otp = mt_rand(1234, 9999);
        
                $details = [
                    'title' => $appname,
                    'body' => 'Your Password Reset OTP is ' . $otp
                ];
                Mail::to($req->email)->send(new NotifyMail($details));
                DB::table('password_reset')->insert(
                    ['email' => $req->email, 'token' => '', 'otp' => $otp]
                );
        
                return response(['code' => 201, 'msg' => 'OTP has been Sent To Your Mail']);
        }else{
                $appname = config('app.name');
                $valideator = Validator::make($req->all(), [
                    'email'    => 'email|exists:customer'
                ], [
                    'email.email' => 'Enter Valid Email !',
                    'email.exists' => 'Email Not Found !'
                ]);
        
                if ($valideator->fails()) {
                    return response()->json(['msg' => $valideator->errors()->first(), 'code' => 404]);
                }
        
                $otp = mt_rand(1234, 9999);
        
                $details = [
                    'title' => $appname,
                    'body' => 'Your Email Verification OTP is ' . $otp
                ];
                Mail::to($req->email)->send(new NotifyMail($details));
                DB::table('password_reset')->insert(
                    ['email' => $req->email, 'token' => '', 'otp' => $otp]
                );
        
                return response(['code' => 201, 'msg' => 'OTP has been Sent To Your Mail']);
        }
    }
       

    public function verify_otp(Request $req)
    {
        $otp = $req->otp;
        $dataotp = DB::table('password_reset')->where('email', $req->email)->orderBy('id', 'DESC')->limit(1)->get()->first()->otp;

        if ($otp == $dataotp) {
            return response()->json(['code' => 201, 'data' => $dataotp, 'msg' => 'Otp verified']);
        } else {
            return response()->json(['code' => 400, 'msg' => 'Wrong OTP']);
        }
    }

    public function update_password(Request $req)
    {
        $data = Users::where('email', $req->email)->get();
        $userid = $data[0]->cust_id;

        $otp = $req->otp;
        $dataotp = DB::table('password_reset')->where('email', $req->email)->orderBy('id', 'DESC')->limit(1)->get()->first()->otp;

        if ($otp != $dataotp) {
            return response()->json(['code' => 400, 'msg' => 'Wrong OTP']);
        }

        $update = Users::find($userid);
        $update->password = Hash::make($req->password);
        $update->save();
        if ($update) {
            return response()->json(['msg' => 'Password Updated Successfully Login Now', 'code' => 201]);
        } else {
            return response()->json(['msg' => 'Error to Update Password', 'code' => 400]);
        }
    }
}
