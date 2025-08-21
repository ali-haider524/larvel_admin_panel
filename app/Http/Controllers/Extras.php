<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Slider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Image;
use File;
use Carbon\Carbon;

class Extras extends Controller
{


    // Promotion Banner
    public function index()
    {
        $data = DB::table('home_banner')->orderBy('id', 'DESC')->paginate();
        return view('pages/banner', compact('data'));
    }

    public function storeBanner(Request $request)
    {
        $image = $request->icon;
        $filenameWithExt = $image->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
        $filename = preg_replace("/\s+/", '-', $filename);
        $extension = $image->getClientOriginalExtension();
        $fileNameToStore = $filename . '_' . time() . '.' . $extension;
        $image_resize = Image::make($image->getRealPath());
        if ($request->bannertype == "slide") {
            $image_resize->resize(400, 200);
        } else {
            $image_resize->resize(250, 250);
        }
        $save = $image_resize->save('images/' . $fileNameToStore);

        if ($save) {
            $banner = new Slider;
            $banner->onclick = $request->onclick;
            $banner->link = $request->link;
            $banner->bannertype = $request->bannertype;
            $banner->banner = $fileNameToStore;
            $res = $banner->save();
            if ($res) {
                return redirect('/banner')->with('success', 'Added Successfully!');
            } else {
                return redirect('/banner')->with('error', 'Technical Error!');
            }
        } else {
            return redirect('/banner')->with('error', 'Imagem not uploaded!');
        }
    }

    public function editBanner(Slider $id)
    {
        return $id;
    }

    public function updateBanner(Request $request)
    {
        if ($request->icon) {
            $image = $request->icon;
            $filenameWithExt = $image->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
            $filename = preg_replace("/\s+/", '-', $filename);
            $extension = $image->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $image_resize = Image::make($image->getRealPath());
            if ($request->bannertype == "slide") {
                $image_resize->resize(400, 200);
            } else {
                $image_resize->resize(250, 250);
            }
            $save = $image_resize->save('images/' . $fileNameToStore);
            $image_path = "/images/" . $request->oldicon;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }

            $icon = $fileNameToStore;
        } else {
            $icon = $request->oldicon;
        }

