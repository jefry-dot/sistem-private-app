<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $data = $request->except(['_token', 'site_logo', 'site_favicon']);
        
        // Handle branding files
        if ($request->hasFile('site_logo')) {
            $logo = $request->file('site_logo');
            $logoName = 'logo.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('assets/branding'), $logoName);
            $data['site_logo'] = '/assets/branding/' . $logoName;
        }

        if ($request->hasFile('site_favicon')) {
            $favicon = $request->file('site_favicon');
            $faviconName = 'favicon.' . $favicon->getClientOriginalExtension();
            $favicon->move(public_path('assets/branding'), $faviconName);
            $data['site_favicon'] = '/assets/branding/' . $faviconName;
        }

        // Handle checkboxes
        $checkboxes = ['enable_registration', 'enable_client_upload'];
        foreach ($checkboxes as $checkbox) {
            $data[$checkbox] = $request->has($checkbox) ? '1' : '0';
        }

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => (string) $value]);
            Cache::forget("setting.$key");
        }

        ActivityLogger::log('update_settings', 'Updated system branding and settings');

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui!');
    }
}
