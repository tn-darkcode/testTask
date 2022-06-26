<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Setting;

class CartController extends Controller
{
    public function store(Request $request)
    {
        
        $authUser = auth()->user();
        $setting = Setting::where('store_id', $authUser->store_id)->first();

        $userOpenCart = Cart::where([
            ['user_id', '=', $authUser->id],
            ['is_placed', '=', '0'],
            ['store_id', '=', $authUser->store_id]
        ])->first();

        $cartItem = new CartItem([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);

       
        if($userOpenCart){
            $cartItem->cart_id = $userOpenCart->id;
            $cartItem->save();
            $cartItemTotal = $cartItem->price * $cartItem->quantity;
            $userOpenCartTotal = $userOpenCart->total + $cartItemTotal;
            $userOpenCart->total = $userOpenCartTotal;
            $userOpenCart->save();

            if($setting->VAT_included == 1){
                $store_VAT = $setting->VAT / 100 ;
                $store_shipping_cost = $setting->shipping_cost;
                $VAT = $userOpenCart->total * $store_VAT;
                $receipt = $userOpenCart->total + $VAT + $store_shipping_cost;
                return response()->json(['shipping cost' => $store_shipping_cost ,'VAT' => $VAT , 'your order' => $userOpenCart->total, 'Your Total Is' => $receipt], 200);
            }else{
                return response()->json(['Your Total Is' => $userOpenCart->total], 200);
            }

        }else{
            $cart = Cart::create([
                'user_id' => $authUser->id,
                'store_id' => $authUser->store_id
            ]);

            $cartItem->cart_id = $cart->id;
            $cartItem->save();
            
            $cart->total = $cartItem->price * $cartItem->quantity;
            $cart->save();

            if($setting->VAT_included == 1){
                $store_VAT = $setting->VAT / 100 ;
                $store_shipping_cost = $setting->shipping_cost;
                $VAT = $cart->total * $store_VAT;
                $receipt = $cart->total + $VAT + $store_shipping_cost;
                return response()->json(['shipping cost' => $store_shipping_cost ,'VAT' => $VAT , 'your order' => $cart->total, 'Your Total Is' => $receipt], 200);
            }else{
                return response()->json(['Your Total Is' => $cart->total], 200);
            }

        }
       

    }
}
