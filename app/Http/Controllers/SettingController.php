<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Setting';
        $setting = Setting::first();
        return view('setting.index', compact('setting', 'title'));
    }

    public function about()
    {
        $setting = Setting::first();
        $title = "Tentang Sistem";
        return view('setting.about', compact('setting', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $setting = Setting::findOrFail($id);

    // Simpan nama file lama
    $logo     = $setting->logo_setting;
    $favicon  = $setting->favicon_setting;
    $background = $setting->background_setting;
    $bg       = $setting->bg_tentang_setting;

    // === Update logo ===
    if ($request->hasFile('logo_setting')) {
        if ($logo && file_exists(public_path('logo/' . $logo))) {
            unlink(public_path('logo/' . $logo));
        }
        $logoFile = $request->file('logo_setting');
        $logo = 'logo_' . time() . '.' . $logoFile->getClientOriginalExtension();
        $logoFile->move('logo/', $logo);
    }

    // === Update favicon ===
    if ($request->hasFile('favicon_setting')) {
        if ($favicon && file_exists(public_path('favicon/' . $favicon))) {
            unlink(public_path('favicon/' . $favicon));
        }
        $faviconFile = $request->file('favicon_setting');
        $favicon = 'favicon_' . time() . '.' . $faviconFile->getClientOriginalExtension();
        $faviconFile->move('favicon/', $favicon);
    }

    // === Update background umum ===
    if ($request->hasFile('background_setting')) {
        if ($background && file_exists(public_path('background/' . $background))) {
            unlink(public_path('background/' . $background));
        }
        $backgroundFile = $request->file('background_setting');
        $background = 'background_' . time() . '.' . $backgroundFile->getClientOriginalExtension();
        $backgroundFile->move('background/', $background);
    }

    // === Update background tentang ===
    if ($request->hasFile('bg_tentang_setting')) {
        if ($bg && file_exists(public_path('background_setting/' . $bg))) {
            unlink(public_path('background_setting/' . $bg));
        }
        $bgFile = $request->file('bg_tentang_setting');
        $bg = 'bg_tentang_' . time() . '.' . $bgFile->getClientOriginalExtension();
        $bgFile->move('background_setting/', $bg);
    }

    // === Update database ===
    $setting->update([
        'instansi_setting'       => $request->instansi_setting,
        'pimpinan_setting'       => $request->pimpinan_setting,
        'logo_setting'           => $logo,
        'favicon_setting'        => $favicon,
        'tentang_setting'        => $request->tentang_setting,
        'misi_setting'           => $request->misi_setting,
        'visi_setting'           => $request->visi_setting,
        'keyword_setting'        => $request->keyword_setting,
        'alamat_setting'         => $request->alamat_setting,
        'instagram_setting'      => $request->instagram_setting,
        'youtube_setting'        => $request->youtube_setting,
        'email_setting'          => $request->email_setting,
        'no_hp_setting'          => $request->no_hp_setting,
        'tiktok_setting'         => $request->tiktok_setting,
        'facebook_setting'       => $request->facebook_setting,
        'twitter_setting'        => $request->twitter_setting,
        'maps_setting'           => $request->maps_setting,
        'profile_title'          => $request->profile_title,
        'profile_content'        => $request->profile_content,
        'primary_button_title'   => $request->primary_button_title,
        'primary_button_link'    => $request->primary_button_link,
        'secondary_button_title' => $request->secondary_button_title,
        'secondary_button_link'  => $request->secondary_button_link,
        'years_experience'       => $request->years_experience,
        'followers_count'        => $request->followers_count,
        'project_delivered'      => $request->project_delivered,
        'cost_savings'           => $request->cost_savings,
        'success_rate'           => $request->success_rate,
        'background_setting'     => $background,
        'bg_tentang_setting'     => $bg,
    ]);

    // Clear cache untuk memastikan perubahan langsung terlihat
    Cache::forget('site_config');
    Cache::forget('homepage_data');
    
    return redirect()->back()->with('Sukses', 'Berhasil Edit Konfigurasi Website');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }

    public function storeImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->move(public_path('images'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/' . $fileName);
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }
}
