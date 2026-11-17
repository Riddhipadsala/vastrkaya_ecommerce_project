<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Mail\GetOrderMail;
use App\Mail\SendOrderMail;
use App\Models\Cart;
use App\Models\CartContactInformation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\User;
use App\Services\CartService;
use App\Services\SendEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function index(CartService $cartService){
        
        $cart = Cart::where('user_id', Auth::id())->first();

        $selectedAddress = CartContactInformation::where('cart_id',$cart->id)->where('is_selected',1)->latest()->first();

        $priceCount = $cartService->getPriceCount()->getData(true);

        return view('customer.cart-payment', compact('selectedAddress','priceCount'));
    
    }

    public function store(Request $request, SendEmail $sendEmail) {
       
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
                'pro_opt_val'=> $cartItem->pro_opt_val
            ]);
        }

        if($validate['payment_method'] == 'cod'){
            $payment = Payment::create([
                'order_id'=> $order->id,
                'amount'=> $validate['total_price'],
                'payment_status'=> 'succeeded',
                'payment_method'=> 'cod'
            ]);

            $sendEmail->sendOrderEmail($order->id);
            $sendEmail->sendNotification($order->id);

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

        return redirect()->route('order.details',['payment_id'=> $payment->id,'order_id'=> $order->id])->with('success', 'Order placed successfully!');
    }

    public function paymentSuccess(Request $request,SendEmail $sendEmail) {
        
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::retrieve($request->session_id);

        $payment = Payment::create([
            'order_id'=> $request->order_id,   
            'payment_intent_id'=> $session->payment_intent,
            'amount'=> $request->total_price,
            'payment_status'=> 'succeeded',
            'payment_method'=> 'online'
        ]);

        if ($payment) {

            $sendEmail->sendOrderEmail($request->order_id);
            $sendEmail->sendNotification($request->order_id);

            return redirect()->route('order.details',[
                'payment_id'=> $payment->id,
                'order_id'=> $request->order_id 
            ])->with('success', 'Payment successful! Here are your order details.');
        }
    }
}