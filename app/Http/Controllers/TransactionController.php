<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(Request $request): View
    {
        $user = auth()->user();

        $transactions = Transaction::where('user_id', $user->id)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('transactions.index', compact('transactions'));
    }
}
