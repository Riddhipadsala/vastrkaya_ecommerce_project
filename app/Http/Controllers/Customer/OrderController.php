<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartContactInformation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductOptionValue;
use App\Models\Setting;
use App\Services\SendEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Stripe\Refund;
use Stripe\Stripe;

class OrderController extends Controller
{
    public function orderDetail(Request $request)
    {
        $order = Order::with('payment')->findOrFail($request->order_id);
        
        $orderItems = OrderItem::with('product')->where('order_id', $request->order_id)->get();
        
        foreach ($orderItems as $oi) {
            $oi->resolvedOptions = ProductOptionValue::with('optionValue','option')->where('product_id', $oi->product_id)->whereIn('id', $oi->pro_opt_val)->get();
        }

        $productIds = $orderItems->pluck('product_id')->toArray();

        $products = Product::with('orderItems')->whereIn('id', $productIds)->get();

        $cart = Cart::with('cartItems')->where('user_id', Auth::id()) ->latest()->first(); 
        
        DB::transaction(function() use($cart) {
            if ($cart) { 
                $cart->cartItems()->delete(); 
            }

            session()->forget('applied_coupon');
            Cache::tags(['product'])->flush();
        },5);

        $selectedAddress = CartContactInformation::where('cart_id', $cart->id)->where('is_selected', 1)->latest()->first();

        $setting = Setting::first();

        return view('customer.order-details', compact('selectedAddress', 'products', 'order', 'setting','orderItems'));
    }

    public function orderCancel(int $id, SendEmail $sendEmail) {
        
        $order = Order::with('orderItems.product','payment')->where('id',$id)->first();
      
        if ($order->order_status === 'cancelled') {
            return redirect()->back()->with('error', 'Order is already cancelled!');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

         if($order->payment->payment_method == 'online') {
            $refund = Refund::create([
                'payment_intent'=> $order->payment->payment_intent_id,
            ]);
        }

        DB::transaction(function() use($order, $refund) {
            
            foreach($order->orderItems as $oi) {
                $product = Product::findOrFail($oi->product_id);
                $product->update([
                    'stock' => $product->stock + $oi->quantity
                ]);
            }

            $order->update([
                'order_status'=> 'cancelled'
            ]);
    
            if($order->payment->payment_method == 'online') {
                $order->payment->update([
                    'payment_status' => 'refund',
                    'payment_intent_id'=> $refund->id
                ]);
            }else {
                $order->payment->update([
                    'payment_status'=> 'cancelled'
                ]);
            }

        },5);

        $sendEmail->sendOrderEmail($order->id);
        $sendEmail->sendNotification($order->id);

        return redirect()->back()->with('success', 'Order cancelled successfully.');
    }


    public function myOrders(Request $request) {

        $orders = Order::with('orderItems.product','payment')->where('user_id',Auth::id())->latest()->get();
        return view('customer.orders', compact('orders'));

    }

}
