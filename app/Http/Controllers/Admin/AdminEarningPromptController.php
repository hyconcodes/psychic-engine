<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EarningPrompt;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminEarningPromptController extends Controller
{
    public function index(Request $request): View
    {
        $query = EarningPrompt::query()
            ->withCount('submissions');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('language')) {
            $query->where('language', $request->language);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('search')) {
            $query->where('text', 'like', '%'.$request->search.'%');
        }

        $prompts = $query->latest()->paginate(25)->withQueryString();

        $stats = [
            'total' => EarningPrompt::count(),
            'active' => EarningPrompt::where('is_active', true)->count(),
            'inactive' => EarningPrompt::where('is_active', false)->count(),
            'sentences' => EarningPrompt::where('type', 'sentence')->count(),
            'words' => EarningPrompt::where('type', 'word')->count(),
        ];

        $categories = EarningPrompt::whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values();

        return view('admin.prompts.index', compact('prompts', 'stats', 'categories'));
    }

    public function create(): View
    {
        $categories = EarningPrompt::whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values();

        return view('admin.prompts.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|in:sentence,word',
            'language' => 'required|string|max:10',
            'category' => 'nullable|string|max:100',
            'difficulty' => 'required|in:easy,medium,hard',
            'text' => 'required|string|max:500',
        ]);

        $validated['is_active'] = true;
        $validated['created_by'] = auth()->id();

        EarningPrompt::create($validated);

        return redirect()->route('admin.prompts.index')
            ->with('toast_message', 'Prompt created successfully.')
            ->with('toast_variant', 'success');
    }

    public function edit(EarningPrompt $prompt): View
    {
        $categories = EarningPrompt::whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values();

        return view('admin.prompts.edit', compact('prompt', 'categories'));
    }

    public function update(Request $request, EarningPrompt $prompt): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|in:sentence,word',
            'language' => 'required|string|max:10',
            'category' => 'nullable|string|max:100',
            'difficulty' => 'required|in:easy,medium,hard',
            'text' => 'required|string|max:500',
        ]);

        $prompt->update($validated);

        return redirect()->route('admin.prompts.index')
            ->with('toast_message', 'Prompt updated successfully.')
            ->with('toast_variant', 'success');
    }

    public function toggle(EarningPrompt $prompt): RedirectResponse
    {
        $prompt->update(['is_active' => ! $prompt->is_active]);

        $status = $prompt->is_active ? 'activated' : 'deactivated';

        return redirect()->route('admin.prompts.index')
            ->with('toast_message', "Prompt {$status} successfully.")
            ->with('toast_variant', 'success');
    }

    public function bulkImport(): View
    {
        $categories = EarningPrompt::whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values();

        return view('admin.prompts.bulk-import', compact('categories'));
    }

    public function storeBulkImport(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:10240',
            'type' => 'required|in:sentence,word',
            'language' => 'required|string|max:10',
            'category' => 'nullable|string|max:100',
            'difficulty' => 'required|in:easy,medium,hard',
        ]);

        $file = $request->file('csv_file');
        $lines = file($file->getRealPath(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        $created = 0;
        $skipped = 0;

        foreach ($lines as $line) {
            $text = trim($line);

            if ($text === '' || $text === 'text') {
                $skipped++;

                continue;
            }

            $exists = EarningPrompt::where('type', $validated['type'])
                ->where('language', $validated['language'])
                ->where('text', $text)
                ->exists();

            if ($exists) {
                $skipped++;

                continue;
            }

            EarningPrompt::create([
                'type' => $validated['type'],
                'language' => $validated['language'],
                'category' => $validated['category'] ?? null,
                'difficulty' => $validated['difficulty'],
                'text' => $text,
                'is_active' => true,
                'created_by' => auth()->id(),
            ]);

            $created++;
        }

        return redirect()->route('admin.prompts.index')
            ->with('toast_message', "Imported {$created} prompts. {$skipped} skipped (duplicates or empty).")
            ->with('toast_variant', 'success');
    }

    public function destroy(EarningPrompt $prompt): RedirectResponse
    {
        $hasSubmissions = $prompt->submissions()->exists();

        if ($hasSubmissions) {
            $prompt->update(['is_active' => false]);

            return redirect()->route('admin.prompts.index')
                ->with('toast_message', 'Prompt has submissions and was deactivated instead of deleted.')
                ->with('toast_variant', 'warning');
        }

        $prompt->delete();

        return redirect()->route('admin.prompts.index')
            ->with('toast_message', 'Prompt deleted successfully.')
            ->with('toast_variant', 'success');
    }
}
