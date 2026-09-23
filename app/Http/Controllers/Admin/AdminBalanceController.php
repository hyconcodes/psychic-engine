<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminBalance;
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

        $stats = [
            'total' => AdminBalance::count(),
            'pending' => AdminBalance::where('status', 'pending')->count(),
            'confirmed' => AdminBalance::where('status', 'confirmed')->count(),
            'total_balance' => AdminBalance::where('status', 'confirmed')->sum('amount'),
            'pending_balance' => AdminBalance::where('status', 'pending')->sum('amount'),
        ];

        return view('admin.balances.index', compact('balances', 'stats'));
    }

    public function show(AdminBalance $balance): View
    {
        $balance->load(['user', 'plan']);

        return view('admin.balances.show', compact('balance'));
    }

    public function process(AdminBalance $balance): RedirectResponse
    {
        $balance->update([
            'status' => 'confirmed',
            'processed_at' => now(),
        ]);

        return redirect()->route('admin.balances.index')
            ->with('toast_message', 'Admin balance confirmed successfully.')
            ->with('toast_variant', 'success');
    }
}
