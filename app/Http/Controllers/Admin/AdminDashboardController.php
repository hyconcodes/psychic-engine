<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminBalance;
use App\Models\AdminPayout;
use App\Models\ContactMessage;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserSubscription;
use App\Models\Wallet;
use App\Models\WithdrawalRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $totalUsers = User::count();
        $activeSubscriptions = UserSubscription::where('status', 'active')->count();
        $totalRevenue = Transaction::where('type', 'plan_purchase')
            ->where('status', 'successful')
            ->sum('amount');
        $pendingWithdrawals = WithdrawalRequest::where('status', 'pending')->count();
        $totalEarnings = Transaction::where('type', 'earning')
            ->where('status', 'successful')
            ->sum('amount');
        $unreadMessages = ContactMessage::whereNull('read_at')->count();

        $thisMonthRevenue = Transaction::where('type', 'plan_purchase')
            ->where('status', 'successful')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        $lastMonthRevenue = Transaction::where('type', 'plan_purchase')
            ->where('status', 'successful')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('amount');

        $thisMonthWithdrawals = WithdrawalRequest::where('status', 'approved')
            ->whereMonth('reviewed_at', now()->month)
            ->whereYear('reviewed_at', now()->year)
            ->sum('amount');

        $totalWalletBalance = Wallet::sum('balance');

        $totalAffiliateCommissions = DB::table('affiliate_commissions')->sum('amount');

        $totalAdminEarned = AdminBalance::sum('amount');
        $adminConfirmedBalance = AdminBalance::where('status', 'confirmed')->sum('amount');
        $adminPendingBalance = AdminBalance::where('status', 'pending')->sum('amount');
        $totalAdminPaidOut = AdminPayout::where('status', 'completed')->sum('amount');

        $recentTransactions = Transaction::with('user')
            ->latest()
            ->take(10)
            ->get();

        $pendingWithdrawalList = WithdrawalRequest::with('user')
            ->where('status', 'pending')
            ->latest('created_at')
            ->take(5)
            ->get();

        $recentUsers = User::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeSubscriptions',
            'totalRevenue',
            'pendingWithdrawals',
            'totalEarnings',
            'unreadMessages',
            'thisMonthRevenue',
            'lastMonthRevenue',
            'thisMonthWithdrawals',
            'totalWalletBalance',
            'totalAffiliateCommissions',
            'totalAdminEarned',
            'adminConfirmedBalance',
            'adminPendingBalance',
            'totalAdminPaidOut',
            'recentTransactions',
            'pendingWithdrawalList',
            'recentUsers',
        ));
    }
}
