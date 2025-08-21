<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\MOfferwall;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use File,Image;

use function Ramsey\Uuid\v1;

class Offerwall extends Controller
{
    
 
    public function create(){
        return view('offer.add');
    }

    public function store(Request $req){

    }

   


   //sdk
   
    public function index(){
        $data = MOfferwall::where('type','sdk')->paginate();
        return view('offerwall.sdk', compact('data'));
    }
    
    public function editsdk(MOfferwall $id){
        $network = array();
        foreach (json_decode($id->data) as $item) {
            array_push($network, ['name' => $item->key, 'value' => $item->value]);
        }
        $p=DB::table('postback')->where('offerwall_id',$id->id)->get();
        return view('offerwall/edit-sdk',['data'=>$id,'network'=>$network,'pb'=>$p]);
    }
    
    public function updateSdk(Request $req){
        if($req->icon){
            $image = $req->icon;
            $filenameWithExt = $image->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
            $filename = preg_replace("/\s+/", '-', $filename);
            $extension = $image->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(200,150);  
            $save= $image_resize->save('images/'.$fileNameToStore);
            $imagePath = public_path('images/'.$req->oldimage);
            if(File::exists($imagePath)){
               unlink($imagePath);
            }
            $icon=$fileNameToStore;
        }else{
            $icon=$req->oldimage;
        }
        
        
        $sdk=DB::table('offerwall')->where('id',$req->id)->get();
        $ofr = json_decode($sdk[0]->data);
        $data = array();
        $val = $req->keyval;
        $cnt =  count($val);
        for ($i = 0; $i < $cnt; $i++) {
            array_push($data, ['key' => $ofr[$i]->key, 'slug' => $ofr[$i]->slug, 'value' => $val[$i]]);
        }
        
        $u=DB::table('offerwall')->where('id',$req->id)->update([
            'title'=>$req->title,
            'offer_slug'=>$req->offer_slug,
            'thumb'=>$icon,
            'description'=>$req->description,
            'data'=>$data,
            'c_status'=>$req->tag,
            ]);
        
            if($req->userid!=""){ $puser=''.$req->userid; }else{$puser='';}
            if($req->appid!=""){ $pappid='&'.$req->appid; }else{$pappid='';}
            if($req->amount!=""){ $pamount='&'.$req->amount; }else{$pamount='';}
            if($req->p_offername!=""){ $p_offername='&'.$req->p_offername; }else{$p_offername='';}
            if($req->offerid!=""){ $pofferid='&'.$req->offerid; }else{$pofferid='';}
            if($req->ip!=""){ $pip='&'.$req->ip; }else{$pip='';}

          $domainURL = '&';

         $pb=DB::table('postback')->where('offerwall_id',$req->id)->update([
                'postback_url'=>$domainURL.$puser.$pamount.$pip.$pofferid.$p_offername,
                'offerwall_name'=>$req->title,
                'p_userid'=>$req->userid,
                'response_code'=>$req->response_code,
                'p_payout'=>$req->amount,
                'p_campaing_id'=>$req->offerid,
                'p_ip'=>$req->ip,
                'p_offername'=>$req->p_offername
                ]);
            
        return redirect('/offerwall/sdk')->with('success','Update SuccessFully!');
        
    }


    //web
    public function indexWeb(){
        $data = MOfferwall::where('type','web')->paginate();
        return view('offerwall.web', compact('data'));
    }
    
    public function editWeb(MOfferwall $id){
        $decode= json_decode($id->data);
         return view('offerwall.edit-web',[
          'data'=>$id,
          'offername'=>$decode[0]->offername,
          'offerwall_url'=>$decode[0]->offerwall_url,
          'header'=>$decode[0]->header,
          'pb'=>DB::table('postback')->where('offerwall_id',$id->id)->get()]);

    }
    
    public function createWeb(Request $req){
        
        $image = $req->icon;
        $filenameWithExt = $image->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
        $filename = preg_replace("/\s+/", '-', $filename);
        $extension = $image->getClientOriginalExtension();
        $fileNameToStore = $filename.'_'.time().'.'.$extension;
        $image_resize = Image::make($image->getRealPath());
        $image_resize->resize(200,150);  
        $save= $image_resize->save('images/'.$fileNameToStore);
        
         $data=array([
            'offername'=>$req->offername,
            'offerwall_url'=>$req->offerwall_url,
            'header'=>$req->header,
            'userid'=>$req->userid ]);

            $offer= new MOfferwall;
            $offer->title=$req->title;
            $offer->offer_slug=str_replace(' ','_',strtolower($req->title));
            $offer->thumb=$fileNameToStore;
            $offer->description=$req->description;
            $offer->data=json_encode($data);
            $offer->type='web';
            $offer->c_status=$req->tag;
            $offer->save();
            $id=$offer->id;
        
            if($req->userid!=""){ $puser=''.$req->userid; }else{$puser='';}
            if($req->amount!=""){ $pamount='&'.$req->amount; }else{$pamount='';}
            if($req->p_offername!=""){ $p_offername='&'.$req->p_offername; }else{$p_offername='';}
            if($req->offerid!=""){ $pofferid='&'.$req->offerid; }else{$pofferid='';}
            if($req->ip!=""){ $pip='&'.$req->ip; }else{$pip='';}
            
          $domainURL = '&';

         $pb=DB::table('postback')->insert([
                'postback_url'=>$domainURL.$puser.$pamount.$pip.$pofferid.$p_offername,
                'offerwall_id'=>$id,
                'offerwall_name'=>$req->title,
                'response_code'=>$req->response_code,
                'p_userid'=>$req->userid,
                'p_payout'=>$req->amount,
                'p_campaing_id'=>$req->offerid,
                'p_ip'=>$req->ip,
                'p_offername'=>$req->p_offername
                ]);
            
        return redirect('/offerwall/web')->with('success','Create SuccessFully!');
        
    }
    
