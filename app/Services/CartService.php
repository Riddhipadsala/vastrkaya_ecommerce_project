<?php
namespace App\Services;

use App\Models\Cart;
use App\Models\Coupon;
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

        $total_price = $cart ? $cart->cartItems->sum('new_price') : 0;

        $total_quantity = $cart ? $cart->cartItems->sum('quantity') : 0;

        if($total_price >= ($setting[0]->minimum_order_amount ?? 0)){
            $delivery_charges = 0;
        }
        else {
            $delivery_charges = $cart->cartItem == null ? 0 : $setting[0]->delivery_charge ?? 0;
        }
        
        $couponDiscountPrice = 0;
        $couponDiscount = 0;
        $couponType = null;
        $couponCode = null;

        if (session()->has('applied_coupon')) {
            $sessionCoupon = session()->get('applied_coupon');
            $couponCode = $sessionCoupon['code'] ?? null;
            $coupon = Coupon::where('code', $couponCode)->first();

            if ($coupon) {
                $couponType = $coupon->type;
                $couponDiscount = $coupon->discount;
                $couponCode = $coupon->code;

                if($couponType == 'fix') {
                    $couponDiscountPrice = $couponDiscount;
                }
                else {
                    $couponDiscountPrice = ($total_price * $couponDiscount) / 100;    
                }
            } else {
                $couponCode = null;
            }
        }
        
        return response()->json([
            'success' => true,
            'total_price' => Round($total_price),
            'total_count' => $total_quantity,
            // 'total_discount' => $total_discount,
            'delivery_charges'=> $delivery_charges,
            'payable_price'=> Round(max(0, $total_price + $delivery_charges - $couponDiscountPrice)),
            'coupon_code'=> $couponCode,
            'coupon_discount'=> $couponDiscount,
            'couponType'=> $couponType,
            'coupon_discount_price'=> Round($couponDiscountPrice)
        ]);
        
    }
}
?>
