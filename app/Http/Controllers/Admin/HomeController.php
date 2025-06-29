<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        // order model
        // $order = Order::orderBy('id', 'desc')->first();
        // product model
        // $product = Product::orderBy('id', 'desc')->first();

        // $totalOrder = Order::where('payment_status', 'paid')->count();
        // $PendingOrder = Order::where('payment_status', 'processing')->count();
        // $totalDeliveredOrder = Order::where('order_status', 'delivered')->count();
        // $CancelOrder = Order::where('order_status', 'cancelled')->count();

        // $totalProductSale = $product ? OrderItem::where('product_id', $product->id)->count() : 0;

        // // Today's Product Orders
        // $todayProductOrders = $product ? OrderItem::where('product_id', $product->id)
        //     ->whereDate('created_at', Carbon::today())
        //     ->count() : 0;

        // // This Month's Product Sales
        // $thisMonthProductSales = $product ? OrderItem::where('product_id', $product->id)
        //     ->whereYear('created_at', Carbon::now()->year)
        //     ->whereMonth('created_at', Carbon::now()->month)
        //     ->count() : 0;

        // // This Year's Product Sales
        // $thisYearProductSales = $product ? OrderItem::where('product_id', $product->id)
        //     ->whereYear('created_at', Carbon::now()->year)
        //     ->count() : 0;

        // // Total Earnings for the Product
        // $totalEarnings = $product ? OrderItem::where('product_id', $product->id)
        //     ->sum('price') : 0;

        // // This Month's Earnings
        // $thisMonthEarnings = $product ? OrderItem::where('product_id', $product->id)
        //     ->whereYear('created_at', Carbon::now()->year)
        //     ->whereMonth('created_at', Carbon::now()->month)
        //     ->sum('price') : 0;

        // // This Year's Earnings
        // $thisYearEarnings = $product ? OrderItem::where('product_id', $product->id)
        //     ->whereYear('created_at', Carbon::now()->year)
        //     ->sum('price') : 0;

        // // pending earnings
        // $pendingStatus = 'unpaid';
        // $todayPendingEarnings = $product ? OrderItem::where('product_id', $product->id)
        //     ->whereHas('order', function ($query) use ($pendingStatus) {
        //         $query->where('payment_status', $pendingStatus);
        //     })
        //     ->whereDate('created_at', Carbon::today())
        //     ->sum('price') : 0;

        return view("admin.index", [
            // 'totalOrder' => $totalOrder,
            // 'totalDeliveredOrder' => $totalDeliveredOrder,
            // 'PendingOrder' => $PendingOrder,
            // 'CancelOrder' => $CancelOrder,
            // 'totalProductSale' => $totalProductSale,
            // 'TodayProductOrders' => $todayProductOrders,
            // 'MonthProductSales' => $thisMonthProductSales,
            // 'YearProductSales' => $thisYearProductSales,
            // 'totalEarnings' => $totalEarnings,
            // 'thisMonthEarnings' => $thisMonthEarnings,
            // 'thisYearEarnings' => $thisYearEarnings,
            // 'todayPendingEarnings' => $todayPendingEarnings,
            'totalProduct' => Product::count(),
            'totalCustomer' => User::count(),
            'totalCategories' => Category::count(),
            'usersData' => $this->getUsersData(),
        ]);
    }

    public function settings()
    {
        $admin = Admin::first();
        return view("admin.settings", ['admins' => $admin]);
    }

    public function update(Request $request, $id)
    {
        try {
            $admin = Admin::findOrFail($id);

            // save image
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('upload/admin/'), $image_name);
                $admin->image = $image_name;
            }
            $admin->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
            return back()->with('success', 'Admin updated successfully');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'An error occurred');
        }
    }

    public function updatePassword(Request $request)
    {
        // update password
        try {
            $admin = Admin::first();
            if ($request->new_password == $request->confirm_password) {
                $admin->password = Hash::make($request->new_password);
                $admin->save();
                return back()->with("success", "Password updated successful◘ly");
            } else {
                return back()->with("error", "Passwords do not match");
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with("error", 'An error occurred while updating password');
        }
    }

    public function getUsersData(): array
    {

        
        $usersInJan = $this->usersMonthlyCount('1');
        $usersInFeb = $this->usersMonthlyCount('2');
        $usersInMar = $this->usersMonthlyCount('3');
        $usersInApr = $this->usersMonthlyCount('4');
        $usersInMay = $this->usersMonthlyCount('5');
        $usersInJun = $this->usersMonthlyCount('6');
        $usersInJul = $this->usersMonthlyCount('7');
        $usersInAug = $this->usersMonthlyCount('8');
        $usersInSep = $this->usersMonthlyCount('9');
        $usersInOct = $this->usersMonthlyCount('10');
        $usersInNov = $this->usersMonthlyCount('11');
        $usersInDec = $this->usersMonthlyCount('12');

        // return as array of users
        return [
            $usersInJan,
            $usersInFeb,
            $usersInMar,
            $usersInApr,
            $usersInMay,
            $usersInJun,
            $usersInJul,
            $usersInAug,
            $usersInSep,
            $usersInOct,
            $usersInNov,
            $usersInDec,
        ];
    }

    public function usersMonthlyCount(string $month): int
    {
        $numberOfUsers = DB::table('users')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', now()->format('Y'))
            ->count();

        return $numberOfUsers;
    }
}
