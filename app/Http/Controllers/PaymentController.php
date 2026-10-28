<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartContactInformation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Setting;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function index(CartService $cartService){
        
        $cart = Cart::where('user_id', Auth::id())->first();

        $selectedAddress = CartContactInformation::where('cart_id',$cart->id)->latest()->first();

        $priceCount = $cartService->getPriceCount()->getData(true);
        
        return view('customer.cart-payment', compact('selectedAddress','priceCount'));
    
    }

    public function store(Request $request) {
       
        $validate = $request->validate([
            'payment_method' => 'required',
            'total_price'=> 'required',
            'order_number'=> 'unique:orders,order_number,NULL,id'
        ]);

        $order = Order::create([
            'user_id'=> Auth::id(),
            'order_number'=> $validate['order_number'],
            'total_amount'=> $validate['total_price'],
            'order_status'=> 'processing'
        ]);

        $cart = Cart::where('user_id',Auth::id())->first();

        foreach($cart?->cartItems as $cartItem){
            OrderItem::create([
                'order_id'=> $order->id,
                'product_id'=> $cartItem->product_id,
                'quantity'=> $cartItem->quantity,
                'unit_price'=> $cartItem->price,
                'total_price'=> $cartItem->new_price,
                'options'=> $cartItem->options
            ]);
        }

        if($validate['payment_method'] == 'cod'){
            $payment = Payment::create([
                'order_id'=> $order->id,
                'amount'=> $validate['total_price'],
                'payment_status'=> 'succeeded',
                'payment_method'=> 'cod'
            ]);
        }
        else if($validate['payment_method'] == 'online'){
            
            Stripe::setApiKey(config('services.stripe.secret'));
            
            $customer = Customer::create([
                'name'=> Auth::user()->name,
                'email'=> Auth::user()->email
            ]);

            $session = Session::create([
                'customer'=> $customer->id,
                'line_items'=> [
                    [
                        'price_data'=> [
                            'currency'=> 'inr',
                            'unit_amount' => ($validate['total_price'] * 100),
                            'product_data'=> [
                                'name'=> "VastrKaya Order"
                            ]
                        ],
                        'quantity'=> 1
                    ]
                ],
                'mode'=> 'payment',
                'success_url'=> route('checkout.payment.success', [
                                    'order_id'=> $order->id,
                                    'total_price'=> $validate['total_price'],
                                ]) . '&session_id={CHECKOUT_SESSION_ID}',

                'cancel_url'=> route('checkout.payment')
            ]);

            return redirect($session->url);
        }

        return redirect()->route('checkout.order.details',['payment_id'=> $payment->id,'order_id'=> $order->id])->with('success', 'Order placed successfully!');
    }

    public function paymentSuccess(Request $request) {
        
        $payment = Payment::create([
            'order_id'=> $request->order_id,   
            'payment_intent_id'=> $request->session_id,
            'amount'=> $request->total_price,
            'payment_status'=> 'succeeded',
            'payment_method'=> 'online'
        ]);

        $order = Order::where('id',$request->order_id)->first();
        $order->update([
            'status'=> 'processing'
        ]);
        
        if ($payment) {
            return redirect()->route('checkout.order.details',[
                'payment_id'=> $payment->id,
                'order_id'=> $request->order_id 
            ])->with('success', 'Payment successful! Here are your order details.');
        }
    }

    public function orderDetail(Request $request)
    {
        if ($request->filled('payment_id')) {
            $payment = Payment::findOrFail($request->payment_id);
            $orderItem = OrderItem::where('order_id', $request->order_id)->get();
            $productIds = $orderItem->pluck('product_id')->toArray();
            $products = Product::with('orderItems')->whereIn('id', $productIds)->get();
            $order = Order::where('user_id', Auth::id())->latest()->first();
        }
        else {
            $order = Order::where('user_id', Auth::id())->latest()->first();
            $payment = Payment::where('order_id', $order->id)->first();
            $orderItem = OrderItem::where('order_id', $order->id)->get();
            $productIds = $orderItem->pluck('product_id')->toArray();
            $products = Product::with('orderItems')->whereIn('id', $productIds)->get();
        }
        
        if($order) {
            $optionid = OrderItem::where('order_id',$order->id)->get('options');
        }

        $cart = Cart::with('cartItems')->where('user_id', Auth::id()) ->latest()->first(); 
        
        if ($cart) { 
            // foreach($cart->cartItems() as $ci) {
            //     $product = Product::findOrFail($ci->product_id);
                
            //     $product->update([
            //         'stock' => $product->stock - $ci->quantity
            //     ]);

            //     $product->save();
            // }

            

            // $cart->cartItems()->delete(); 
        }

        $selectedAddress = CartContactInformation::where('cart_id', $cart->id)->latest()->first();

        $setting = Setting::first();

        return view('customer.order-details', compact('selectedAddress', 'payment', 'products', 'order', 'setting'));
    }

    public function orderCancel(int $id) {
        
        $order = Order::where('id',$id)->first();
        $order->update([
            'order_status'=> 'cancelled'
        ]);

        return redirect()->back()->with('success', 'Order cancelled successfully!');
    }

    public function myOrders(Request $request) {
        $orders = Order::with('orderItems.product','payment')->where('user_id',Auth::id())->latest()->get();
        return view('customer.orders', compact('orders'));
    }
}