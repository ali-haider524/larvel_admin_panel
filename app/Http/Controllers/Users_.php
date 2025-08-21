<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\Users;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Users_ extends Controller
{
    public function index()
    {
        $users = Users::orderBy('cust_id', 'DESC')->fastPaginate();

        return view('users.active-user', compact('users'));
    }

    public function BanIndex()
    {
        $users = Users::where('status',1)->orderBy('inserted_at', 'DESC')->paginate(15);
        return view('users.banned-user', compact('users'));
    }

    public function TopIndex()
    {
        $users = Users::orderBy('balance', 'DESC')->fastPaginate();

        return view('users.top-user', compact('users'));
    }

    public function searchQuery($query)
    {
        if ($query == "null") {
            $users = [];
            $query = '';
        } else {
            $query=trim($query);
            $users =DB::table('customer')->where('name','like','%'.$query.'%')
                ->orWhere('email', 'like', '%'.$query.'%')
                ->orWhere('country', 'like', '%'.$query.'%')
                ->orWhere('refferal_id', '=', $query)
                ->orWhere('ip', 'like', $query)
                ->orWhere('cust_id', '=', $query)->
                    paginate();
          
        }

        return view('users/search', ['users' => $users, 'query' => $query]);
    }


    public function removeUser($id)
    {
        try {
            DB::table('customer')->where('cust_id', $id)->delete();
            DB::table('transaction')->where('user_id', $id)->delete();
            DB::table('recharge_request')->where('user_id', $id)->delete();
            DB::table('appslog')->where('user_id', $id)->delete();
            DB::table('data_dailyoffer')->where('user_id', $id)->delete();
            DB::table('monitor_report')->where('userid', $id)->delete();
            return 1;
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['msgError' => 'cannot be deleted.']);
        }
    }
    
    public function removeTransaction($id){
        DB::table('transaction')->where('user_id', $id)->delete();
        return redirect('/user-track/' . $id)->with('success', 'History Cleared');
    }
    
    public function updateStatus(Request $request){
        
       $user = Users::find($request->id);
       if($user->status==0){
           $status=1;
       }else{
            $status=0;
       }
       
       $user->status=$status; 
       $user->reason=$request->reason; 
       $user->banned_time=Carbon::now(); 
       $res= $user->save();
        return redirect('/users/banned')->with('success','Account Status Updated !');
          
    }

    public function updateCoin(Request $req)
    {
        $user = Users::find($req->id);
        $coin = $req->coin;

        if ($req->type == 'debit') {
            if ($user->balance >= $coin) {
                  $total = $user->balance - $coin;
                    $user->balance = $total;
            }else{
                return back()->withErrors(['msgError' => 'Not Enough Coin in Wallet to Deduct.']);
            }
          
        } else {
            $total = $user->balance + $coin;
            $user->balance = $total;
        }

        $res = $user->save();
        if ($res) {
            DB::table('transaction')
                ->insert([
                    'tran_type' => $req->type,
                    'user_id' => $req->id,
                    'amount' => $coin,
                    'type' => 'Coin ' . $req->type,
                    'remained_balance' => $total,
                    'inserted_at' => Carbon::now(),
                    'remarks' => $req->remark
                ]);
            return redirect('/user-track/' . $req->id)->with('success', 'User Wallet Updated');
        } else {
              return back()->withErrors(['msgError' => 'Technical Error.']);
        }
    }
}
