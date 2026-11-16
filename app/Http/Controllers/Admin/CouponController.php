<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

        if ($request->filled('name')) {
        $query->where('coupon_name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->filled('code')) {
        $query->where('code', 'LIKE', '%' . $request->code . '%');
        }

        if ($request->filled('type')) {
        $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
        $query->where('status', $request->status);
        }

        $coupons = $query->orderBy('id', 'desc')->paginate(10);

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

    public function getCoupon(Request $request) {

        $couponCode = trim($request->coupon);
        $coupon = Coupon::where('code', $couponCode)->first();

        $today = now()->toDateString();

        if($coupon && $coupon->status == 1 && $coupon->end_date >= $today && $coupon->start_date <= $today && $coupon->used_total < $coupon->uses_total) {

            $coupon->used_total += 1;
            $coupon->save();

            session()->put('applied_coupon', [
                'id'=> $coupon->id,
                'type'=> $coupon->type,
                'discount'=> $coupon->discount,
                'code'=> $coupon->code
            ]);

            return response()->json([
                'success'=> true,
                'coupon'=> $coupon,
                'message' => 'Coupon applied successfully'
            ]);
        }
        else {
            return response()->json([
                'success'=> false,
                'message' => 'Invalid or expired coupon'
            ]);
        }
    }

    public function removeCoupon() {
        if (session()->has('applied_coupon')) {
            $sessionCoupon = session()->get('applied_coupon');
            $coupon = Coupon::where('code', $sessionCoupon['code'])->first();

            $coupon->used_total > 0 ? $coupon->used_total -= 1 : $coupon->used_total = 0;
            $coupon->save();
        }

        session()->forget('applied_coupon');

        return response()->json([
            'success' => true,
            'message' => 'Coupon removed successfully'
        ]);
    }
}
