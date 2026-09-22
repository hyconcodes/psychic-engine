<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ContactReplyMail;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AdminMessageController extends Controller
{
    public function index(Request $request): View
    {
        $query = ContactMessage::query();

        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->whereNull('read_at');
            } elseif ($request->status === 'read') {
                $query->whereNotNull('read_at');
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $messages = $query->latest()->paginate(25)->withQueryString();

        $stats = [
            'total' => ContactMessage::count(),
            'unread' => ContactMessage::whereNull('read_at')->count(),
            'read' => ContactMessage::whereNotNull('read_at')->count(),
        ];

        return view('admin.messages.index', compact('messages', 'stats'));
    }

    public function show(ContactMessage $message): View
    {
        if (is_null($message->read_at)) {
            $message->update(['read_at' => now()]);
        }

        return view('admin.messages.show', compact('message'));
    }

    public function reply(Request $request, ContactMessage $message): RedirectResponse
    {
        $validated = $request->validate([
            'reply_message' => 'required|string|max:5000',
        ]);

        try {
            Mail::to($message->email)
                ->send(new ContactReplyMail(
                    $message->subject,
                    $message->name,
                    $validated['reply_message'],
                ));

            if (is_null($message->read_at)) {
                $message->update(['read_at' => now()]);
            }

            return redirect()->route('admin.messages.show', $message)
                ->with('toast_message', 'Reply sent successfully to '.$message->email)
                ->with('toast_variant', 'success');
        } catch (\Exception $e) {
            return redirect()->route('admin.messages.show', $message)
                ->with('toast_message', 'Failed to send reply: '.$e->getMessage())
                ->with('toast_variant', 'danger');
        }
    }

    public function destroy(ContactMessage $message): RedirectResponse
    {
        $message->delete();

        return redirect()->route('admin.messages.index')
            ->with('toast_message', 'Message deleted successfully.')
            ->with('toast_variant', 'success');
    }
}
