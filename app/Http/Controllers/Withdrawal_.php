<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Transaction;
use App\Models\Recharge;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use File, Image;
use Carbon\Carbon;

class Withdrawal_ extends Controller
{
    public function index()
    {
        $data = DB::table('redeem_cat')->paginate();
        return view('withdrawal.index', compact('data'));
    }

    public function edit($id)
    {
        return DB::table('redeem_cat')->where('id', $id)->get();
    }

    public function store(Request $req)
    {
        $image = $req->icon;
        $filenameWithExt = $image->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
        $filename = preg_replace("/\s+/", '-', $filename);
        $extension = $image->getClientOriginalExtension();
        $fileNameToStore = $filename . '_' . time() . '.' . $extension;
        $image_resize = Image::make($image->getRealPath());
        $image_resize->resize(200, 150);
        $save = $image_resize->save('images/' . $fileNameToStore);

        if ($save) {
            $res = DB::table('redeem_cat')->insert([
                'name' => $req->name,
                'country' => $req->country,
                'image' => $fileNameToStore
            ]);
            if ($res) {
                return redirect('/withdrawal')->with('success', 'Added Successfully!');
            } else {
                return redirect('/withdrawal')->with('error', 'Technical Error!');
            }
        } else {
            return redirect('/withdrawal')->with('error', 'Imagem not uploaded!');
        }
    }

    public function update(Request $req)
    {
        if ($req->icon) {
            $image = $req->icon;
            $filenameWithExt = $image->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
            $filename = preg_replace("/\s+/", '-', $filename);
            $extension = $image->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(200, 150);
            $save = $image_resize->save('images/' . $fileNameToStore);
            $image_path = "/images/" . $req->oldicon;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            $icon = $fileNameToStore;
        } else {
            $icon = $req->oldicon;
        }

        $res = DB::table('redeem_cat')->where('id', $req->id)->update([
            'name' => $req->name,
            'country' => $req->country,
            'image' => $icon
        ]);
        if ($res) {
            return redirect('/withdrawal')->with('success', 'Update Successfully!');
        } else {
            return redirect('/withdrawal')->with('error', 'Technical Error!');
        }
    }

    public function actionCat(Request $req)
    {
        if ($req->status == "enable") {
            $update = DB::table('redeem_cat')->whereIn('id', explode(",", $req->id))->update(['status' => 0]);
            if ($update) {
                return 1;
            } else {
                return "not updated";
            }
        } else if ($req->status == "disable") {
            $update = DB::table('redeem_cat')->whereIn('id', explode(",", $req->id))->update(['status' => 1]);
            if ($update) {
                return 1;
            } else {
                return "not updated";
            }
        }
    }


    public function indexData($id)
    {
        $data = DB::table('redeem')->where('category', $id)->paginate();
        $n = DB::table('redeem_cat')->where('id', $id)->get()->first()->name;
        return view('withdrawal.catData', ['data' => $data, 'name' => $n]);
    }

    public function addData($id)
    {
        return view('withdrawal/addmethod', ['id' => $id]);
    }

    public function storeData(Request $req)
    {
        $data = DB::table('redeem')->insert([
            'category' => $req->category,
            'title' => $req->title,
            'points' => $req->points,
            'country' => $req->country,
            'refer' => $req->refer,
            'task' => $req->task,
            'quantity' => $req->quantity,
            'placeholder' => $req->placeholder,
            'input_type' => $req->input_type
        ]);

        if ($data) {
            return redirect('/withdrawal/method/' . $req->category)->with('error', 'Add Successfully!');
        } else {
            return redirect('/withdrawal/method/add/' . $req->category)->with('error', 'Technical error!');
        }
    }

    public function editData($id)
    {
        $data = DB::table('redeem')->where('id', $id)->get();
        return view('withdrawal.editmethod', ['data' => $data]);
    }

    public function updateData(Request $req)
    {
        $data = DB::table('redeem')->where('id', $req->id)->update([
            'category' => $req->category,
            'title' => $req->title,
            'points' => $req->points,
            'country' => $req->country,
            'refer' => $req->refer,
            'task' => $req->task,
            'quantity' => $req->quantity,
            'placeholder' => $req->placeholder,
            'input_type' => $req->input_type
        ]);

        if ($data) {
            return redirect('/withdrawal/method/' . $req->category)->with('error', 'Update Successfully!');
        } else {
            return redirect('/withdrawal/method/add/' . $req->category)->with('error', 'Technical error!');
        }
    }

    public function deleteMethod($id)
    {
        DB::table('redeem')->where('id', $id)->delete();
        return 1;
    }

    public function actionMethod(Request $req)
    {
        if ($req->status == "enable") {
            $update = DB::table('redeem')->whereIn('id', explode(",", $req->id))->update(['status' => 0]);
            if ($update) {
                return 1;
            } else {
                return "not updated";
            }
        } else if ($req->status == "disable") {
            $update = DB::table('redeem')->whereIn('id', explode(",", $req->id))->update(['status' => 1]);
            if ($update) {
                return 1;
            } else {
                return "not updated";
            }
        }
    }


