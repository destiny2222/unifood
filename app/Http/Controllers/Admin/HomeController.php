<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Category;
use App\Models\OrderItem;
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

        $totalOrder = OrderItem::count();
        $PendingOrder = OrderItem::where('order_status', 0)->count();
        $totalDeliveredOrder = OrderItem::where('order_status', 2)->count();
        $CancelOrder = OrderItem::where('order_status', 4)->count();

        $totalProductSale = OrderItem::count();

        // Today's Product Orders
        $todayProductOrders = OrderItem::whereDate('created_at', Carbon::today())->count();

        // This Month's Product Sales
        $thisMonthProductSales = OrderItem::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // This Year's Product Sales
        $thisYearProductSales = OrderItem::whereYear('created_at', Carbon::now()->year)->count();

        // Total Earnings
        $totalEarnings = OrderItem::sum('price');

        // This Month's Earnings
        $thisMonthEarnings = OrderItem::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('price');

        // This Year's Earnings
        $thisYearEarnings = OrderItem::whereYear('created_at', Carbon::now()->year)
            ->sum('price');

        // Today Pending Earnings
        $todayPendingEarnings = OrderItem::where('payment_status', 0)
            ->whereDate('created_at', Carbon::today())
            ->sum('price');

        return view("admin.index", [
            'totalOrder' => $totalOrder,
            'totalDeliveredOrder' => $totalDeliveredOrder,
            'PendingOrder' => $PendingOrder,
            'CancelOrder' => $CancelOrder,
            'totalProductSale' => $totalProductSale,
            'TodayProductOrders' => $todayProductOrders,
            'MonthProductSales' => $thisMonthProductSales,
            'YearProductSales' => $thisYearProductSales,
            'totalEarnings' => $totalEarnings,
            'thisMonthEarnings' => $thisMonthEarnings,
            'thisYearEarnings' => $thisYearEarnings,
            'todayPendingEarnings' => $todayPendingEarnings,
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
