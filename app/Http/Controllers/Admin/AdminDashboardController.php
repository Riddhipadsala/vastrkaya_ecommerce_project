<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;

class AdminDashboardController extends Controller
{
    public function index() {
        
        if(request()->ajax()) {
        
           $dashboardData = Cache::tags(['product','category','option'])->remember('admin_dashboard_data', now()->addMinutes(10), function () {
            return [
                'products' => Product::with('category')->get(),
                'productCount' => Product::count(),
                'categories' => Category::all(),
                'categoryCount' => Category::count(),
                'options' => Option::all(),
                'optionCount' => Option::count(),
                'stock' => Product::sum('stock'),
                'urgentStock' => Product::where('stock','<=',10)->get(),
            ];
        });
        
            return response()->json([
                'dashboardData' => $dashboardData,
            ]);
        }
            
        return view('admin.dashboard');

     }

    public function notification() {

        $notifications = auth()->user()
            ->notifications()
            ->get();
        $unreadCount = auth()->user()->unreadNotifications()->count();

        return response()->json([
            'success' => true,
            'notifications' => $notifications,
            'unreadCount' => $unreadCount
        ]);
    }

    public function destroy($id)
    {
        $notification = auth()->user()
            ->notifications()
            ->findOrFail($id);

        $deleted = $notification->delete();

        if($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Notification deleted successfully.'
            ]);
        }
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()
            ->notifications()
            ->findOrFail($id);

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read.'
        ]);
    }

    public function markAllAsRead()
    {
        auth()->user()
            ->unreadNotifications()
            ->update([
                'read_at' => now()
            ]);

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read.'
        ]);
    }
}
