<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Transaction_ extends Controller
{
    public function index()
    {
        $data = DB::table('transaction')->
                join('customer','customer.cust_id','=','transaction.user_id')
                ->select('transaction.*','customer.name')
                ->orderBy('id','DESC')->paginate();
        
        return view('pages.transaction', compact('data'));
    }
    
    public function coinstoreTransaction()
    {
        $data = DB::table('payment_transaction')->
                join('customer','customer.cust_id','=','payment_transaction.userid')
                ->select('payment_transaction.*','customer.name')
                ->orderBy('id','DESC')->paginate();
        
        return view('pages.payment_transaction', compact('data'));
    }

   
    public function userProfile($id){
        $users=Users::find($id);
        $lastused=DB::table('personal_access_tokens')->where('tokenable_id',$id)->get();
        if($lastused->isEmpty()){
            $lastLogin="";
        }else{
            $lastLogin=$lastused[0]->last_used_at;
        }
        $redeem=DB::table('recharge_request')->where('user_id',$id)->orderBy('date','DESC')->paginate(15);
        $trans=Transaction::where('user_id',$id)->orderBy('id','DESC')->fastPaginate();
        return view('pages.track',['user'=>$users,'lastLogin'=>$lastLogin,'redeem'=>$redeem,'data'=>$trans]);
    }
}
