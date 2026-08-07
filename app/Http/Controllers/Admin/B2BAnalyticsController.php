<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kyc;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class B2BAnalyticsController extends Controller
{
    public function index()
    {
        $totalB2BRevenue = PurchaseOrder::whereNotIn('status', ['cancelled', 'rejected'])->sum('total_amount');
        $totalB2BOrders = PurchaseOrder::count();

        $statusCounts = [
            'pending' => PurchaseOrder::where('status', 'pending')->count(),
            'approved' => PurchaseOrder::whereIn('status', ['approved', 'processing'])->count(),
            'completed' => PurchaseOrder::where('status', 'completed')->count(),
            'cancelled' => PurchaseOrder::where('status', 'cancelled')->count(),
        ];

        $merchantStats = [
            'total' => Kyc::count(),
            'approved' => Kyc::where('status', 'approved')->count(),
            'pending' => Kyc::where('status', 'pending')->count(),
            'rejected' => Kyc::where('status', 'rejected')->count(),
        ];

        $totalB2BProducts = Product::where('is_b2b', 1)->count();

        $topMerchants = Kyc::with('user')
            ->where('status', 'approved')
            ->latest()
            ->take(5)
            ->get();

        $recentOrders = PurchaseOrder::with(['user', 'user.kyc'])
            ->latest()
            ->take(8)
            ->get();

        // July Chart Data Aggregation
        $julyDays = [];
        $julyOrdersData = [];
        $julyUsersData = [];

        for ($day = 1; $day <= 31; $day++) {
            $dateStr = sprintf('2026-07-%02d', $day);
            $julyDays[] = $day . ' Jul';

            $ordersCount = PurchaseOrder::whereDate('created_at', $dateStr)->count();
            $julyOrdersData[] = $ordersCount;

            $usersCount = User::whereDate('created_at', $dateStr)->count();
            $julyUsersData[] = $usersCount;
        }

        return view('admin.b2b_analytics.index', compact(
            'totalB2BRevenue',
            'totalB2BOrders',
            'statusCounts',
            'merchantStats',
            'totalB2BProducts',
            'topMerchants',
            'recentOrders',
            'julyDays',
            'julyOrdersData',
            'julyUsersData'
        ));
    }
}
