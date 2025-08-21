<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alias;
use Illuminate\Support\Facades\DB;
use Exception;

class Alias_ extends Controller
{
    public function index()
    {
        $data=Alias::fastPaginate();
        return view('admin-setting/alias/alias-management', compact('data'));
    }

    public function createNew()
    {
        return view('admin-setting/alias/add-alias');
    }

    public function createEdit($id)
    {
        $data = Alias::find($id);
        return view('admin-setting/alias/edit-alias', compact('data'));
    }

    public function store(Request $request)
    {
        $attributes = request()->validate([
            'tag' => ['required'],
            'description' => ['required'],
        ]); 
        Alias::create(['tag' => $attributes['tag'], 'description'=> $attributes['description'], 'created_at' => now()]);
       
        return redirect('/alias-management')->with('success','Alias successfully added.');
    }

    public function edit(Request $request)
    {
         $attributes = request()->validate([
            'id' => ['required'],
            'description' => ['required'],
        ]);         
        Alias::where('id',$attributes['id'])->update(['description'=> $attributes['description']]);
        return redirect('/alias-management')->with('success','Alias successfully edited.');
    }

    public function getAlias($type){
        return Alias::where('tag',$type)->get();
    }

    public function destroy($id)
    {
        try{
            Alias::where('id', $id)->delete();
            return redirect('/alias-management')
                ->with('success','Alias deleted successfully');
                }catch(Exception $e){
                    return redirect()->back()->withErrors(['msgError' => 'Alias that are used cannot be deleted.']);
                }
    }
}
