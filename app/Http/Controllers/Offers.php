<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\AppOffer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Offers extends Controller
{
    public function index()
    {
        $data = AppOffer::where('status', '!=', 1)->orderBy('id', 'DESC')->paginate();
        return view('offer.active', compact('data'));
    }


    public function indexComplete()
    {
        $data = AppOffer::where('status',1)->orderBy('id', 'DESC')->paginate();
        return view('offer.completed', compact('data'));
    }

    public function edit(AppOffer $id)
    {
        $data = $id;
        return view('offer/edit', compact('data'));
    }

    public function create()
    {
        return view('offer.add');
    }

    public function store(Request $req)
    {
        $app = new AppOffer;
        $app->app_name = $req->app_name;
        $app->image = $req->image;
        $app->points = $req->points;
        $app->appurl = $req->appurl;
        $app->appID = $req->appID;
        $app->country = $req->country;
        $app->p_userid = $req->p_userid;
        $app->response_code = $req->response_code;
        $app->task_limit = $req->task_limit;
        $app->details = $req->details;
        $res=$app->save();

        if ($res) {
            return redirect('/offers/active')->with('success', ' Created Successfully!');
        } else {
            return redirect('/offers/add')->with('error', 'Technical Error!');
        }
    }

    public function update(Request $req)
    {
        $app = AppOffer::find($req->id);
        $app->app_name = $req->app_name;
        $app->image = $req->image;
        $app->points = $req->points;
        $app->appurl = $req->appurl;
        $app->country = $req->country;
        $app->appID = $req->appID;
        $app->p_userid = $req->p_userid;
        $app->task_limit = $req->task_limit;
        $app->response_code = $req->response_code;
        $app->details = $req->details;
        $res=$app->save();

        if ($res) {
            return redirect('/offers/active')->with('success', ' Update Successfully!');
        } else {
            return redirect('/offers/add')->with('error', 'Technical Error!');
        }
    }


    public function destroy($id)
    {
        AppOffer::where('id', $id)->delete();
        return 1;
    }

    public function action(Request $req)
    {

        if ($req->status == "delete") {
            $update = AppOffer::whereIn('id', explode(",", $req->id))->delete();
            DB::table('appslog')->whereIn('appid',explode(",", $req->id))->delete();
            if ($update) {
                return 1;
            } else {
                return "not updated";
            }
        } else if ($req->status == "enable") {
            $update = AppOffer::whereIn('id', explode(",", $req->id))->update(['status' => 0]);
            if ($update) {
                return 1;
            } else {
                return "not updated";
            }
        } else if ($req->status == "disable") {
            $update = AppOffer::whereIn('id', explode(",", $req->id))->update(['status' => 2]);
            if ($update) {
                return 1;
            } else {
                return "not updated";
            }
        }
    }
}
