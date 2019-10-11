<?php

namespace App\Http\Controllers\Backend;

use App\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index() {
        return view('backend.setting', Setting::getSettings());
    }

    public function store(Request $request) {
        Setting::where('key', '!=', NULL)->delete();
        foreach ($request->except('_token') as $key => $value) {
            $setting = new Setting;
            $setting->key = $key;
            $setting->value = $request->$key;
            $setting->save();
        }
        return redirect()->route('admin.setting.index');
    }
}
