<?php

namespace App\Http\Controllers;

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

        if (!$setting) {
            $setting = new Setting([
                'minimum_order_amount' => 1000,
                'free_delivery_amount' => 0,
                'delivery_charge'      => 0,
            ]);
        }

        return view('admin.pages.settings', compact('setting'));
    }

    /**
     * Save or update store settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'minimum_order_amount' => 'required|numeric|min:0',
            'free_delivery_amount' => 'required|numeric|min:0',
            'delivery_charge'      => 'required|numeric|min:0',
        ]);

        Setting::updateOrCreate(
            ['id' => 1],
            $validated
        );

        return redirect()->route('admin.settings.index')->with('success', 'Store settings updated successfully!');
    }
}
