<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartContactInformation;
use App\Models\Setting;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartContactInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,CartService $cartService)
    {
        $user = Auth::id();

        $cart = Cart::with('cartItems.product')->where('user_id', $user)->first();

        $cartId = $cart ? $cart->id : null;

        $cartContactInformation = $cart 
            ? CartContactInformation::where('cart_id', $cart->id)->latest()->get() 
            : collect();

        $editAddress = null;

        if ($request->filled('edit')) {
            $editAddress = CartContactInformation::find($request->get('edit'));
        }

        $showForm = $request->has('add') || $editAddress !== null;

        $priceCount = $cartService->getPriceCount()->getData(true);

        return view('customer.cart-contact-information', compact(
            'cartContactInformation',
            'cartId',
            'editAddress',
            'showForm',
            'priceCount'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cart_id'             => 'required|exists:carts,id',
            'name'                => 'required|string|max:255',
            'contact_number'      => 'required|string|regex:/^[0-9]{10}$/',
            'address_type_line_1' => 'required|string|max:255',
            'address_type_line_2' => 'required|string',
            'city'                => 'required|string|max:100',
            'state'               => 'required|string|max:100',
            'pincode'             => 'required|string|regex:/^[0-9]{6}$/',
        ], [
            'name.required' => 'Please enter your full name',
            'contact_number.required' => 'Please enter your mobile number',
            'contact_number.regex' => 'Please enter a valid 10-digit mobile number',
            'address_type_line_1.required' => 'Please enter House No./Flat/Building',
            'address_type_line_2.required' => 'Please enter Area/Colony/Street',
            'city.required' => 'Please enter City',
            'state.required' => 'Please enter State',
            'pincode.required' => 'Please enter 6-digit Pincode',
            'pincode.regex' => 'Pincode must be 6 digits',
        ]);

        $contactInfo = CartContactInformation::create($validated);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Delivery address saved successfully!',
                'data'    => $contactInfo
            ]);
        }

        return redirect()->route('contact.index')->with('success', 'Delivery address saved successfully!');
    }

    /**
     * Update the specified address in storage.
     */
    public function update(Request $request,int $id)
    {
        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'contact_number'      => 'required|string|regex:/^[0-9]{10}$/',
            'address_type_line_1' => 'required|string|max:255',
            'address_type_line_2' => 'required|string',
            'city'                => 'required|string|max:100',
            'state'               => 'required|string|max:100',
            'pincode'             => 'required|string|regex:/^[0-9]{6}$/',
        ], [
            'name.required' => 'Please enter your full name',
            'contact_number.required' => 'Please enter your mobile number',
            'contact_number.regex' => 'Please enter a valid 10-digit mobile number',
            'address_type_line_1.required' => 'Please enter House No./Flat/Building',
            'address_type_line_2.required' => 'Please enter Area/Colony/Street',
            'city.required' => 'Please enter City',
            'state.required' => 'Please enter State',
            'pincode.required' => 'Please enter 6-digit Pincode',
            'pincode.regex' => 'Pincode must be 6 digits',
        ]);

        $contactInfo = CartContactInformation::findOrFail($id);
        $contactInfo->update($validated);

        return redirect()->route('contact.index')->with('success', 'Address updated successfully!');
    }

    /**
     * Remove the specified address from storage.
     */
    public function destroy(int $id)
    {
        $contactInfo = CartContactInformation::findOrFail($id);

        $contactInfo->delete();

        return redirect()->route('contact.index')->with('success', 'Address removed successfully!');
    }
}
