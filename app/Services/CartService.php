<?php
namespace App\Services;

use App\Models\Cart;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class CartService {

    public function getPriceCount() {
    
        if(Auth::check()){
            $cart = Cart::with('cartItems.product')->where('user_id', Auth::id())->first();
        }else{
            $cart = Cart::with('cartItems.product')->where('session', session()->getId())->first();
        }

        $setting = Setting::all();

        $total_price = $cart->cartItems->sum('new_price');

        //wrong discount_price calculation
        $total_discount = $cart?->cartItems?->sum(function ($item){
           
            $original_price = $item->product->price * $item->quantity ?? 0;
           
            $discount_price = $item->product->discount_price * $item->quantity ?? 0;
           
            $discount_per_product = $original_price - $discount_price;
           
            return $discount_per_product ;
        });

        $total_quantity = $cart->cartItems->sum('quantity');

        if($total_price >= $setting[0]->minimum_order_amount){
            $delivery_charges = 0;
        }
        else {
            $delivery_charges = $setting[0]->delivery_charge;
        }
        
        return response()->json([
            'success' => true,
            'total_price' => $total_price,
            'total_count' => $total_quantity,
            // 'total_discount' => $total_discount,
            'total_quantity'=> $total_quantity,
            'delivery_charges'=> $delivery_charges,
            'payable_price'=> $total_price + $delivery_charges
        ]);
        
    }
}
?>