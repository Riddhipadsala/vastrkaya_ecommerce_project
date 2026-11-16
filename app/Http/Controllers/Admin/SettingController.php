<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SettingController extends Controller
{
    /**
     * Display store settings configuration.
     */
    public function index()
    {
        $setting = Setting::first();

        return view('admin.pages.settings', compact('setting'));
    }

    /**
     * Save or update store settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'minimum_order_amount' => 'required|numeric|min:0',
            'delivery_charge'      => 'required|numeric|min:0',
        ]);

        Setting::updateOrCreate(
            $validated
        );

        return redirect()->route('admin.settings.index')->with('success', 'Store settings updated successfully!');
    }
}
