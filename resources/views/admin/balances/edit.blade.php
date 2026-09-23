<x-layouts::app>
    <div class="space-y-5">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.balances.index') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
                <svg class="w-4 h-4 text-text/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-text dark:text-text leading-tight">{{ __('Edit Admin Balance') }}</h2>
                <p class="text-xs text-text/50">{{ __('Update balance record details') }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 p-5 shadow-sm">
            <form method="post" action="{{ route('admin.balances.update', $balance) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="user_id" class="block text-xs font-medium text-text mb-1">{{ __('User') }} <span class="text-red-500">*</span></label>
                    <select name="user_id" id="user_id" required class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3.5 py-2 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                        <option value="">{{ __('Select a user') }}</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $balance->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="amount" class="block text-xs font-medium text-text mb-1">{{ __('Amount (₦)') }} <span class="text-red-500">*</span></label>
                        <input type="number" name="amount" id="amount" value="{{ old('amount', $balance->amount) }}" required min="0" step="0.01" class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3.5 py-2 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    </div>
                    <div>
                        <label for="plan_id" class="block text-xs font-medium text-text mb-1">{{ __('Plan (Optional)') }}</label>
                        <select name="plan_id" id="plan_id" class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3.5 py-2 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                            <option value="">{{ __('No specific plan') }}</option>
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}" {{ old('plan_id', $balance->plan_id) == $plan->id ? 'selected' : '' }}>{{ $plan->name }} (₦{{ $plan->price }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-xs font-medium text-text mb-1">{{ __('Description') }} <span class="text-red-500">*</span></label>
                    <textarea name="description" id="description" rows="3" required class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3.5 py-2 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">{{ old('description', $balance->description) }}</textarea>
                </div>

                <div>
                    <label for="status" class="block text-xs font-medium text-text mb-1">{{ __('Status') }}</label>
                    <select name="status" id="status" class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3.5 py-2 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                        <option value="pending" {{ old('status', $balance->status) == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                        <option value="confirmed" {{ old('status', $balance->status) == 'confirmed' ? 'selected' : '' }}>{{ __('Confirmed') }}</option>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-100 dark:border-neutral-800">
                    <a href="{{ route('admin.balances.index') }}" class="px-3.5 py-2 text-sm font-medium text-text/60 hover:text-text transition-colors">{{ __('Cancel') }}</a>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-gradient-to-r from-primary to-secondary text-white text-sm font-semibold shadow-md shadow-primary/20 hover:from-primary/90 hover:to-secondary/90 transition-all">{{ __('Update Balance') }}</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>
