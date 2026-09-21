<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPlanController extends Controller
{
    public function index(): View
    {
        $plans = Plan::ordered()->get();

        return view('admin.plans.index', compact('plans'));
    }

    public function edit(Plan $plan): View
    {
        return view('admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'voice_earn_per_session' => 'required|numeric|min:0',
            'word_game_per_word' => 'required|numeric|min:0',
            'referral_commission' => 'required|numeric|min:0',
            'features' => 'required|array',
            'is_popular' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'required|integer|min:0',
        ]);

        $validated['features'] = array_filter($validated['features']);
        $validated['is_popular'] = $request->boolean('is_popular');
        $validated['is_active'] = $request->boolean('is_active');

        $plan->update($validated);

        return redirect()->route('admin.plans.index')
            ->with('toast_message', 'Plan updated successfully.')
            ->with('toast_variant', 'success');
    }

    public function toggle(Plan $plan): RedirectResponse
    {
        $plan->update(['is_active' => ! $plan->is_active]);

        $status = $plan->is_active ? 'activated' : 'deactivated';

        return redirect()->route('admin.plans.index')
            ->with('toast_message', "Plan {$status} successfully.")
            ->with('toast_variant', 'success');
    }
}
