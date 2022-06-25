<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\User;

class StoreController extends Controller
{
    public function store(Request $request)
    {
        
        $this->validate($request, [
            'name' => 'required|min:4'
        ]);
  
        $store = Store::create([
            'name' => $request->name
        ]);

        $authUser = auth()->user();
        $user = User::find($authUser->id);
        $user->store_id = $store->id;
        $user->save();

    
        return response()->json(['created' => 'created'], 200);
    }
}