    public function updateWeb(Request $req){
        if($req->icon){
            $image = $req->icon;
            $filenameWithExt = $image->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
            $filename = preg_replace("/\s+/", '-', $filename);
            $extension = $image->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(200,150);  
            $save= $image_resize->save('images/'.$fileNameToStore);
            $imagePath = public_path('images/'.$req->oldimage);
            if(File::exists($imagePath)){
               unlink($imagePath);
            }
            $icon=$fileNameToStore;
        }else{
            $icon=$req->oldimage;
        }
        
        
        $sdk=DB::table('offerwall')->where('id',$req->id)->get();
         $data=array([
            'offername'=>$req->title,
            'offerwall_url'=>$req->offerwall_url,
            'header'=>$req->header,
            'userid'=>$req->userid ]);
        
        
        $u=DB::table('offerwall')->where('id',$req->id)->update([
            'title'=>$req->title,
            'offer_slug'=>$req->offer_slug,
            'thumb'=>$icon,
            'description'=>$req->description,
            'data'=>json_encode($data),
            'c_status'=>$req->tag,
            ]);
        
            if($req->userid!=""){ $puser=''.$req->userid; }else{$puser='';}
            if($req->amount!=""){ $pamount='&'.$req->amount; }else{$pamount='';}
            if($req->p_offername!=""){ $p_offername='&'.$req->p_offername; }else{$p_offername='';}
            if($req->offerid!=""){ $pofferid='&'.$req->offerid; }else{$pofferid='';}
            if($req->ip!=""){ $pip='&'.$req->ip; }else{$pip='';}
            
          $domainURL = '&';

         $pb=DB::table('postback')->where('offerwall_id',$req->id)->update([
                'postback_url'=>$domainURL.$puser.$pamount.$pip.$pofferid.$p_offername,
                'offerwall_name'=>$req->title,
                'p_userid'=>$req->userid,
                'response_code'=>$req->response_code,
                'p_payout'=>$req->amount,
                'p_campaing_id'=>$req->offerid,
                'p_ip'=>$req->ip,
                'p_offername'=>$req->p_offername
                ]);
            
        return redirect('/offerwall/web')->with('success','Update SuccessFully!');
        
    }
    
     //api view
     public function indexApi(){
         $data = MOfferwall::where('type','api')->paginate();
         return view('offerwall.api', compact('data'));
     }
     
     public function createApi(Request $req){
        $image = $req->icon;
        $filenameWithExt = $image->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
        $filename = preg_replace("/\s+/", '-', $filename);
        $extension = $image->getClientOriginalExtension();
        $fileNameToStore = $filename.'_'.time().'.'.$extension;
        $image_resize = Image::make($image->getRealPath());
        $image_resize->resize(200,150);  
        $save= $image_resize->save('images/'.$fileNameToStore);
        
         $data=array([
            'offername'=>$req->offername,
            'offer_api_url'=>$req->offer_api_url,
            'header'=>$req->header,
            'json_array'=>$req->json_array,
            'key_campid'=>$req->key_campid,
            'key_title'=>$req->key_title,
            'key_description'=>$req->key_description,
            'key_amount'=>$req->key_amount,
            'key_icon_url'=>$req->key_icon_url,
            'key_offer_link'=>$req->key_offer_link,
            'key_extra_suffix'=>$req->key_extra_suffix,
            'userid'=>$req->userid ]);
        
            $offer= new MOfferwall;
            $offer->title=$req->title;
            $offer->offer_slug=str_replace(' ','_',strtolower($req->title));
            $offer->thumb=$fileNameToStore;
            $offer->description=$req->description;
            $offer->data=json_encode($data);
            $offer->type='api';
            $offer->c_status=$req->tag;
            $offer->save();
            $id=$offer->id;
            
            if($req->userid!=""){ $puser=''.$req->userid; }else{$puser='';}
            if($req->amount!=""){ $pamount='&'.$req->amount; }else{$pamount='';}
            if($req->p_offername!=""){ $p_offername='&'.$req->p_offername; }else{$p_offername='';}
            if($req->offerid!=""){ $pofferid='&'.$req->offerid; }else{$pofferid='';}
            if($req->ip!=""){ $pip='&'.$req->ip; }else{$pip='';}
            
          $domainURL = '&';

         $pb=DB::table('postback')->insert([
                'postback_url'=>$domainURL.$puser.$pamount.$pip.$pofferid.$p_offername,
                'offerwall_id'=>$id,
                'offerwall_name'=>$req->title,
                'p_userid'=>$req->userid,
                'response_code'=>$req->response_code,
                'p_payout'=>$req->amount,
                'p_campaing_id'=>$req->offerid,
                'p_ip'=>$req->ip,
                'p_offername'=>$req->p_offername
                ]);
            
        return redirect('/offerwall/api')->with('success','Create SuccessFully!');    
     }
     
