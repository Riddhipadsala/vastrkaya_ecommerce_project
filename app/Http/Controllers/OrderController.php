<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartContactInformation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductOptionValue;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session;
use Stripe\Refund;
use Stripe\Stripe;

class OrderController extends Controller
{
    
    public function orderDetail(Request $request)
    {
        $order = Order::where('user_id', Auth::id())->latest()->first();

        if ($request->filled('payment_id')) {
            
            $payment = Payment::findOrFail($request->payment_id);
            
            $orderItems = OrderItem::with('product')->where('order_id', $request->order_id)->get();

            foreach ($orderItems as $oi) {
                $oi->resolvedOptions = ProductOptionValue::with('optionValue','option')->where('product_id', $oi->product_id)->whereIn('option_value_id', $oi->options)->get();
            }
            $productIds = $orderItems->pluck('product_id')->toArray();

            $products = Product::with('orderItems')->whereIn('id', $productIds)->get();

        }
        else {
            $payment = Payment::where('order_id', $order->id)->first();

            $orderItems = OrderItem::with('product')->where('order_id', $order->id)->get();
            
            foreach ($orderItems as $oi) {
                $oi->resolvedOptions = ProductOptionValue::with('optionValue','option')->where('product_id', $oi->product_id)->whereIn('option_value_id', $oi->options)->get();
            }

            $productIds = $orderItems->pluck('product_id')->toArray();

            $products = Product::with('orderItems')->whereIn('id', $productIds)->get();
        }

        $cart = Cart::with('cartItems')->where('user_id', Auth::id()) ->latest()->first(); 
        
        if ($cart) { 
            foreach($cart->cartItems as $ci) {
                $product = Product::findOrFail($ci->product_id);
                $product->update([
                    'stock' => $product->stock - $ci->quantity
                ]);

                $product->save();
            }

            $cart->cartItems()->delete(); 
        }

        $selectedAddress = CartContactInformation::where('cart_id', $cart->id)->latest()->first();

        $setting = Setting::first();

        return view('customer.order-details', compact('selectedAddress', 'payment', 'products', 'order', 'setting','orderItems'));
    }


    public function orderCancel(int $id) {
        
        $order = Order::with('orderItems.product')->where('id',$id)->first();
      
        if ($order->order_status === 'cancelled') {
            return redirect()->back()->with('error', 'Order is already cancelled!');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        foreach($order->orderItems as $oi) {
            $product = Product::findOrFail($oi->product_id);
            $product->update([
                'stock' => $product->stock + $oi->quantity
            ]);
            $product->save();
        }

        $order = Order::with('payment')->findOrFail($order->id);
        $order->update([
            'order_status'=> 'cancelled'
        ]);

        if($order->payment->payment_method == 'online') {

            $refund = Refund::create([
                'payment_intent'=> $order->payment->payment_intent_id,
            ]);

            $order->payment->update([
                'payment_status' => 'refund',
                'payment_intent_id'=> $refund->id
            ]);
        
        }
        else {
            $order->payment->update([
                'payment_status'=> 'cancelled'
            ]);
        }

        return redirect()->back()->with('success', 'Order cancelled successfully!');
    }


    public function myOrders(Request $request) {

        $orders = Order::with('orderItems.product','payment')->where('user_id',Auth::id())->latest()->get();
        
        return view('customer.orders', compact('orders'));

    }

}