        if ($icon) {
            $banner = Slider::find($request->id);
            $banner->onclick = $request->onclick;
            $banner->link = $request->link;
            $banner->bannertype = $request->bannertype;
            $banner->banner = $icon;
            $res = $banner->save();
            if ($res) {
                return redirect('/banner')->with('success', 'Added Successfully!');
            } else {
                return redirect('/banner')->with('error', 'Technical Error!');
            }
        } else {
            return redirect('/banner')->with('error', 'Imagem not uploaded!');
        }
    }

    public function destroyBanner($id)
    {
        $banner = Slider::where('id', $id)->get()->first()->banner;
        $image_path = "/images/" . $banner;
        if (File::exists($image_path)) {
            File::delete($image_path);
        }
        Slider::find($id)->delete();
        return 1;
    }

    public function actionBanner(Request $req)
    {
        if ($req->status == "enable") {
            $update = Slider::whereIn('id', explode(",", $req->id))->update(['status' => 0]);
            if ($update) {
                return 1;
            } else {
                return "not updated";
            }
        } else if ($req->status == "disable") {
            $update = Slider::whereIn('id', explode(",", $req->id))->update(['status' => 1]);
            if ($update) {
                return 1;
            } else {
                return "not updated";
            }
        }
    }


    //PlayZone
    public function indexGame()
    {
        $data = DB::table('games')->orderBy('id', 'DESC')->paginate();
        return view('pages/game', compact('data'));
    }

    public function storeGame(Request $request)
    {
        $image = $request->icon;
        $filenameWithExt = $image->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
        $filename = preg_replace("/\s+/", '-', $filename);
        $extension = $image->getClientOriginalExtension();
        $fileNameToStore = $filename . '_' . time() . '.' . $extension;
        $image_resize = Image::make($image->getRealPath());
        $image_resize->resize(200, 200);
        $save = $image_resize->save('images/games/' . $fileNameToStore);

        if ($save) {
            $res = DB::table('games')->insert([
                'title' => $request->title,
                'link' => $request->link,
                'image' => $fileNameToStore,
                'created_at' => Carbon::now()
            ]);

            if ($res) {
                return redirect('/games')->with('success', 'Added Successfully!');
            } else {
                return redirect('/games')->with('error', 'Technical Error!');
            }
        } else {
            return redirect('/games')->with('error', 'Imagem not uploaded!');
        }
    }

    public function editGame($id)
    {
        return DB::table('games')->where('id', $id)->get();
    }

    public function updateGame(Request $request)
    {
        if ($request->icon) {
            $image = $request->icon;
            $filenameWithExt = $image->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
            $filename = preg_replace("/\s+/", '-', $filename);
            $extension = $image->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(200, 200);
            $save = $image_resize->save('images/games/' . $fileNameToStore);
            $image_path = "/images/" . $request->oldicon;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }

            $icon = $fileNameToStore;
        } else {
            $icon = $request->oldicon;
        }


        if ($icon) {
            $res = DB::table('games')->where('id', $request->id)->update([
                'title' => $request->title,
                'link' => $request->link,
                'image' => $icon,
                'created_at' => Carbon::now()
            ]);

            if ($res) {
                return redirect('/games')->with('success', 'Update Successfully!');
            } else {
                return redirect('/games')->with('error', 'Technical Error!');
            }
        } else {
            return redirect('/games')->with('error', 'Imagem not uploaded!');
        }
    }

    public function destroyGame($id)
    {
        $banner = DB::table('games')->where('id', $id)->get()->first()->image;
        $image_path = "/images/games/" . $banner;
        if (File::exists($image_path)) {
            File::delete($image_path);
        }
        DB::table('games')->where('id', $id)->delete();
        return 1;
    }

    public function actionGame(Request $req)
    {
        if ($req->status == "enable") {
            $update = DB::table('games')->whereIn('id', explode(",", $req->id))->update(['status' => 0]);
            if ($update) {
                return 1;
            } else {
                return "not updated";
            }
        } else if ($req->status == "disable") {
            $update = DB::table('games')->whereIn('id', explode(",", $req->id))->update(['status' => 1]);
            if ($update) {
                return 1;
            } else {
                return "not updated";
            }
        }
    }

    //Spin
    public function indexSpin()
    {
        $data = DB::table('spin_wheel')->orderBy('id', 'ASC')->paginate();
        return view('pages/spin', compact('data'));
    }

    public function storeSpin(Request $request)
    {
        $res = DB::table('spin_wheel')->insert([
            'coin' => $request->coin,
            'color' => $request->color,
            'created_at' => Carbon::now()
        ]);

        if ($res) {
            return redirect('/luckywheel')->with('success', 'Added Successfully!');
        } else {
            return redirect('/luckywheel')->with('error', 'Technical Error!');
        }
    }

    public function editSpin($id)
    {
        return DB::table('spin_wheel')->where('id', $id)->get();
    }

    public function updateSpin(Request $request)
    {
        $res = DB::table('spin_wheel')->where('id', $request->id)->update([
            'coin' => $request->coin,
            'color' => $request->color,
        ]);

        if ($res) {
            return redirect('/luckywheel')->with('success', 'Update Successfully!');
        } else {
            return redirect('/luckywheel')->with('error', 'Technical Error!');
        }
    }

    public function destroySpin($id)
    {
        DB::table('spin_wheel')->where('id', $id)->delete();
        return 1;
    }

    // Faq
    public function indexfaq()
    {
        $data = DB::table('faq')->orderBy('id', 'DESC')->paginate();
        return view('admin-setting/faq/index', compact('data'));
    }

    public function storefaq(Request $req)
    {
        $data = DB::table('faq')->insert([
            'type' => $req->type,
            'question' => $req->question,
            'answer' => $req->answer
        ]);

        if ($data) {
            return redirect('/faq')->with('success', 'Added Successfully!');
        } else {
            return redirect('/faq')->with('error', 'Technical Error!');
        }
    }

    public function editfaq($id)
    {
        return DB::table('faq')->where('id', $id)->get();
    }

    public function updatefaq(Request $req)
    {
        $data = DB::table('faq')->where('id', $req->id)->update([
            'type' => $req->type,
            'question' => $req->question,
            'answer' => $req->answer
        ]);

        if ($data) {
            return redirect('/faq')->with('success', 'Update Successfully!');
        } else {
            return redirect('/faq')->with('error', 'Technical Error!');
        }
    }

    public function destroyfaq($id)
    {
        DB::table('faq')->where('id', $id)->delete();
        return 1;
    }

    public function actionfaq(Request $req)
    {
        if ($req->status == "enable") {
            $update = DB::table('faq')->whereIn('id', explode(",", $req->id))->update(['status' => 0]);
            if ($update) {
                return 1;
            } else {
                return "not updated";
            }
        } else if ($req->status == "disable") {
            $update = DB::table('faq')->whereIn('id', explode(",", $req->id))->update(['status' => 1]);
            if ($update) {
                return 1;
            } else {
                return "not updated";
            }
        }
    }

    //coinstore
    public function indexStore()
    {
        $data = DB::table('coinstore')->orderBy('id')->paginate();
        return view('pages/coinstore', compact('data'));
    }

    public function storeCoin(Request $req)
    {
        $data = DB::table('coinstore')->insert([
            'title' => $req->title,
            'amount' => $req->amount,
            'inr_amount' => $req->inr_amount,
            'coin' => $req->coin,
            'productID' => 'inapp_' . uniqid(),
            'country' => $req->country
        ]);

        if ($data) {
            return redirect('/coinstore')->with('success', 'Added Successfully!');
        } else {
            return redirect('/coinstore')->with('error', 'Technical Error!');
        }
    }

    public function editStore($id)
    {
        return DB::table('coinstore')->where('id', $id)->get();
    }

    public function updateStore(Request $req)
    {
        $data = DB::table('coinstore')->where('id', $req->id)->update([
            'title' => $req->title,
            'amount' => $req->amount,
            'inr_amount' => $req->inr_amount,
            'coin' => $req->coin,
            'country' => $req->country
        ]);

        if ($data) {
            return redirect('/coinstore')->with('success', 'Update Successfully!');
        } else {
            return redirect('/coinstore')->with('error', 'Technical Error!');
        }
    }

    public function destroyStore($id)
    {
        DB::table('coinstore')->where('id', $id)->delete();
        return 1;
    }

    public function actionStore(Request $req)
    {
        if ($req->status == "enable") {
            $update = DB::table('coinstore')->whereIn('id', explode(",", $req->id))->update(['status' => 0]);
            if ($update) {
                return 1;
            } else {
                return "not updated";
            }
        } else if ($req->status == "disable") {
            $update = DB::table('coinstore')->whereIn('id', explode(",", $req->id))->update(['status' => 1]);
            if ($update) {
                return 1;
            } else {
                return "not updated";
            }
        }
    }

    //daily offer
    public function indexDaily()
    {
        $data = DB::table('tbl_dailyoffer')->paginate();
        return view('dailyoffer/index', compact('data'));
    }

    public function storeDaily(Request $req)
    {
        $res = DB::table('tbl_dailyoffer')->insert([
            'title' => $req->title,
            'coin' => $req->coin,
            'image' => $req->image,
            'link' => $req->link,
            'task_limit' => $req->task_limit,
            'country' => $req->country,
            'description' => $req->details
        ]);

        if ($res) {
            return redirect('/dailyoffer')->with('success', 'Added Successfully');
        } else {
            return redirect('/dailyoffer/add')->with('error', 'Technical Error');
        }
    }

    public function editDaily($id)
    {
        $data = DB::table('tbl_dailyoffer')->where('id', $id)->get();
        return view('dailyoffer/edit', compact('data'));
    }

    public function viewDaily($id)
    {
        $data = DB::table('tbl_dailyoffer')->where('id', $id)->get();
        return view('dailyoffer/view', compact('data'));
    }

    public function updateDaily(Request $req)
    {
        $res = DB::table('tbl_dailyoffer')->where('id', $req->id)->update([
            'title' => $req->title,
            'coin' => $req->coin,
            'image' => $req->image,
            'link' => $req->link,
            'task_limit' => $req->task_limit,
            'country' => $req->country,
            'description' => $req->details
        ]);

        return redirect('/dailyoffer')->with('success', 'Update Successfully');
    }

    public function destroyDaily($id)
    {
        DB::table('tbl_dailyoffer')->where('id', $id)->delete();
        return 1;
    }

    public function actionDaily(Request $req)
    {
        if ($req->status == "enable") {
            $update = DB::table('tbl_dailyoffer')->whereIn('id', explode(",", $req->id))->update(['status' => 0]);
            if ($update) {
                return 1;
            } else {
                return "not updated";
            }
        } else if ($req->status == "disable") {
            $update = DB::table('tbl_dailyoffer')->whereIn('id', explode(",", $req->id))->update(['status' => 1]);
            if ($update) {
                return 1;
            } else {
                return "not updated";
            }
        }
    }

    public function pendingDaily()
    {

        $data = DB::table('tbl_dailyoffer')->join('data_dailyoffer', 'data_dailyoffer.survey_id', '=', 'tbl_dailyoffer.id')
            ->select('data_dailyoffer.*', 'tbl_dailyoffer.description', 'tbl_dailyoffer.title', 'tbl_dailyoffer.coin', 'tbl_dailyoffer.link')
            ->where('data_dailyoffer.taskStatus',0)
            ->orderBy('data_dailyoffer.id','DESC')->paginate();

        return view('dailyoffer/pending', compact('data'));
    }
    
    public function viewApproveDaily()
    {

        $data = DB::table('tbl_dailyoffer')->join('data_dailyoffer', 'data_dailyoffer.survey_id', '=', 'tbl_dailyoffer.id')
            ->select('data_dailyoffer.*', 'tbl_dailyoffer.description', 'tbl_dailyoffer.title', 'tbl_dailyoffer.coin', 'tbl_dailyoffer.link')
            ->where('data_dailyoffer.taskStatus',1)
            ->orderBy('data_dailyoffer.id','DESC')->paginate();

        return view('dailyoffer/approved', compact('data'));
    }

    public function approveDaily($id)
    {
        if ($data = DB::table('data_dailyoffer')->where('id', $id)->get()) {
            $do = DB::table('tbl_dailyoffer')->where('id', $data[0]->survey_id)->get();
            $u = Users::find($data[0]->user_id);
            $tot = $u->balance + $do[0]->coin;
            $u->balance = $tot;
            $u->save();

            DB::table('data_dailyoffer')->where('id', $id)->update(['taskStatus' =>1, 'updated_at' => Carbon::now()]);
            DB::table('tbl_noti')->insert(['user_id' => $data[0]->user_id, 'title' => $do[0]->title, 'msg' => 'Daily Offer Completed', 'created_at' => Carbon::now()]);
            DB::table('transaction')
                ->insert([
                    'tran_type' => 'credit',
                    'user_id' => $data[0]->user_id,
                    'type' => $do[0]->title,
                    'amount' => $do[0]->coin,
                    'remained_balance' => $tot,
                    'remarks' => 'Daily Offer Completed'
                ]);

            return redirect('/dailyoffer/pending')->with('success', 'Approved Successfully');
        } else {
            return redirect()->back()->withErrors(['msgError' => 'Survey Not Found']);
        }
    }

    public function rejectDaily(Request $req)
    {

        if ($data = DB::table('data_dailyoffer')->where('id', $req->id)->get()) {
            $do = DB::table('tbl_dailyoffer')->where('id', $data[0]->survey_id)->get();
            DB::table('tbl_noti')->insert(['user_id' => $data[0]->user_id, 'title' => $do[0]->title, 'msg' => $req->reason, 'created_at' => Carbon::now()]);
            DB::table('tbl_dailyoffer')->where('id', $data[0]->survey_id)->update(['views' => ($do[0]->views - 1)]);
            DB::table('data_dailyoffer')->where('id', $req->id)->delete();
            
            return redirect('/dailyoffer/pending')->with('success', 'Reject Successfully');
        } else {
            return redirect()->back()->withErrors(['msgError' => 'Survey Not Found']);
        }
    }



    // active ticket

    public function activeTicket()
    {
        $data = DB::table('support_ticket')->where('status', '!=', 2)->paginate();
        return view('support/active', compact('data'));
    }

    public function closedTicket()
    {
        $data = DB::table('support_ticket')->where('status', '=', 2)->paginate();
        return view('support/closed', compact('data'));
    }


    public function updateTicket($status, $id)
    {
        DB::table('support_ticket')->where('id', $id)->update(['status' => $status, 'updated_at' => Carbon::now()]);
        $t = DB::table('support_ticket')->where('id', $id)->get();
        DB::table('tbl_noti')->insert(['user_id' => $t[0]->user_id, 'title' => $t[0]->subject, 'msg' => "Ticket Status Updated", 'created_at' => Carbon::now()]);

        return redirect('/support/ticket_active')->with('success', 'Ticket Status Update Successfully');
    }

    public function actionTicket(Request $req)
    {
        if ($req->status == "delete") {
            DB::table('support_ticket')->whereIn('id', explode(",", $req->id))->delete();
            return 1;
        } else if ($req->status == "onprocess") {
            $arr = explode(",", $req->id);
            $cnt = count($arr);
            for ($i = 0; $i < $cnt; $i++) {
                DB::table('support_ticket')->where('id', $arr[$i])->update(['status' => 1, 'updated_at' => Carbon::now()]);
                $t = DB::table('support_ticket')->where('id', $arr[$i])->get();
                DB::table('tbl_noti')->insert(['user_id' => $t[0]->user_id, 'title' => $t[0]->subject, 'msg' => "Ticket Status Updated", 'created_at' => Carbon::now()]);
            }

            return 1;
        } else if ($req->status == "closed") {
            $arr = explode(",", $req->id);
            $cnt = count($arr);
            for ($i = 0; $i < $cnt; $i++) {
                DB::table('support_ticket')->where('id', $arr[$i])->update(['status' => 2, 'updated_at' => Carbon::now()]);
                $t = DB::table('support_ticket')->where('id', $arr[$i])->get();
                DB::table('tbl_noti')->insert(['user_id' => $t[0]->user_id, 'title' => $t[0]->subject, 'msg' => "Ticket Status Updated", 'created_at' => Carbon::now()]);
            }

            return 1;
        }
    }
}