     public function editApi(MOfferwall $id){
         $decode= json_decode($id->data);
          return view('offerwall/edit-api',[
              'data'=>$id,
              'offername'=>$decode[0]->offername,
              'offer_api_url'=>$decode[0]->offer_api_url,
              'header'=>$decode[0]->header,
              'json_array'=>$decode[0]->json_array,
              'key_campid'=>$decode[0]->key_campid,
              'key_title'=>$decode[0]->key_title,
              'key_description'=>$decode[0]->key_description,
              'key_amount'=>$decode[0]->key_amount,
              'key_icon_url'=>$decode[0]->key_icon_url,
              'key_offer_link'=>$decode[0]->key_offer_link,
              'key_extra_suffix'=>$decode[0]->key_extra_suffix,
              'pb'=>DB::table('postback')->where('offerwall_id',$id->id)->get()]);
     }
     
     public function updateApi(Request $req){
        if($req->icon){
            $image = $req->icon;
            $filenameWithExt = $image->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
            $filename = preg_replace("/\s+/", '-', $filename);
            $extension = $image->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(200,150);  
            $save= $image_resize->save('images/'.$fileNameToStore);
            $imagePath = public_path('images/'.$req->oldimage);
            if(File::exists($imagePath)){
               unlink($imagePath);
            }
            $icon=$fileNameToStore;
        }else{
            $icon=$req->oldimage;
        }
        
        
         $data=array([
            'offername'=>$req->offername,
            'offer_api_url'=>$req->offer_api_url,
            'header'=>$req->header,
            'json_array'=>$req->json_array,
            'key_campid'=>$req->key_campid,
            'key_title'=>$req->key_title,
            'key_description'=>$req->key_description,
            'key_amount'=>$req->key_amount,
            'key_icon_url'=>$req->key_icon_url,
            'key_offer_link'=>$req->key_offer_link,
            'key_extra_suffix'=>$req->key_extra_suffix,
            'userid'=>$req->userid ]);
            
            $offer=MOfferwall::find($req->id);
            $offer->title=$req->title;
            $offer->offer_slug=str_replace(' ','_',strtolower($req->title));
            $offer->thumb=$icon;
            $offer->description=$req->description;
            $offer->data=json_encode($data);
            $offer->type='api';
            $offer->c_status=$req->tag;
            $offer->save();
            
            if($req->userid!=""){ $puser=''.$req->userid; }else{$puser='';}
            if($req->amount!=""){ $pamount='&'.$req->amount; }else{$pamount='';}
            if($req->p_offername!=""){ $p_offername='&'.$req->p_offername; }else{$p_offername='';}
            if($req->offerid!=""){ $pofferid='&'.$req->offerid; }else{$pofferid='';}
            if($req->ip!=""){ $pip='&'.$req->ip; }else{$pip='';}
            
          $domainURL = '&';

         $pb=DB::table('postback')->where('offerwall_id',$req->id)->update([
                'postback_url'=>$domainURL.$puser.$pamount.$pip.$pofferid.$p_offername,
                'offerwall_id'=>$req->id,
                'offerwall_name'=>$req->title,
                'response_code'=>$req->response_code,
                'p_userid'=>$req->userid,
                'p_payout'=>$req->amount,
                'p_campaing_id'=>$req->offerid,
                'p_ip'=>$req->ip,
                'p_offername'=>$req->p_offername
                ]);
            
        return redirect('/offerwall/api')->with('success','Update SuccessFully!');    
     }

    public function destroyOfferwall($id){
        MOfferwall::where('id',$id)->delete();
        DB::table('postback')->where('offerwall_id',$id)->delete();
        return 1;
    }

    public function action(Request $req){
         if($req->status=="enable"){
            $update =MOfferwall::whereIn('id',explode(",",$req->id))->update(['status'=>0]); 
            if($update){
                return 1;
            }else{
                return "not updated";
            }
        }
        else if($req->status=="disable"){
            $update =MOfferwall::whereIn('id',explode(",",$req->id))->update(['status'=>1]); 
            if($update){
                return 1;
            }else{
                return "not updated";
            }
        }
    }
        
}
