<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function store(Request $request)
    {
        
        $authUser = auth()->user();
        $setting = Setting::create([
            'VAT_included' => $request->VAT_included,
            'VAT' => $request->VAT,
            'shipping_cost' => $request->shipping_cost,
            'store_id' => $authUser->store_id
        ]);
    
        return response()->json(['created' => 'created'], 200);
    }
}
