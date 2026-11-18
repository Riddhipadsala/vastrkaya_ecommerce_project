<?php

namespace App\Services;

use App\Mail\GetOrderMail;
use App\Mail\SendOrderMail;
use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderInfoNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmail
{
    public function sendOrderEmail(int $orderId){
        
        $order = Order::with('user','orderItems','payment')->findOrFail($orderId);
        Log::info($order->payment->payment_status);
        $admin = User::role('admin')->first();

        if($order) {

            Mail::to($order->user->email)->queue(new SendOrderMail($order));
            Mail::to($admin->email)->queue(new GetOrderMail($order));

        }
    }

    public function sendNotification(int $orderId){

        $order = Order::with('user')->findOrFail($orderId);
        $admin = User::role('admin')->first();

        $admin->notify(new OrderInfoNotification($order));
    }
    
}

