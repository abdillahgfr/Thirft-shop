<?php

namespace App\Http\Controllers;

// use App\Category;

use App\Models\Province;
use App\Models\Regency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardSettingController extends Controller
{
     public function store()
    {
        $user = Auth::user();
        // $categories = Category::all();
        
        return view('pages.dashboard-settings', [
            'user' => $user
            // 'categories' => $categories
        ]);
    }

     public function account()
    {
     
        $user = Auth::user();
        // $Provinsi  = Province::findOrFail($user->provinces_id);
        $prov = Province::all();
        // $kota = Regency::findOrfail($user->regencies_id);
        // $regency = Regency::all();
        return view('pages.dashboard-account', [
            'user' => $user,
            // 'Provinsi' => $Provinsi,
            'prov' => $prov,
            // 'kota' => $kota,
            // 'regency' => $regency,
        ]);

    }

     public function profile()
    {
        $user = Auth::user();
        // $categories = Category::all();
        
        return view('pages.dashboard-profiles', [
            'user' => $user
        ]);

    }

    public function update(Request $request, $redirect)
    {
        
        $data = $request->all();
        // dd($data);
        $user = Auth::user();


        $user->update($data);
        
        return redirect()->route($redirect);

    }

    public function update_profile(Request $request, $redirect)
    {
        
        $data = $request->all();
        if($request->photos){ $data['photos'] = $request->file('photos')->store('assets/user', 'public'); }
        
        $user = Auth::user();
        
        $user->update($data);
        return redirect()->route($redirect);

    }

     public function update_store(Request $request, $redirect)
    {
        $data = $request->all();
        $item = Auth::user();

        $item->update($data);

        return redirect()->route($redirect);
    }
    
}
