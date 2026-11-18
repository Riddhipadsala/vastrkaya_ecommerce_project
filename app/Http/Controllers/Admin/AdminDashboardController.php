<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class AdminDashboardController extends Controller
{
    public function index() {
        
        $products = Product::with('category')->get();
        $productCount = Product::count();
        $categories = Category::all();
        $categoryCount = Category::count();
        $options = Option::all();
        $optionCount = Option::count();
        $stock = Product::sum('stock');
        $UrgentStock = Product::where('stock','<=',10)->get();
        
        if(request()->ajax()) {
            return response()->json([
                'products' => $products,
                'productCount' => $productCount,
                'categories' => $categories,
                'categoryCount' => $categoryCount,
                'options' => $options,
                'optionCount' => $optionCount,
                'stock' => $stock,
                'UrgentStock'=> $UrgentStock,
            ]);
        }
        return view('admin.dashboard', compact('products', 'categories', 'options', 'stock'));
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
