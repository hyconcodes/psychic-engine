<x-layouts::app>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
                <svg class="w-4 h-4 text-text/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-text dark:text-text leading-tight">Fund Wallet</h2>
                <p class="text-xs text-text/50">Add funds to start earning</p>
            </div>
        </div>
    </x-slot>

    @php
        $user = auth()->user();
        $hasPlan = $user->hasActivePlan();
    @endphp

    <div class="space-y-5 pb-8" x-data="{ amount: '', quickAmounts: [1000, 2000, 5000, 10000] }">
        {{-- Current Balance --}}
        <div class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 dark:from-neutral-950 dark:via-neutral-900 dark:to-neutral-950 rounded-2xl p-5 relative overflow-hidden shadow-xl">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2 blur-xl"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/4 blur-xl"></div>
            <div class="relative">
                <p class="text-xs text-white/50 mb-1">Your deposit balance</p>
                <p class="text-2xl font-bold text-white" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $balance }}</p>
            </div>
        </div>

        {{-- Funding Form --}}
        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 p-5 shadow-sm">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/></svg>
                </div>
                <h3 class="text-sm font-semibold text-text">Enter amount</h3>
            </div>

            {{-- Quick Amount Buttons --}}
            <div class="grid grid-cols-4 gap-2 mb-4">
                @foreach([1000, 2000, 5000, 10000] as $quick)
                    <button
                        type="button"
                        x-on:click="amount = '{{ $quick }}'"
                        class="py-2.5 rounded-xl border text-sm font-semibold transition-all cursor-pointer"
                        :class="amount == '{{ $quick }}' ? 'bg-primary/10 border-primary text-primary' : 'border-gray-200 dark:border-neutral-700 text-text/60 hover:border-primary/30'"
                    >
                        ₦{{ number_format($quick) }}
                    </button>
                @endforeach
            </div>

            {{-- Amount Input --}}
            <form method="POST" action="{{ route('wallet.fund') }}">
                @csrf
                <div class="relative mb-4">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-text/40 font-semibold">₦</span>
                    <input
                        type="number"
                        name="amount"
                        x-model="amount"
                        min="500"
                        max="500000"
                        placeholder="0"
                        required
                        class="w-full pl-10 pr-4 py-3.5 rounded-xl border border-gray-200 dark:border-neutral-700 bg-gray-50 dark:bg-neutral-800 text-text font-bold text-xl focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all"
                        style="font-family: 'DM Serif Display', Georgia, serif;"
                    >
                </div>

                <p class="text-[11px] text-text/30 mb-4">Minimum ₦500 · Maximum ₦500,000</p>

                {{-- Submit Button --}}
                <button
                    type="submit"
                    class="w-full py-3.5 px-4 rounded-xl bg-gradient-to-r from-primary to-secondary hover:from-primary/90 hover:to-secondary/90 text-white font-semibold transition-all duration-300 shadow-lg shadow-primary/20 hover:shadow-xl hover:shadow-primary/30 flex items-center justify-center gap-2 cursor-pointer"
                    :disabled="!amount || amount < 500"
                    :class="!amount || amount < 500 ? 'opacity-50 cursor-not-allowed' : ''"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                    <span x-text="'Fund Wallet' + (amount && amount >= 500 ? ' — ₦' + Number(amount).toLocaleString() : '')">Fund Wallet</span>
                </button>
            </form>
        </div>

        {{-- Quick Tip --}}
        <div class="bg-primary/5 dark:bg-primary/10 border border-primary/10 rounded-xl p-4">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-primary mb-0.5">Fund your wallet to activate a plan</p>
                    <p class="text-[11px] text-text/40">You need an active plan to unlock Voice Earn and Word Game features. Your wallet balance is used to purchase plans.</p>
                </div>
            </div>
        </div>

        {{-- Transaction History --}}
        <div>
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-sm font-semibold text-text">Recent transactions</h2>
                <a href="{{ route('dashboard') }}#transactions" class="text-xs font-medium text-primary hover:text-primary/80">View all</a>
            </div>
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-8 text-center shadow-sm">
                <div class="w-12 h-12 bg-gray-100 dark:bg-neutral-800 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-text/30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                </div>
                <p class="text-sm font-medium text-text/40">No transactions yet</p>
                <p class="text-[11px] text-text/25 mt-1">Your funding history will appear here</p>
            </div>
        </div>
    </div>
</x-layouts::app>
