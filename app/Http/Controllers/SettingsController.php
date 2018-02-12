<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(Setting $setting)
    {
        $title = 'Settings';
        $collection = collect($setting->all());
        $keyed = $collection->mapWithKeys(function ($item){
            return [$item['key'] = $item['value']];
        });
        $keyed->all();
        return view('settings', compact('title'));
    }

    public function store(Request $request, Setting $setting)
    {
        $data = $request->except('_token');
        foreach ($data as $key => $val) {
            $record = $setting->where('key', $key);
            if ($record->exists()) {
                $record->update(['value' => $val]);
            } else {
                $record->create([
                    'key'   => $key,
                    'value' => $val
                ]);
            }
        }
        return redirect()->back()->with('success', 'Setting Saved Successfully');
    }
}
