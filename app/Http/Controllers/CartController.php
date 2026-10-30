<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Setting;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(){
       
        $cart = null;

        if(auth()->check()) {
            $cart = Cart::with('cartItems.product.category','cartItems.product.productOptions.option.optionValues')->where('user_id', auth()->id())->first();
        }
        else {
            $cart = Cart::with('cartItems.product.category','cartItems.product.productOptions.option.optionValues')->where('user_id', null)->where('session', session()->getId())->first();
        }

        $cartItem = $cart ? $cart->cartItems : collect();
       
        $total_quantity = $cart ? $cart->cartItems->sum('quantity') : 0;

        if(request()->wantsJson()) {
            return response()->json([
                'success'=> true,
                'cartItem'=> $cartItem,
                'total_quantity' => $total_quantity
            ]);
        }

        return view('customer.cart', compact('cartItem'));
    }

    public function add(Request $request){
      
       $product_id = $request->product['id'];
       $quantity = (int) $request->quantity ?? 1;
       $price = (float) $request->price ?? 0;
       $options = $request->options ?? [];

       $cart = null;
       if(auth()->check()){
           $cart = Cart::firstOrCreate([
                'user_id' => Auth::id()
           ]);
       }
       else {
            $cart = Cart::firstOrCreate([
                'session' => session()->getId()
            ]);
       }

       //for quantity count
       $cartItem = CartItem::where('cart_id', $cart->id)
       ->where('product_id', $product_id)
       ->get()
       ->first(function ($item) use ($options) {
           
           $existing = $item->options ?? [];
           if (is_array($existing)) {
               ksort($existing);
            }
          
                $selectedOptions = $options;
                if (is_array($selectedOptions)) {
                    ksort($selectedOptions);
                }
                return $existing == $selectedOptions;
            });

        if ($cartItem) {
            
            $cartItem->increment('quantity', $quantity);
            $cartItem->new_price = $cartItem->price * $cartItem->quantity;
            $cartItem->save();

        } else {
            $cartItem = CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $product_id,
                'quantity'   => $quantity,
                'price'      => $price,
                'new_price'  => $price,
                'options'    => $options
            ]);   
        }
        
        $total_count = CartItem::where('cart_id', $cart->id)->sum('quantity');
        
        return response()->json([
            'success' => true, 
            'total_count' => $total_count,
            'cart'=> $cart,
            'cart_item'=> $cartItem
        ]);
    }

    public function delete(int $id) {
        
        $cartItem = CartItem::find($id);
        $cart = $cartItem->delete();
        
        if($cart) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function deleteAll() {
     
        $cartItem = CartItem::truncate();

        if($cartItem) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function update(Request $request,int $id) {
        $cartItem = CartItem::find($id);
        
        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        $newQuantity = (int) $request->quantity;
      
        if ($newQuantity < 1) {
            $newQuantity = 1;
        }

        $stock = (int) ($cartItem->product->stock ?? 0);
        $remainingStock = $stock - $newQuantity;

        if ($remainingStock < 0) {
            return response()->json([
                'success' => false,
                'cartItem' => $cartItem->id,
                'stock' => $stock,
                'quantity' => $cartItem->quantity,
                'message' => 'Product is out of stock'
            ]);
        }

        $cartItem->quantity = $newQuantity;
        $cartItem->new_price = $cartItem->price * $newQuantity;
        $cartItem->save();

        return response()->json([
            'success' => true,
            'unit_price' => $cartItem->price,
            'new_price' => $cartItem->new_price,
            'quantity' => $newQuantity,
            'stock' => $stock,
            'remaining_stock' => $remainingStock,
            'is_out_of_stock' => ($remainingStock <= 0 || $stock <= 0)
        ]);
    }

    public function getPriceCount(CartService $cartService) {
        
        $priceCount = $cartService->getPriceCount()->getData(true);

        return response()->json([
            'success' => true,
            'data'=> $priceCount,
        ]);
    }

    public function checkoutStock(Request $request) {
        $cartItem = CartItem::find($request->id);
        
        $product = Product::find($cartItem->product_id);
        
        $productStock = $product->stock - $cartItem->quantity;
        
        if($productStock < 0) {
            return response()->json([
                'success' => false,
                'message' => 'Product is out of stock'
            ]);
        }
        
        return response()->json([
            'success' => true,
            'productStock' => $productStock
        ]);
    }
}
