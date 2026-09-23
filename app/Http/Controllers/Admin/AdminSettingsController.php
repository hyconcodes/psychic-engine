<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminSettingsController extends Controller
{
    public function index(): View
    {
        $setting = Setting::firstOrCreate();

        return view('admin.settings.index', compact('setting'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'community_group_link' => 'nullable|url|max:500',
        ]);

        $setting = Setting::firstOrCreate();
        $setting->update($validated);

        return redirect()->route('admin.settings.index')
            ->with('toast_message', 'Settings updated successfully.')
            ->with('toast_variant', 'success');
    }
}
