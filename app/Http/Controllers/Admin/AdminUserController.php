<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EarningSubmission;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query()->with('activeSubscription.plan');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'banned') {
                $query->where('banned_until', '>', now());
            } elseif ($request->status === 'active') {
                $query->where(function ($q) {
                    $q->whereNull('banned_until')->orWhere('banned_until', '<=', now());
                });
            }
        }

        if ($request->filled('plan')) {
            if ($request->plan === 'has_plan') {
                $query->whereHas('activeSubscription');
            } elseif ($request->plan === 'no_plan') {
                $query->whereDoesntHave('activeSubscription');
            }
        }

        $users = $query->latest()->paginate(25)->withQueryString();

        $stats = [
            'total' => User::count(),
            'verified' => User::whereNotNull('email_verified_at')->count(),
            'banned' => User::where('banned_until', '>', now())->count(),
            'with_plan' => User::has('activeSubscription')->count(),
            'with_payout' => User::has('payoutAccount')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    public function show(User $user): View
    {
        $user->load('activeSubscription.plan', 'wallet', 'payoutAccount');

        $submissions = EarningSubmission::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        $transactions = Transaction::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        $referrals = User::where('referred_by', $user->id)
            ->latest()
            ->take(10)
            ->get();

        $totalEarnings = Transaction::where('user_id', $user->id)
            ->where('type', 'earning')
            ->where('status', 'successful')
            ->sum('amount');

        $totalWithdrawn = Transaction::where('user_id', $user->id)
            ->where('type', 'withdrawal')
            ->where('status', 'successful')
            ->sum('amount');

        $totalSubmissions = EarningSubmission::where('user_id', $user->id)->count();

        return view('admin.users.show', compact(
            'user',
            'submissions',
            'transactions',
            'referrals',
            'totalEarnings',
            'totalWithdrawn',
            'totalSubmissions',
        ));
    }

    public function ban(User $user): RedirectResponse
    {
        $user->update(['banned_until' => now()->addWeek()]);

        return redirect()->route('admin.users.show', $user)
            ->with('toast_message', 'User banned for 1 week.')
            ->with('toast_variant', 'warning');
    }

    public function unban(User $user): RedirectResponse
    {
        $user->update(['banned_until' => null]);

        return redirect()->route('admin.users.show', $user)
            ->with('toast_message', 'User unbanned successfully.')
            ->with('toast_variant', 'success');
    }
}
