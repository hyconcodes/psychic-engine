<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminBalance;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminBalanceController extends Controller
{
    public function index(Request $request): View
    {
        $query = AdminBalance::query()->with(['user', 'plan']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($u) use ($search) {
                    $u->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $balances = $query->latest()->paginate(25)->withQueryString();
        $totalBalance = AdminBalance::sum('amount');
        $pendingBalance = AdminBalance::where('status', 'pending')->sum('amount');

        $stats = [
            'total' => AdminBalance::count(),
            'pending' => AdminBalance::where('status', 'pending')->count(),
            'confirmed' => AdminBalance::where('status', 'confirmed')->count(),
            'total_balance' => $totalBalance,
            'pending_balance' => $pendingBalance,
        ];

        return view('admin.balances.index', compact('balances', 'stats'));
    }

    public function create(): View
    {
        $users = User::all();
        $plans = Plan::all();

        return view('admin.balances.create', compact('users', 'plans'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'plan_id' => 'nullable|exists:plans,id',
            'description' => 'required|string|max:255',
            'status' => 'required|in:pending,confirmed',
        ]);

        $balance = AdminBalance::create($validated);

        if ($balance->status === 'confirmed') {
            $balance->update(['processed_at' => now()]);
        }

        return redirect()->route('admin.balances.index')
            ->with('toast_message', 'Admin balance record created successfully.')
            ->with('toast_variant', 'success');
    }

    public function show(AdminBalance $balance): View
    {
        $balance->load(['user', 'plan']);

        return view('admin.balances.show', compact('balance'));
    }

    public function edit(AdminBalance $balance): View
    {
        $users = User::all();
        $plans = Plan::all();

        return view('admin.balances.edit', compact('balance', 'users', 'plans'));
    }

    public function update(Request $request, AdminBalance $balance): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'plan_id' => 'nullable|exists:plans,id',
            'description' => 'required|string|max:255',
            'status' => 'required|in:pending,confirmed',
        ]);

        $balance->update($validated);

        if ($balance->status === 'confirmed' && ! $balance->processed_at) {
            $balance->update(['processed_at' => now()]);
        }

        return redirect()->route('admin.balances.index')
            ->with('toast_message', 'Admin balance record updated successfully.')
            ->with('toast_variant', 'success');
    }

    public function destroy(AdminBalance $balance): RedirectResponse
    {
        $balance->delete();

        return redirect()->route('admin.balances.index')
            ->with('toast_message', 'Admin balance record deleted successfully.')
            ->with('toast_variant', 'success');
    }

    public function process(AdminBalance $balance): RedirectResponse
    {
        $balance->update([
            'status' => 'confirmed',
            'processed_at' => now(),
        ]);

        return redirect()->route('admin.balances.index')
            ->with('toast_message', 'Admin balance processed successfully.')
            ->with('toast_variant', 'success');
    }
}