    public function indexPending()
    {
        $data = Recharge::where('status', 'Pending')->paginate();
        return view('withdrawal.pending', compact('data'));
    }

    public function indexComplete()
    {
        $data = Recharge::where('status', 'Success')->orderBy('updated_at', 'DESC')->paginate();
        return view('withdrawal.complete', compact('data'));
    }

    public function indexReject()
    {
        $data = Recharge::where('status', 'Reject')->orderBy('updated_at', 'DESC')->paginate();
        return view('withdrawal.reject', compact('data'));
    }


    public function removeWithdrawal($id)
    {
        Recharge::where('request_id', $id)->delete();
        return 1;
    }

    public function statusUpdate(Request $req)
    {
        if ($req->type == "Success") {
            $payment = Recharge::find($req->id);
            $payment->status = 'Success';
            $payment->remarks = $req->remark;
            $payment->updated_at = Carbon::now();

            $user = Users::find($payment->user_id);
            $res = $payment->save();
            DB::table('tbl_noti')->insert(['user_id' => $payment->user_id, 'title' => $payment->type, 'msg' => $req->remark, 'created_at' => Carbon::now()]);
            $trns = DB::table('transaction')
                ->insert([
                    'tran_type' => 'debit',
                    'user_id' => $payment->user_id,
                    'type' => 'Withdraw',
                    'amount' => $payment->amount,
                    'remained_balance' => $user->balance,
                    'remarks' => $req->remark
                ]);
            return redirect('/withdrawal/pending')->with('success', 'Update Successfully!');
        } else {

            $payment = Recharge::find($req->id);
            $payment->status = 'Reject';
            $payment->remarks = $req->remark;
            $payment->updated_at = Carbon::now();

            DB::table('tbl_noti')->insert(['user_id' => $payment->user_id, 'title' => $payment->type, 'msg' => $req->remark, 'created_at' => Carbon::now()]);

            $user = Users::find($payment->user_id);
            $user->balance = $user->balance + $payment->amount;
            $user->save();
            $res = $payment->save();
            if ($res) {
                $trns = DB::table('transaction')
                    ->insert([
                        'tran_type' => 'credit',
                        'type' => 'Withdraw',
                        'user_id' => $payment->user_id,
                        'amount' => $payment->amount,
                        'remained_balance' => $user->balance,
                        'remarks' => $req->remark
                    ]);
            }

            return redirect('/withdrawal/pending')->with('success', 'Update Successfully!');

        }
    }

    public function action(Request $req)
    {

        if ($req->status == "delete") {
            $update = Recharge::whereIn('request_id', explode(",", $req->id))->delete();
            if ($update) {
                return 1;
            } else {
                return "not updated";
            }
        } else if ($req->status == "approve") {
            $arr = explode(",", $req->id);
            $leng = count($arr);

            $alias = DB::table('alias')->where('id', 1)->get()->first()->description;
            for ($i = 0; $i < $leng; $i++) {

                $payment = Recharge::find($arr[$i]);
                $payment->status = 'Success';
                $payment->remarks = $alias;
                $payment->updated_at = date('Y-m-d');

                $user = Users::find($payment->user_id);
                $res = $payment->save();
                DB::table('tbl_noti')->insert(['user_id' => $payment->user_id, 'title' => $payment->type, 'msg' => $alias, 'created_at' => Carbon::now()]);
                if ($res) {
                    $trns = DB::table('transaction')
                        ->insert([
                            'tran_type' => 'debit',
                            'user_id' => $payment->user_id,
                            'userid' => $user->userid,
                            'type' => 'Withdraw',
                            'amount' => $payment->amount,
                            'remained_balance' => $user->balance,
                            'remarks' => $alias
                        ]);
                }
            }

            return 1;
        } else if ($req->status == "reject") {
            $arr = explode(",", $req->id);
            $leng = count($arr);

            $alias = DB::table('alias')->where('id', 2)->get()->first()->description;
            for ($i = 0; $i < $leng; $i++) {

                $payment = Recharge::find($arr[$i]);
                $payment->status = 'Reject';
                $payment->remarks = $alias;
                $payment->updated_at = date('Y-m-d');
                DB::table('tbl_noti')->insert(['user_id' => $payment->user_id, 'title' => $payment->type, 'msg' => $alias, 'created_at' => Carbon::now()]);

                $user = Users::find($payment->user_id);
                $user->balance = $user->balance + $payment->amount;
                $user->save();
                $res = $payment->save();
                if ($res) {
                    $trns = DB::table('transaction')
                        ->insert([
                            'tran_type' => 'credit',
                            'user_id' => $payment->user_id,
                            'userid' => $user->userid,
                            'type' => 'Withdraw',
                            'amount' => $payment->amount,
                            'remained_balance' => $user->balance,
                            'remarks' => $alias
                        ]);
                }
            }
            return 1;
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


    public function destroy($id)
    {
        $banner = DB::table('redeem_cat')->where('id', $id)->get()->first()->image;
        $image_path = "/images/" . $banner;
        if (File::exists($image_path)) {
            File::delete($image_path);
        }
        DB::table('redeem_cat')->where('id', $id)->delete();
        return 1;
    }
}
