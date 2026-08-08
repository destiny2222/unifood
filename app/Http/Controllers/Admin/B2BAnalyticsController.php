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

        // 12-Month Chart Data Aggregation starting from July 2026
        $monthlyLabels = [];
        $monthlyOrdersData = [];
        $monthlyRevenueData = [];

        $monthsList = [
            ['year' => 2026, 'month' => 7, 'label' => 'Jul'],
            ['year' => 2026, 'month' => 8, 'label' => 'Aug'],
            ['year' => 2026, 'month' => 9, 'label' => 'Sep'],
            ['year' => 2026, 'month' => 10, 'label' => 'Oct'],
            ['year' => 2026, 'month' => 11, 'label' => 'Nov'],
            ['year' => 2026, 'month' => 12, 'label' => 'Dec'],
            ['year' => 2027, 'month' => 1, 'label' => 'Jan'],
            ['year' => 2027, 'month' => 2, 'label' => 'Feb'],
            ['year' => 2027, 'month' => 3, 'label' => 'Mar'],
            ['year' => 2027, 'month' => 4, 'label' => 'Apr'],
            ['year' => 2027, 'month' => 5, 'label' => 'May'],
            ['year' => 2027, 'month' => 6, 'label' => 'Jun'],
        ];

        foreach ($monthsList as $m) {
            $monthlyLabels[] = $m['label'];

            $ordersCount = PurchaseOrder::whereYear('created_at', $m['year'])
                ->whereMonth('created_at', $m['month'])
                ->count();
            $monthlyOrdersData[] = $ordersCount;

            $revenueSum = PurchaseOrder::whereNotIn('status', ['cancelled', 'rejected'])
                ->whereYear('created_at', $m['year'])
                ->whereMonth('created_at', $m['month'])
                ->sum('total_amount');
            $monthlyRevenueData[] = (float) $revenueSum;
        }

        return view('admin.b2b_analytics.index', compact(
            'totalB2BRevenue',
            'totalB2BOrders',
            'statusCounts',
            'merchantStats',
            'totalB2BProducts',
            'topMerchants',
            'recentOrders',
            'monthlyLabels',
            'monthlyOrdersData',
            'monthlyRevenueData'
        ));
    }
}
