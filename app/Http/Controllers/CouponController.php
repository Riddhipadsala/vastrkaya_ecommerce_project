<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponRequest;
use App\Http\Requests\CouponUpdateRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Coupon::query();

        $query = Coupon::query();

        if ($request->filled('filter_name')) {
        $query->where('coupon_name', 'LIKE', '%' . $request->filter_name . '%');
        }

        if ($request->filled('filter_code')) {
        $query->where('code', 'LIKE', '%' . $request->filter_code . '%');
        }

        if ($request->filled('filter_type')) {
        $query->where('type', $request->filter_type);
        }

        if ($request->filled('filter_status')) {
        $query->where('status', $request->filter_status);
        }

        $coupons = $query->orderBy('id', 'desc')->get();

        if($request->ajax()) {
            return response()->json([
                'success' => true,
                'coupons' => $coupons
            ]);
        }

        return view('admin.pages.coupons.index');
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
    public function store(CouponRequest $request)
    {
        $coupon = Coupon::create($request->validated());
        
        if($coupon && $request->ajax()) {
            return response()->json([
                'success'=> true,
                'message' => 'Coupon added successfully'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        if($coupon) {
            return response()->json([
                'success'=> true,
                'coupon'=> $coupon
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CouponUpdateRequest $request, Coupon $coupon)
    {
        $couponUpdate = $coupon->update($request->validated());
        if($couponUpdate && $request->ajax()) {
            return response()->json([
                'success'=> true,
                'message' => 'Coupon updated successfully'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $couponDelete = $coupon->delete();

        if($couponDelete) {
            return response()->json([
                'success'=> true,
                'message' => 'Coupon deleted successfully'
            ]);
        }
    }
}
