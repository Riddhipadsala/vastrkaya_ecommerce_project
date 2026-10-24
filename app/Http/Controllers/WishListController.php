<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\WishList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = WishList::with('product.category');

        if(Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session', session()->getId());
        }

        $wishlistItems = $query->get();

        return view('customer.wishlist', compact('wishlistItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(WishList $wishList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WishList $wishList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WishList $wishList)
    {
        $validate = $request->validate([
            'product_id' => 'required|exists:products,id',
            '_method' => 'required',
            '_token' => 'required'
        ]);

        $data = [
            'product_id'=> $validate['product_id'],
            'user_id'=> Auth::id() ?? null,
            'session'=> session()->getId() ?? null
        ];

        $query = WishList::where('product_id', $data['product_id']);
        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session', session()->getId());
        }
        $wishedProduct = $query->first();

        
        if($wishedProduct) {
            
            $wishedProduct->delete();
            
            return response()->json([
                'success'=> true,
                'message'=> 'remove the record from he wishlist'
            ]);
        }
   
        $wishList = WishList::create($data);
        
        if($wishList){
                return response()->json([
                    'success'=> true,
                    'message' => 'Product added in wishlist'
                ]);
        }
    }

    public function destroy(WishList $wishlist) {

    }
}
